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
                'value' => '1,250',
                'icon' => 'user',
                'color' => 'primary'
            ),
            array(
                'title' => 'Kunjungan Hari Ini',
                'value' => '28',
                'icon' => 'calendar',
                'color' => 'success'
            ),
            array(
                'title' => 'Dokter Aktif',
                'value' => '8',
                'icon' => 'user-md',
                'color' => 'info'
            ),
            array(
                'title' => 'Obat Tersedia',
                'value' => '124',
                'icon' => 'medkit',
                'color' => 'warning'
            ),
        );

        // Data untuk aktivitas terbaru
        $recentActivities = array(
            array(
                'type' => 'registration',
                'description' => 'Pasien baru terdaftar',
                'name' => 'Budi Santoso',
                'time' => '5 menit yang lalu',
            ),
            array(
                'type' => 'appointment',
                'description' => 'Janji temu dengan dokter',
                'name' => 'Dr. Siti Aminah',
                'time' => '30 menit yang lalu',
            ),
            array(
                'type' => 'payment',
                'description' => 'Pembayaran diterima',
                'name' => 'Rp 500.000',
                'time' => '1 jam yang lalu',
            ),
            array(
                'type' => 'medicine',
                'description' => 'Obat diserahkan kepada pasien',
                'name' => 'Ani Wijaya',
                'time' => '3 jam yang lalu',
            ),
        );

        $this->render('index', array(
            'summaryData' => $summaryData,
            'recentActivities' => $recentActivities,
        ));
    }
}
