<?php
/* @var $this PegawaiController */
/* @var $model Pegawai */

$this->breadcrumbs=array(
    'Pegawai'=>array('admin'),
    $model->nama,
);

$this->menu=array(
    array('label'=>'Tambah Pegawai Baru', 'url'=>array('create')),
    array('label'=>'Ubah Pegawai', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Hapus Pegawai', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Apakah Anda yakin ingin menghapus pegawai ini?')),
    array('label'=>'Kelola Pegawai', 'url'=>array('admin')),
);
?>

<h1>Detail Pegawai <?php echo $model->nama; ?></h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'nip',
        'nama',
        'posisi',
        'status',
        'created_at',
    ),
)); ?>