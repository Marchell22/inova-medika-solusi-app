<?php
/* @var $this ObatController */
/* @var $model Obat */

$this->breadcrumbs=array(
    'Obat'=>array('admin'),
    $model->nama=>array('view','id'=>$model->id),
    'Ubah',
);

$this->menu=array(
    array('label'=>'Lihat Obat', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Kelola Obat', 'url'=>array('admin')),
);
?>

<h1>Ubah Obat <?php echo $model->nama; ?></h1>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>