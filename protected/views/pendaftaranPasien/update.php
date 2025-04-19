<?php
/* @var $this PendaftaranPasienController */
/* @var $model PendaftaranPasien */

$this->breadcrumbs=array(
    'Pendaftaran Pasien'=>array('admin'),
    $model->nama_pasien=>array('view','id'=>$model->id),
    'Ubah',
);

$this->menu=array(
    array('label'=>'Lihat Pendaftaran', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Kelola Pendaftaran Pasien', 'url'=>array('admin')),
);
?>

<h1>Ubah Pendaftaran Pasien #<?php echo $model->no_registrasi; ?></h1>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>