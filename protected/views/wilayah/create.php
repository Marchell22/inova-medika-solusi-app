<?php
/* @var $this WilayahController */
/* @var $model Wilayah */

$this->breadcrumbs=array(
    'Manajemen Wilayah'=>array('admin'),
    'Tambah',
);

$this->menu=array(
    array('label'=>'Kelola Wilayah', 'url'=>array('admin')),
);
?>

<h1>Tambah Wilayah Baru</h1>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>