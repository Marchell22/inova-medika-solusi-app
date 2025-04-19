<?php
/* @var $this ObatController */
/* @var $model Obat */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'obat-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <p class="note">Kolom dengan <span class="required">*</span> wajib diisi.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'kode'); ?>
        <?php echo $form->textField($model,'kode',array('size'=>20,'maxlength'=>20)); ?>
        <?php echo $form->error($model,'kode'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'nama'); ?>
        <?php echo $form->textField($model,'nama',array('size'=>60,'maxlength'=>100)); ?>
        <?php echo $form->error($model,'nama'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'harga'); ?>
        <?php echo $form->textField($model,'harga',array('size'=>15,'maxlength'=>15)); ?>
        <?php echo $form->error($model,'harga'); ?>
        <p class="hint">Contoh: 5000 (tanpa Rp atau tanda koma)</p>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Tambah' : 'Simpan'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->