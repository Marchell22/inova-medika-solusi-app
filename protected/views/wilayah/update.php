<?php
/* @var $this WilayahController */
/* @var $model Wilayah */

$this->breadcrumbs=array(
    'Manajemen Wilayah'=>array('admin'),
    $model->nama_wilayah=>array('view','id'=>$model->id),
    'Ubah',
);

$this->menu=array(
    array('label'=>'Lihat Wilayah', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Kelola Wilayah', 'url'=>array('admin')),
);
?>

<h1>Ubah Wilayah <?php echo $model->nama_wilayah; ?></h1>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>