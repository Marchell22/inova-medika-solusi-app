<?php
/* @var $this ObatController */
/* @var $model Obat */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'id'); ?>
        <?php echo $form->textField($model,'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'kode'); ?>
        <?php echo $form->textField($model,'kode',array('size'=>20,'maxlength'=>20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'nama'); ?>
        <?php echo $form->textField($model,'nama',array('size'=>60,'maxlength'=>100)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'harga'); ?>
        <?php echo $form->textField($model,'harga'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'created_at'); ?>
        <?php echo $form->textField($model,'created_at'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Cari'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->