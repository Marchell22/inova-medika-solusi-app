<?php
/* @var $this PendaftaranPasienController */
/* @var $model PendaftaranPasien */

$this->breadcrumbs=array(
    'Pendaftaran Pasien'=>array('admin'),
    $model->nama_pasien,
);

$this->menu=array(
    array('label'=>'Pendaftaran Pasien Baru', 'url'=>array('create')),
    array('label'=>'Ubah Pendaftaran', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Hapus Pendaftaran', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Apakah Anda yakin ingin menghapus pendaftaran ini?')),
    array('label'=>'Kelola Pendaftaran Pasien', 'url'=>array('admin')),
);
?>

<h1>Detail Pendaftaran Pasien #<?php echo $model->no_registrasi; ?></h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<div class="detail-view-container">
    <fieldset>
        <legend>Informasi Pendaftaran</legend>
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                'no_registrasi',
                'tanggal_pendaftaran',
                'waktu_pendaftaran',
                array(
                    'name'=>'status_kunjungan',
                    'value'=>$model->status_kunjungan,
                    'cssClass'=>'status-'.$model->status_kunjungan,
                ),
                'created_at',
                'updated_at',
            ),
        )); ?>
    </fieldset>

    <fieldset>
        <legend>Identitas Pasien</legend>
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                'nama_pasien',
                'tanggal_lahir',
                'jenis_kelamin',
                'no_identitas',
                'no_telepon',
            ),
        )); ?>
    </fieldset>

    <fieldset>
        <legend>Alamat Pasien</legend>
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                array(
                    'name'=>'wilayah_id',
                    'value'=>$model->wilayah ? $model->wilayah->nama_wilayah : '-',
                ),
                'alamat_lengkap',
            ),
        )); ?>
    </fieldset>

    <fieldset>
        <legend>Informasi Kunjungan</legend>
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                'jenis_kunjungan',
                array(
                    'name'=>'dokter_id',
                    'value'=>$model->dokter ? $model->dokter->nama : '-',
                ),
                'keluhan',
            ),
        )); ?>
    </fieldset>
</div>

<style>
.detail-view-container fieldset {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
}

.detail-view-container legend {
    font-weight: bold;
    font-size: 14px;
    padding: 0 10px;
}

.detail-view {
    width: 100%;
}

.status-Menunggu {
    color: #f39c12;
    font-weight: bold;
}

.status-Proses {
    color: #3498db;
    font-weight: bold;
}

.status-Selesai {
    color: #27ae60;
    font-weight: bold;
}
</style>