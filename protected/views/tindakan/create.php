<?php
/* @var $this TindakanController */
/* @var $model Tindakan */

$this->breadcrumbs=array(
    'Tindakan'=>array('admin'),
    'Tambah',
);

$this->menu=array(
    array('label'=>'Kelola Tindakan', 'url'=>array('admin')),
);
?>

<h1>Tambah Tindakan Baru</h1>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>