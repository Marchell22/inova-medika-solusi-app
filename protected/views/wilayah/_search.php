<?php
/* @var $this WilayahController */
/* @var $model Wilayah */
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
        <?php echo $form->textField($model,'kode',array('size'=>10,'maxlength'=>10)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'nama_wilayah'); ?>
        <?php echo $form->textField($model,'nama_wilayah',array('size'=>60,'maxlength'=>100)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'created_at'); ?>
        <?php echo $form->textField($model,'created_at'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'updated_at'); ?>
        <?php echo $form->textField($model,'updated_at'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Cari'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->