<?php
/* @var $this PendaftaranPasienController */
/* @var $model PendaftaranPasien */

$this->breadcrumbs=array(
    'Pendaftaran Pasien'=>array('admin'),
    'Tambah',
);

$this->menu=array(
    array('label'=>'Kelola Pendaftaran Pasien', 'url'=>array('admin')),
);
?>

<h1>Pendaftaran Pasien Baru</h1>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>