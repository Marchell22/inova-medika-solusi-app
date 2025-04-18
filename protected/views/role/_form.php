<?php
// File: protected/views/role/_form.php
/* @var $this RoleController */
/* @var $model Role */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'role-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Kolom dengan <span class="required">*</span> harus diisi.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>64)); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($mode == 'create' ? 'Tambah' : 'Simpan', array('class'=>'btn btn-primary')); ?>
        <?php echo CHtml::link('Kembali', array('index'), array('class'=>'btn btn-default')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<style>
.form {
    max-width: 500px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.note {
    margin-bottom: 15px;
    color: #666;
    font-style: italic;
}

.required {
    color: red;
}

.row {
    margin-bottom: 15px;
}

.row label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.row input[type="text"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

.errorSummary {
    background-color: #f2dede;
    border: 1px solid #ebccd1;
    color: #a94442;
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.errorSummary p {
    font-weight: bold;
    margin-top: 0;
}

.errorSummary ul {
    margin-bottom: 0;
}

.error {
    color: #a94442;
    font-size: 12px;
    display: block;
    margin-top: 5px;
}

.buttons {
    margin-top: 20px;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
    text-decoration: none;
    margin-right: 10px;
}

.btn-primary {
    background-color: #337ab7;
    color: white;
    border: none;
}

.btn-primary:hover {
    background-color: #286090;
}

.btn-default {
    background-color: #f5f5f5;
    color: #333;
    border: 1px solid #ddd;
}

.btn-default:hover {
    background-color: #e6e6e6;
}
</style>