<?php
/* @var $this PegawaiController */
/* @var $model Pegawai */
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
        <?php echo $form->label($model,'nip'); ?>
        <?php echo $form->textField($model,'nip',array('size'=>20,'maxlength'=>20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'nama'); ?>
        <?php echo $form->textField($model,'nama',array('size'=>60,'maxlength'=>100)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'posisi'); ?>
        <?php echo $form->textField($model,'posisi',array('size'=>50,'maxlength'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status',
            array_merge(array(''=>'- Pilih Status -'), Pegawai::getStatusOptions()),
            array('class'=>'form-control')); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Cari'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->