<?php
/**
 * Controller untuk manajemen pegawai
 */
class PegawaiController extends Controller
{
    /**
     * @var string filter default
     */
    public $defaultAction = 'admin';

    /**
     * @return array pengaturan kontrol akses
     */
    public function accessRules()
    {
        return array(
            array('allow', // izinkan untuk pengguna yang sudah login
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'checkNip'),
                'users' => array('@'),
            ),
            array('deny',  // tolak untuk semua pengguna lain
                'users' => array('*'),
            ),
        );
    }

    /**
     * Menampilkan single model pegawai
     * @param integer $id ID dari model yang akan ditampilkan
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Membuat pegawai baru
     */
    public function actionCreate()
    {
        $model = new Pegawai;

        // Cek semua NIP yang ada - untuk debugging
        $existingNips = Pegawai::getExistingNips();
        Yii::log('Existing NIPs: ' . implode(', ', $existingNips), 'info');

        // Form telah disubmit dan validasi berhasil
        if (isset($_POST['Pegawai'])) {
            $model->attributes = $_POST['Pegawai'];
            
            // Cek dulu secara manual apakah NIP sudah ada
            $duplicateNip = Pegawai::model()->findByAttributes(array('nip' => $model->nip));
            
            if ($duplicateNip) {
                $model->addError('nip', 'NIP "'.$model->nip.'" sudah digunakan oleh pegawai lain.');
                Yii::log('Duplicate NIP detected: ' . $model->nip, 'error');
            } else {
                // Tidak ada duplikat, coba simpan
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Pegawai berhasil ditambahkan.');
                    $this->redirect(array('view', 'id' => $model->id));
                } else {
                    Yii::log('Error saving model: ' . var_export($model->getErrors(), true), 'error');
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Action untuk memeriksa ketersediaan NIP via AJAX
     */
    public function actionCheckNip() 
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['nip'])) {
            $nip = $_POST['nip'];
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            
            $criteria = new CDbCriteria;
            $criteria->condition = 'nip=:nip';
            $criteria->params = array(':nip' => $nip);
            
            if ($id) {
                // Untuk kasus update, kecualikan ID saat ini
                $criteria->condition .= ' AND id!=:id';
                $criteria->params[':id'] = $id;
            }
            
            $count = Pegawai::model()->count($criteria);
            
            echo CJSON::encode(array(
                'available' => ($count == 0),
                'message' => ($count > 0) ? 'NIP "'.$nip.'" sudah digunakan.' : 'NIP tersedia.'
            ));
            Yii::app()->end();
        }
    }

    /**
     * Memperbarui pegawai yang sudah ada
     * @param integer $id ID dari model yang akan diubah
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Form telah disubmit dan validasi berhasil
        if (isset($_POST['Pegawai'])) {
            $originalNip = $model->nip; // Simpan NIP asli
            $model->attributes = $_POST['Pegawai'];
            
            // Jika NIP berubah, cek apakah NIP baru sudah digunakan
            if ($originalNip != $model->nip) {
                $duplicateNip = Pegawai::model()->findByAttributes(array('nip' => $model->nip));
                
                if ($duplicateNip && $duplicateNip->id != $model->id) {
                    $model->addError('nip', 'NIP "'.$model->nip.'" sudah digunakan oleh pegawai lain.');
                    Yii::log('Duplicate NIP detected on update: ' . $model->nip, 'error');
                } else {
                    if ($model->save()) {
                        Yii::app()->user->setFlash('success', 'Pegawai berhasil diperbarui.');
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                }
            } else {
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Pegawai berhasil diperbarui.');
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Menghapus sebuah model
     * @param integer $id ID dari model yang akan dihapus
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // hanya menerima permintaan POST
            $this->loadModel($id)->delete();

            // jika ini adalah permintaan AJAX, tidak perlu redirect
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Permintaan tidak valid. Silakan jangan ulangi permintaan ini lagi.');
        }
    }

    /**
     * Mengelola semua model pegawai
     */
    public function actionAdmin()
    {
        $model = new Pegawai('search');
        $model->unsetAttributes();  // hapus nilai default
        
        if (isset($_GET['Pegawai'])) {
            $model->attributes = $_GET['Pegawai'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Mengembalikan data model berdasarkan primary key
     * @param integer $id ID dari model yang akan dimuat
     * @return Pegawai model yang dimuat
     * @throws CHttpException jika model tidak ditemukan
     */
    public function loadModel($id)
    {
        $model = Pegawai::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Halaman yang diminta tidak ditemukan.');
        }
        return $model;
    }

    /**
     * Performs validation on AJAX request
     * @param Pegawai $model model yang akan divalidasi
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pegawai-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}