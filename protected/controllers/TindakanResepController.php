<?php
/**
 * Controller untuk manajemen tindakan dan resep pasien
 */
class TindakanResepController extends Controller
{
    /**
     * @var string filter default
     */
    public $defaultAction = 'index';

    /**
     * @return array pengaturan kontrol akses
     */
    public function accessRules()
    {
        return array(
            array(
                'allow', // izinkan untuk pengguna yang sudah login
                'actions' => array('index', 'daftarPasien', 'form', 'save', 'getTindakan', 'getObat', 'addTindakanRow', 'addObatRow'),
                'users' => array('@'),
            ),
            array(
                'deny',  // tolak untuk semua pengguna lain
                'users' => array('*'),
            ),
        );
    }

    /**
     * Action untuk menampilkan halaman utama
     */
    public function actionIndex()
    {
        $this->actionDaftarPasien();
    }

    /**
     * Action untuk menampilkan daftar pasien
     */
    public function actionDaftarPasien()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = "status_kunjungan IN ('Menunggu', 'Proses')";
        $criteria->order = 'tanggal_pendaftaran DESC, waktu_pendaftaran DESC';

        // Filter berdasarkan tanggal pendaftaran
        // $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
        // if (!empty($tanggal)) {
        //     $criteria->addCondition('tanggal_pendaftaran = :tanggal');
        //     $criteria->params[':tanggal'] = $tanggal;
        // }

        $pasien = PendaftaranPasien::model()->findAll($criteria);

