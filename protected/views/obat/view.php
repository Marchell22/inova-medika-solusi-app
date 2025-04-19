<?php
/* @var $this ObatController */
/* @var $model Obat */

$this->breadcrumbs=array(
    'Obat'=>array('admin'),
    $model->nama,
);

$this->menu=array(
    array('label'=>'Tambah Obat Baru', 'url'=>array('create')),
    array('label'=>'Ubah Obat', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Hapus Obat', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Apakah Anda yakin ingin menghapus obat ini?')),
    array('label'=>'Kelola Obat', 'url'=>array('admin')),
);
?>

<h1>Detail Obat <?php echo $model->nama; ?></h1>

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
            'name'=>'harga',
            'value'=>$model->getFormattedHarga(),
        ),
        'created_at',
    ),
)); ?>