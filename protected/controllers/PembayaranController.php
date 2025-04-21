<?php
/**
 * Controller untuk manajemen pembayaran tagihan pasien
 */
class PembayaranController extends Controller
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
            array('allow', // izinkan untuk pengguna yang sudah login
                'actions' => array('index', 'detail', 'bayar', 'kwitansi', 'riwayat'),
                'users' => array('@'),
            ),
            array('deny',  // tolak untuk semua pengguna lain
                'users' => array('*'),
            ),
        );
    }

    /**
     * Action untuk menampilkan daftar tagihan pasien
     */
    public function actionIndex()
    {
        // Menampilkan daftar pasien yang memiliki tagihan belum dibayar
        $criteria = new CDbCriteria;
        
        // Ambil pasien yang sudah selesai tindakan & resep tapi belum bayar
        $criteria->condition = "status_kunjungan = 'Selesai' AND status_tindakan_resep = 'Selesai' AND (status_pembayaran IS NULL OR status_pembayaran = 'Belum')";
        $criteria->order = 'tanggal_pendaftaran DESC';
        
        // Pencarian berdasarkan parameter
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $query = $_GET['query'];
            $criteria->addSearchCondition('no_registrasi', $query, true, 'OR');
            $criteria->addSearchCondition('nama_pasien', $query, true, 'OR');
        }
        
        // Filter berdasarkan tanggal
        if (isset($_GET['tanggal']) && !empty($_GET['tanggal'])) {
            $criteria->addCondition('tanggal_pendaftaran = :tanggal');
            $criteria->params[':tanggal'] = $_GET['tanggal'];
        }
        
        $pasien = PendaftaranPasien::model()->findAll($criteria);
        
        $this->render('index', array(
            'pasien' => $pasien,
            'tanggal' => isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'),
            'query' => isset($_GET['query']) ? $_GET['query'] : '',
        ));
    }
    
    /**
     * Action untuk melihat detail tagihan pasien
     * @param integer $id ID pendaftaran pasien
     */
    public function actionDetail($id)
    {
        // Menampilkan detail tagihan pasien
        $pendaftaran = PendaftaranPasien::model()->findByPk($id);
        if (!$pendaftaran) {
            throw new CHttpException(404, 'Pendaftaran pasien tidak ditemukan.');
        }
        
        // Ambil tindakan pasien
        $tindakan = TindakanPasien::model()->with('tindakan')->findAll('pendaftaran_id=:pid', array(':pid' => $id));
        
        // Ambil resep dan detail obat
        $resep = Resep::model()->find('pendaftaran_id=:pid', array(':pid' => $id));
        $obat = array();
        if ($resep) {
            $obat = ResepDetail::model()->with('obat')->findAll('resep_id=:rid', array(':rid' => $resep->id));
        }
        
        // Buat model pembayaran untuk form
        $model = new Pembayaran;
        $model->pendaftaran_id = $id;
        $model->total_tagihan = $pendaftaran->total_biaya;
        $model->total_dibayar = $pendaftaran->total_biaya;
        $model->petugas_id = Yii::app()->user->id; // Asumsi ID petugas sama dengan user ID
        
        $this->render('detail', array(
            'pendaftaran' => $pendaftaran,
            'tindakan' => $tindakan,
            'obat' => $obat,
            'model' => $model,
        ));
    }
    
    /**
     * Action untuk memproses pembayaran
     */
    public function actionBayar()
    {
        if (isset($_POST['Pembayaran'])) {
            $model = new Pembayaran;
            $model->attributes = $_POST['Pembayaran'];
            
            // Hitung kembalian
            $model->kembalian = max(0, $model->total_dibayar - $model->total_tagihan);
            
            // Proses pembayaran
            if ($model->save()) {
                // Update status pembayaran pasien
                $pendaftaran = PendaftaranPasien::model()->findByPk($model->pendaftaran_id);
                if ($pendaftaran) {
                    $pendaftaran->status_pembayaran = 'Lunas';
                    $pendaftaran->save(false);
                }
                
                Yii::app()->user->setFlash('success', 'Pembayaran berhasil disimpan.');
                $this->redirect(array('kwitansi', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', 'Gagal menyimpan pembayaran: ' . print_r($model->getErrors(), true));
                $this->redirect(array('detail', 'id' => $model->pendaftaran_id));
            }
        } else {
            $this->redirect(array('index'));
        }
    }
    
    /**
     * Action untuk menampilkan/mencetak kwitansi pembayaran
     * @param integer $id ID pembayaran
     */
    public function actionKwitansi($id)
    {
        // Ambil data pembayaran
        $pembayaran = Pembayaran::model()->with('pendaftaran', 'petugas')->findByPk($id);
        if (!$pembayaran) {
            throw new CHttpException(404, 'Pembayaran tidak ditemukan.');
        }
        
        // Ambil tindakan pasien
        $tindakan = TindakanPasien::model()->with('tindakan')->findAll('pendaftaran_id=:pid', 
            array(':pid' => $pembayaran->pendaftaran_id));
        
        // Ambil resep dan detail obat
        $resep = Resep::model()->find('pendaftaran_id=:pid', 
            array(':pid' => $pembayaran->pendaftaran_id));
        $obat = array();
        if ($resep) {
            $obat = ResepDetail::model()->with('obat')->findAll('resep_id=:rid', 
                array(':rid' => $resep->id));
        }
        
        $this->render('kwitansi', array(
            'pembayaran' => $pembayaran,
            'tindakan' => $tindakan,
            'obat' => $obat,
        ));
    }
    
    /**
     * Action untuk melihat riwayat pembayaran
     */
    public function actionRiwayat()
    {
        // Menampilkan daftar pembayaran yang sudah dilakukan
        $criteria = new CDbCriteria;
        $criteria->with = array('pendaftaran');
        $criteria->order = 'tanggal_bayar DESC, t.id DESC';
        
        // Filter berdasarkan tanggal
        if (isset($_GET['tanggal']) && !empty($_GET['tanggal'])) {
            $criteria->addCondition('tanggal_bayar = :tanggal');
            $criteria->params[':tanggal'] = $_GET['tanggal'];
        }
        
        // Pencarian berdasarkan parameter
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $query = $_GET['query'];
            $criteria->addSearchCondition('pendaftaran.no_registrasi', $query, true, 'OR');
            $criteria->addSearchCondition('pendaftaran.nama_pasien', $query, true, 'OR');
        }
        
        $pembayaran = Pembayaran::model()->findAll($criteria);
        
        $this->render('riwayat', array(
            'pembayaran' => $pembayaran,
            'tanggal' => isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'),
            'query' => isset($_GET['query']) ? $_GET['query'] : '',
        ));
    }
}