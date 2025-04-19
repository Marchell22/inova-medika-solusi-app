<?php
/* @var $this PendaftaranPasienController */
/* @var $model PendaftaranPasien */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'pendaftaran-pasien-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <p class="note">Kolom dengan <span class="required">*</span> wajib diisi.</p>

    <?php echo $form->errorSummary($model); ?>

    <fieldset>
        <legend>Informasi Pendaftaran</legend>
        
        <?php if (!$model->isNewRecord): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'no_registrasi'); ?>
            <?php echo $form->textField($model,'no_registrasi',array('size'=>20,'maxlength'=>20,'readonly'=>true)); ?>
            <?php echo $form->error($model,'no_registrasi'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'tanggal_pendaftaran'); ?>
            <?php echo $form->textField($model,'tanggal_pendaftaran',array('readonly'=>true)); ?>
            <?php echo $form->error($model,'tanggal_pendaftaran'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'waktu_pendaftaran'); ?>
            <?php echo $form->textField($model,'waktu_pendaftaran',array('readonly'=>true)); ?>
            <?php echo $form->error($model,'waktu_pendaftaran'); ?>
        </div>
        <?php endif; ?>
    </fieldset>

    <fieldset>
        <legend>Identitas Pasien</legend>
        
        <div class="row">
            <?php echo $form->labelEx($model,'nama_pasien'); ?>
            <?php echo $form->textField($model,'nama_pasien',array('size'=>60,'maxlength'=>100)); ?>
            <?php echo $form->error($model,'nama_pasien'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'tanggal_lahir'); ?>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model,
                'attribute'=>'tanggal_lahir',
                'options'=>array(
                    'showAnim'=>'fold',
                    'dateFormat'=>'yy-mm-dd',
                    'changeMonth'=>true,
                    'changeYear'=>true,
                    'yearRange'=>'-100:+0',
                ),
                'htmlOptions'=>array(
                    'class'=>'form-control',
                ),
            )); ?>
            <?php echo $form->error($model,'tanggal_lahir'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'jenis_kelamin'); ?>
            <?php echo $form->radioButtonList($model,'jenis_kelamin',PendaftaranPasien::getJenisKelaminOptions()); ?>
            <?php echo $form->error($model,'jenis_kelamin'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'no_identitas'); ?>
            <?php echo $form->textField($model,'no_identitas',array('size'=>20,'maxlength'=>20)); ?>
            <?php echo $form->error($model,'no_identitas'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'no_telepon'); ?>
            <?php echo $form->textField($model,'no_telepon',array('size'=>15,'maxlength'=>15)); ?>
            <?php echo $form->error($model,'no_telepon'); ?>
        </div>
    </fieldset>

    <fieldset>
        <legend>Alamat Pasien</legend>
        
        <div class="row">
            <?php echo $form->labelEx($model,'wilayah_id'); ?>
            <?php echo $form->dropDownList($model,'wilayah_id',
                CHtml::listData(Wilayah::model()->findAll(array('order'=>'nama_wilayah')), 'id', 'nama_wilayah'),
                array('empty'=>'- Pilih Wilayah -')); ?>
            <?php echo $form->error($model,'wilayah_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'alamat_lengkap'); ?>
            <?php echo $form->textArea($model,'alamat_lengkap',array('rows'=>3, 'cols'=>50)); ?>
            <?php echo $form->error($model,'alamat_lengkap'); ?>
        </div>
    </fieldset>

    <fieldset>
        <legend>Informasi Kunjungan</legend>
        
        <div class="row">
            <?php echo $form->labelEx($model,'jenis_kunjungan'); ?>
            <?php echo $form->radioButtonList($model,'jenis_kunjungan',PendaftaranPasien::getJenisKunjunganOptions()); ?>
            <?php echo $form->error($model,'jenis_kunjungan'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'dokter_id'); ?>
            <?php echo $form->dropDownList($model,'dokter_id',
                CHtml::listData(Pegawai::model()->findAll(array('order'=>'nama')), 'id', 'nama'),
                array('empty'=>'- Pilih Dokter -')); ?>
            <?php echo $form->error($model,'dokter_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'keluhan'); ?>
            <?php echo $form->textArea($model,'keluhan',array('rows'=>5, 'cols'=>50)); ?>
            <?php echo $form->error($model,'keluhan'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'status_kunjungan'); ?>
            <?php echo $form->dropDownList($model,'status_kunjungan',PendaftaranPasien::getStatusKunjunganOptions()); ?>
            <?php echo $form->error($model,'status_kunjungan'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Daftar' : 'Simpan', array('class'=>'btn-primary')); ?>
        <?php echo CHtml::link('Batal', array('admin'), array('class'=>'btn-default')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<style>
fieldset {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
}

legend {
    font-weight: bold;
    font-size: 14px;
    padding: 0 10px;
}

.row {
    margin-bottom: 10px;
}

.btn-primary {
    background-color: #4CAF50;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin-right: 10px;
}

.btn-default {
    background-color: #f1f1f1;
    color: #333;
    padding: 8px 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
}

.btn-primary:hover {
    background-color: #45a049;
}

.btn-default:hover {
    background-color: #e7e7e7;
}
</style>