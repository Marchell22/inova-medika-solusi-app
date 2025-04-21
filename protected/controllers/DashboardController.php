<?php
class DashboardController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index'),
                'users' => array('@'), // hanya untuk user yang sudah login
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        // Data untuk widget summary boxes
        $summaryData = array(
            array(
                'title' => 'Total Pasien',
                'value' => PendaftaranPasien::model()->count(),
                'icon' => 'user',
                'color' => 'primary'
            ),
            array(
                'title' => 'Total Pegawai',
                'value' => Pegawai::model()->count(),
                'icon' => 'user-md',
                'color' => 'info'
            ),
            array(
                'title' => 'Obat Tersedia',
                'value' => Obat::model()->count(),
                'icon' => 'medkit',
                'color' => 'warning'
            ),
        );



        $this->render('index', array(
            'summaryData' => $summaryData,
        ));
    }
}
