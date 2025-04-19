<?php
/* @var $this WilayahController */
/* @var $model Wilayah */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'wilayah-form',
    'enableAjaxValidation'=>true,
)); ?>

    <p class="note">Kolom dengan <span class="required">*</span> wajib diisi.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'kode'); ?>
        <?php echo $form->textField($model,'kode',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo $form->error($model,'kode'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'nama_wilayah'); ?>
        <?php echo $form->textField($model,'nama_wilayah',array('size'=>60,'maxlength'=>100)); ?>
        <?php echo $form->error($model,'nama_wilayah'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Tambah' : 'Simpan'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->