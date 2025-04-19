<?php
/* @var $this ObatController */
/* @var $model Obat */

$this->breadcrumbs=array(
    'Obat'=>array('admin'),
    'Tambah',
);

$this->menu=array(
    array('label'=>'Kelola Obat', 'url'=>array('admin')),
);
?>

<h1>Tambah Obat Baru</h1>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>