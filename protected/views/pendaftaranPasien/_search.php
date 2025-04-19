<?php
/* @var $this PendaftaranPasienController */
/* @var $model PendaftaranPasien */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'no_registrasi'); ?>
        <?php echo $form->textField($model,'no_registrasi',array('size'=>20,'maxlength'=>20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'tanggal_pendaftaran'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,
            'attribute'=>'tanggal_pendaftaran',
            'options'=>array(
                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
                'changeMonth'=>true,
                'changeYear'=>true,
            ),
            'htmlOptions'=>array(
                'class'=>'form-control',
            ),
        )); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'nama_pasien'); ?>
        <?php echo $form->textField($model,'nama_pasien',array('size'=>60,'maxlength'=>100)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'jenis_kelamin'); ?>
        <?php echo $form->dropDownList($model,'jenis_kelamin',
            array_merge(array(''=>'- Semua -'), PendaftaranPasien::getJenisKelaminOptions())); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'no_telepon'); ?>
        <?php echo $form->textField($model,'no_telepon',array('size'=>15,'maxlength'=>15)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'wilayah_id'); ?>
        <?php echo $form->dropDownList($model,'wilayah_id',
            array_merge(array(''=>'- Semua -'), CHtml::listData(Wilayah::model()->findAll(array('order'=>'nama_wilayah')), 'id', 'nama_wilayah'))); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'jenis_kunjungan'); ?>
        <?php echo $form->dropDownList($model,'jenis_kunjungan',
            array_merge(array(''=>'- Semua -'), PendaftaranPasien::getJenisKunjunganOptions())); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'dokter_id'); ?>
        <?php echo $form->dropDownList($model,'dokter_id',
            array_merge(array(''=>'- Semua -'), CHtml::listData(Pegawai::model()->findAll(array('order'=>'nama')), 'id', 'nama'))); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'status_kunjungan'); ?>
        <?php echo $form->dropDownList($model,'status_kunjungan',
            array_merge(array(''=>'- Semua -'), PendaftaranPasien::getStatusKunjunganOptions())); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Cari', array('class'=>'btn-primary')); ?>
        <?php echo CHtml::resetButton('Reset', array('class'=>'btn-default')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->

<style>
.wide.form .row {
    margin-bottom: 10px;
}

.btn-primary {
    background-color: #4CAF50;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-default {
    background-color: #f1f1f1;
    color: #333;
    padding: 8px 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #45a049;
}

.btn-default:hover {
    background-color: #e7e7e7;
}
</style>