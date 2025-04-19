<?php
/* @var $this PegawaiController */
/* @var $model Pegawai */

$this->breadcrumbs=array(
    'Pegawai'=>array('admin'),
    $model->nama=>array('view','id'=>$model->id),
    'Ubah',
);

$this->menu=array(
    array('label'=>'Lihat Pegawai', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Kelola Pegawai', 'url'=>array('admin')),
);
?>

<h1>Ubah Pegawai <?php echo $model->nama; ?></h1>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>