<?php
/**
 * Controller untuk manajemen obat
 */
class ObatController extends Controller
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
     * Menampilkan single model obat
     * @param integer $id ID dari model yang akan ditampilkan
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Membuat obat baru
     */
    public function actionCreate()
    {
        $model = new Obat;

        // Form telah disubmit dan validasi berhasil
        if (isset($_POST['Obat'])) {
            $model->attributes = $_POST['Obat'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Obat berhasil ditambahkan.');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Memperbarui obat yang sudah ada
     * @param integer $id ID dari model yang akan diubah
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Form telah disubmit dan validasi berhasil
        if (isset($_POST['Obat'])) {
            $model->attributes = $_POST['Obat'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Obat berhasil diperbarui.');
                $this->redirect(array('view', 'id' => $model->id));
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
     * Mengelola semua model obat
     */
    public function actionAdmin()
    {
        $model = new Obat('search');
        $model->unsetAttributes();  // hapus nilai default
        
        if (isset($_GET['Obat'])) {
            $model->attributes = $_GET['Obat'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Mengembalikan data model berdasarkan primary key
     * @param integer $id ID dari model yang akan dimuat
     * @return Obat model yang dimuat
     * @throws CHttpException jika model tidak ditemukan
     */
    public function loadModel($id)
    {
        $model = Obat::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Halaman yang diminta tidak ditemukan.');
        }
        return $model;
    }

    /**
     * Performs validation on AJAX request
     * @param Obat $model model yang akan divalidasi
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'obat-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}