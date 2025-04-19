<?php
/**
 * Controller untuk manajemen wilayah
 */
class WilayahController extends Controller
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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'),
                'users' => array('@'),
            ),
            array('deny',  // tolak untuk semua pengguna lain
                'users' => array('*'),
            ),
        );
    }

    /**
     * Menampilkan single model wilayah
     * @param integer $id ID dari model yang akan ditampilkan
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Membuat wilayah baru
     */
    public function actionCreate()
    {
        $model = new Wilayah;

        // Form telah disubmit dan validasi berhasil
        if (isset($_POST['Wilayah'])) {
            $model->attributes = $_POST['Wilayah'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Wilayah berhasil ditambahkan.');
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', 'Gagal menambahkan wilayah.');
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Memperbarui wilayah yang sudah ada
     * @param integer $id ID dari model yang akan diubah
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Form telah disubmit dan validasi berhasil
        if (isset($_POST['Wilayah'])) {
            $model->attributes = $_POST['Wilayah'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Wilayah berhasil diperbarui.');
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', 'Gagal memperbarui wilayah.');
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
            $model = $this->loadModel($id);
            
            // Periksa apakah wilayah sedang digunakan oleh data lain
            $used = false; // implementasikan fungsi pengecekan di sini jika perlu
            
            if ($used) {
                Yii::app()->user->setFlash('error', 'Wilayah tidak dapat dihapus karena sedang digunakan.');
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
            
            try {
                if ($model->delete()) {
                    Yii::app()->user->setFlash('success', 'Wilayah berhasil dihapus.');
                } else {
                    Yii::app()->user->setFlash('error', 'Gagal menghapus wilayah.');
                }
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', 'Gagal menghapus wilayah: ' . $e->getMessage());
            }

            // jika ini adalah permintaan AJAX, tidak perlu redirect
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Permintaan tidak valid. Silakan jangan ulangi permintaan ini lagi.');
        }
    }

    /**
     * Mengelola semua model wilayah
     */
    public function actionAdmin()
    {
        $model = new Wilayah('search');
        $model->unsetAttributes();  // hapus nilai default
        
        if (isset($_GET['Wilayah'])) {
            $model->attributes = $_GET['Wilayah'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Mengembalikan data model berdasarkan primary key
     * @param integer $id ID dari model yang akan dimuat
     * @return Wilayah model yang dimuat
     * @throws CHttpException jika model tidak ditemukan
     */
    public function loadModel($id)
    {
        $model = Wilayah::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Halaman yang diminta tidak ditemukan.');
        }
        return $model;
    }

    /**
     * Performs validation on AJAX request
     * @param Wilayah $model model yang akan divalidasi
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'wilayah-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}