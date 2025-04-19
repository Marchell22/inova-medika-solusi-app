<?php
/* @var $this PegawaiController */
/* @var $model Pegawai */

$this->breadcrumbs=array(
    'Pegawai'=>array('admin'),
    'Tambah',
);

$this->menu=array(
    array('label'=>'Kelola Pegawai', 'url'=>array('admin')),
);
?>

<h1>Tambah Pegawai Baru</h1>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>