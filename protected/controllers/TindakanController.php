<?php
/**
 * Controller untuk manajemen tindakan
 */
class TindakanController extends Controller
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
     * Menampilkan single model tindakan
     * @param integer $id ID dari model yang akan ditampilkan
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Membuat tindakan baru
     */
    public function actionCreate()
    {
        $model = new Tindakan;

        // Form telah disubmit dan validasi berhasil
        if (isset($_POST['Tindakan'])) {
            $model->attributes = $_POST['Tindakan'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Tindakan berhasil ditambahkan.');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Memperbarui tindakan yang sudah ada
     * @param integer $id ID dari model yang akan diubah
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Form telah disubmit dan validasi berhasil
        if (isset($_POST['Tindakan'])) {
            $model->attributes = $_POST['Tindakan'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Tindakan berhasil diperbarui.');
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
     * Mengelola semua model tindakan
     */
    public function actionAdmin()
    {
        $model = new Tindakan('search');
        $model->unsetAttributes();  // hapus nilai default
        
        if (isset($_GET['Tindakan'])) {
            $model->attributes = $_GET['Tindakan'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Mengembalikan data model berdasarkan primary key
     * @param integer $id ID dari model yang akan dimuat
     * @return Tindakan model yang dimuat
     * @throws CHttpException jika model tidak ditemukan
     */
    public function loadModel($id)
    {
        $model = Tindakan::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Halaman yang diminta tidak ditemukan.');
        }
        return $model;
    }

    /**
     * Performs validation on AJAX request
     * @param Tindakan $model model yang akan divalidasi
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tindakan-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}