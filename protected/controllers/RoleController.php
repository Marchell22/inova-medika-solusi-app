<?php
// File: protected/controllers/RoleController.php

class RoleController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Access rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'create', 'update', 'delete'),
                'users' => array('@'), // Hanya user yang sudah login
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    /**
     * Daftar semua role
     */
    public function actionIndex()
    {
        $model = new Role('search');
        $model->unsetAttributes();  // clear any default values
        
        if(isset($_GET['Role']))
            $model->attributes = $_GET['Role'];
            
        $this->render('index', array(
            'model' => $model,
        ));
    }
    
    /**
     * Tambah role baru
     */
    public function actionCreate()
    {
        $model = new Role;

        if(isset($_POST['Role']))
        {
            $model->attributes = $_POST['Role'];
            if($model->save())
            {
                Yii::app()->user->setFlash('success', 'Role berhasil ditambahkan');
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }
    
    /**
     * Update role
     * @param integer $id ID role yang akan diupdate
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if(isset($_POST['Role']))
        {
            $model->attributes = $_POST['Role'];
            if($model->save())
            {
                Yii::app()->user->setFlash('success', 'Role berhasil diupdate');
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
    
    /**
     * Hapus role
     * @param integer $id ID role yang akan dihapus
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        
        // Jika request AJAX, jangan redirect
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }
    
    /**
     * Load model Role berdasarkan ID
     * @param integer $id ID role yang akan diload
     * @return Role model
     */
    protected function loadModel($id)
    {
        $model = Role::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404, 'Role yang diminta tidak ditemukan.');
        return $model;
    }
}
