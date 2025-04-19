<?php
/**
 * 4.2 _form.php - Form untuk create dan update
 */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields dengan <span class="required">*</span> wajib diisi.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'password'); ?>
        <?php if(!$model->isNewRecord): ?>
        <p class="hint">Biarkan kosong jika tidak ingin mengubah password.</p>
        <?php endif; ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password_repeat'); ?>
        <?php echo $form->passwordField($model,'password_repeat',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'password_repeat'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'role_id'); ?>
        <?php echo $form->dropDownList($model,'role_id', 
            CHtml::listData(Role::model()->findAll(), 'id', 'name'),
            array('prompt'=>'-- Pilih Role --')
        ); ?>
        <?php echo $form->error($model,'role_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->