<?php
/* @var $this TindakanController */
/* @var $model Tindakan */

$this->breadcrumbs=array(
    'Tindakan'=>array('admin'),
    $model->nama=>array('view','id'=>$model->id),
    'Ubah',
);

$this->menu=array(
    array('label'=>'Lihat Tindakan', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Kelola Tindakan', 'url'=>array('admin')),
);
?>

<h1>Ubah Tindakan <?php echo $model->nama; ?></h1>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>