        $this->render('daftar_pasien', array(
            'pasien' => $pasien,
            // 'tanggal' => $tanggal, // Pastikan variabel ini dikirim ke view
        ));
    }
    /**
     * Action untuk menampilkan form tindakan dan resep
     * @param integer $id ID pendaftaran pasien
     */
    public function actionForm($id)
    {
        $pendaftaran = PendaftaranPasien::model()->findByPk($id);
        if (!$pendaftaran) {
            throw new CHttpException(404, 'Pendaftaran pasien tidak ditemukan.');
        }

        // Update status kunjungan menjadi 'Proses'
        if ($pendaftaran->status_kunjungan == 'Menunggu') {
            $pendaftaran->status_kunjungan = 'Proses';
            $pendaftaran->save(false);
        }

        // Ambil data tindakan yang sudah ada
        $tindakanPasien = TindakanPasien::model()->findAll('pendaftaran_id=:pendaftaranId', array(':pendaftaranId' => $id));

        // Ambil atau buat resep baru
        $resep = Resep::model()->find('pendaftaran_id=:pendaftaranId', array(':pendaftaranId' => $id));
        if (!$resep) {
            $resep = new Resep;
            $resep->pendaftaran_id = $id;
            $resep->tanggal_resep = date('Y-m-d');
            $resep->save(false);
        }

        // Ambil detail resep
        $resepDetails = ResepDetail::model()->findAll('resep_id=:resepId', array(':resepId' => $resep->id));

        $this->render('form', array(
            'pendaftaran' => $pendaftaran,
            'tindakanPasien' => $tindakanPasien,
            'resep' => $resep,
            'resepDetails' => $resepDetails,
        ));
    }

    /**
     * Action untuk menyimpan data tindakan dan resep
     */
    public function actionSave()
    {
        if (isset($_POST['pendaftaran_id'])) {
            $pendaftaranId = $_POST['pendaftaran_id'];
            $pendaftaran = PendaftaranPasien::model()->findByPk($pendaftaranId);

            if (!$pendaftaran) {
                throw new CHttpException(404, 'Pendaftaran pasien tidak ditemukan.');
            }

            // Mulai transaksi database
            $transaction = Yii::app()->db->beginTransaction();

            try {
                // Simpan tindakan pasien
                $totalBiayaTindakan = 0;

                // Hapus tindakan lama
                TindakanPasien::model()->deleteAll('pendaftaran_id=:pendaftaranId', array(':pendaftaranId' => $pendaftaranId));

                // Simpan tindakan baru
                if (isset($_POST['tindakan_id']) && is_array($_POST['tindakan_id'])) {
                    foreach ($_POST['tindakan_id'] as $key => $tindakanId) {
                        if (!empty($tindakanId)) {
                            $tindakan = new TindakanPasien;
                            $tindakan->pendaftaran_id = $pendaftaranId;
                            $tindakan->tindakan_id = $tindakanId;
                            $tindakan->catatan = isset($_POST['tindakan_catatan'][$key]) ? $_POST['tindakan_catatan'][$key] : '';

                            if ($tindakan->save()) {
                                $tindakanData = Tindakan::model()->findByPk($tindakanId);
                                if ($tindakanData) {
                                    $totalBiayaTindakan += $tindakanData->tarif;
                                }
                            }
                        }
                    }
                }

                // Simpan diagnosis di resep
                $resep = Resep::model()->find('pendaftaran_id=:pendaftaranId', array(':pendaftaranId' => $pendaftaranId));
                if (!$resep) {
                    $resep = new Resep;
                    $resep->pendaftaran_id = $pendaftaranId;
                    $resep->tanggal_resep = date('Y-m-d');
                }

                $resep->diagnosis = isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '';
                $resep->save(false);

                // Hapus detail resep lama
                ResepDetail::model()->deleteAll('resep_id=:resepId', array(':resepId' => $resep->id));

                // Simpan detail resep baru
                $totalBiayaResep = 0;

                if (isset($_POST['obat_id']) && is_array($_POST['obat_id'])) {
                    foreach ($_POST['obat_id'] as $key => $obatId) {
                        if (!empty($obatId)) {
                            $detail = new ResepDetail;
                            $detail->resep_id = $resep->id;
                            $detail->obat_id = $obatId;
                            $detail->jumlah = isset($_POST['obat_jumlah'][$key]) ? $_POST['obat_jumlah'][$key] : 1;
                            $detail->dosis = isset($_POST['obat_dosis'][$key]) ? $_POST['obat_dosis'][$key] : '';
                            $detail->keterangan = isset($_POST['obat_keterangan'][$key]) ? $_POST['obat_keterangan'][$key] : '';

                            if ($detail->save()) {
                                $totalBiayaResep += $detail->subtotal;
                            }
                        }
                    }
                }

                // Update total biaya di pendaftaran
                $pendaftaran->total_biaya_tindakan = $totalBiayaTindakan;
                $pendaftaran->total_biaya_resep = $totalBiayaResep;
                $pendaftaran->total_biaya = $totalBiayaTindakan + $totalBiayaResep;

                // Update status tindakan resep dan status kunjungan
                $pendaftaran->status_tindakan_resep = 'Selesai';

                if (isset($_POST['status_kunjungan'])) {
                    $pendaftaran->status_kunjungan = $_POST['status_kunjungan'];
                }

                if ($pendaftaran->save(false)) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data tindakan dan resep berhasil disimpan.');
                    $this->redirect(array('daftarPasien'));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', 'Gagal menyimpan data tindakan dan resep.');
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }

            $this->redirect(array('form', 'id' => $pendaftaranId));
        }
    }

    /**
     * Action untuk mendapatkan data tindakan dalam format JSON
     */
    public function actionGetTindakan()
    {
        $term = isset($_GET['term']) ? $_GET['term'] : '';

        // Jika term kosong, tampilkan semua data
        if (empty($term)) {
            $tindakan = Tindakan::model()->findAll(array(
                'order' => 'nama ASC',
                'limit' => 50, // Batasi jumlah untuk performa
            ));
        } else {
            // Jika ada term, cari yang sesuai
            $tindakan = Tindakan::model()->findAll(array(
                'condition' => 'nama LIKE :term',
                'params' => array(':term' => '%' . $term . '%'),
                'order' => 'nama ASC',
                'limit' => 20,
            ));
        }

        $result = array();
        foreach ($tindakan as $data) {
            $result[] = array(
                'id' => $data->id,
                'label' => $data->nama,
                'value' => $data->nama,
                'tarif' => $data->tarif,
            );
        }

        echo CJSON::encode($result);
        Yii::app()->end();
    }

    /**
     * Action untuk mendapatkan data obat dalam format JSON
     */
    public function actionGetObat()
    {
        $term = isset($_GET['term']) ? $_GET['term'] : '';

        // Jika term kosong, tampilkan semua data
        if (empty($term)) {
            $obat = Obat::model()->findAll(array(
                'order' => 'nama ASC',
                'limit' => 50, // Batasi jumlah untuk performa
            ));
        } else {
            // Jika ada term, cari yang sesuai
            $obat = Obat::model()->findAll(array(
                'condition' => 'nama LIKE :term',
                'params' => array(':term' => '%' . $term . '%'),
                'order' => 'nama ASC',
                'limit' => 20,
            ));
        }

        $result = array();
        foreach ($obat as $data) {
            $result[] = array(
                'id' => $data->id,
                'label' => $data->nama,
                'value' => $data->nama,
                'harga' => $data->harga,
            );
        }

        echo CJSON::encode($result);
        Yii::app()->end();
    }

    /**
     * Action untuk menambahkan baris tindakan (melalui AJAX)
     */
    public function actionAddTindakanRow()
    {
        $index = isset($_GET['index']) ? $_GET['index'] : 0;
        $this->renderPartial('_tindakan_row', array('index' => $index));
    }

    /**
     * Action untuk menambahkan baris obat (melalui AJAX)
     */
    public function actionAddObatRow()
    {
        $index = isset($_GET['index']) ? $_GET['index'] : 0;
        $this->renderPartial('_obat_row', array('index' => $index));
    }
}