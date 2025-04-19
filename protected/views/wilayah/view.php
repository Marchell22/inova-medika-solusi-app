<?php
/* @var $this WilayahController */
/* @var $model Wilayah */

$this->breadcrumbs=array(
    'Manajemen Wilayah'=>array('admin'),
    $model->nama_wilayah,
);

$this->menu=array(
    array('label'=>'Tambah Wilayah Baru', 'url'=>array('create')),
    array('label'=>'Ubah Wilayah', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Hapus Wilayah', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Apakah Anda yakin ingin menghapus wilayah ini?')),
    array('label'=>'Kelola Wilayah', 'url'=>array('admin')),
);
?>

<h1>Detail Wilayah <?php echo $model->nama_wilayah; ?></h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'kode',
        'nama_wilayah',
        'created_at',
        'updated_at',
    ),
)); ?>