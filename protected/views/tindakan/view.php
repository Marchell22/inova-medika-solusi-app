<?php
/* @var $this TindakanController */
/* @var $model Tindakan */

$this->breadcrumbs=array(
    'Tindakan'=>array('admin'),
    $model->nama,
);

$this->menu=array(
    array('label'=>'Tambah Tindakan Baru', 'url'=>array('create')),
    array('label'=>'Ubah Tindakan', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Hapus Tindakan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Apakah Anda yakin ingin menghapus tindakan ini?')),
    array('label'=>'Kelola Tindakan', 'url'=>array('admin')),
);
?>

<h1>Detail Tindakan <?php echo $model->nama; ?></h1>

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
        'nama',
        array(
            'name'=>'tarif',
            'value'=>$model->getFormattedTarif(),
        ),
        'created_at',
    ),
)); ?>