<?php
/* @var $this PegawaiController */
/* @var $model Pegawai */
/* @var $form CActiveForm */
?>

<div class="form">

<?php 
// Validasi NIP hanya saat pengguna selesai mengetik dan focus keluar dari field
Yii::app()->clientScript->registerScript('nipCheck', "
    // Validasi hanya saat tombol Submit ditekan
    var validateNip = false;
    
    $('#Pegawai_nip').blur(function(){
        // Validasi hanya jika user sudah mulai submit form
        if (validateNip) {
            checkNipAvailability();
        }
    });
    
    // Set flag validasi saat form disubmit
    $('#pegawai-form').submit(function() {
        validateNip = true;
        checkNipAvailability();
    });
    
    function checkNipAvailability() {
        var nip = $('#Pegawai_nip').val();
        var id = $('#pegawai-form').data('modelId');
        
        if (nip != '') {
            $.ajax({
                type: 'POST',
                url: '".Yii::app()->createUrl('/pegawai/checkNip')."',
                data: {nip: nip, id: id},
                dataType: 'json',
                async: false, // Penting untuk memastikan validasi selesai sebelum form disubmit
                success: function(data) {
                    if (!data.available) {
                        $('#nip-error').html(data.message).show();
                        // Batalkan submit jika NIP tidak tersedia
                        event.preventDefault();
                    } else {
                        $('#nip-error').hide();
                    }
                }
            });
        }
    }
", CClientScript::POS_READY);
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'pegawai-form',
    'enableAjaxValidation'=>false, // Matikan validasi AJAX bawaan
    'enableClientValidation'=>false, // Matikan validasi client-side bawaan
    'htmlOptions'=>array('data-model-id'=>$model->id),
)); ?>

    <p class="note">Kolom dengan <span class="required">*</span> wajib diisi.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'nip'); ?>
        <?php echo $form->textField($model,'nip',array('size'=>20,'maxlength'=>20)); ?>
        <?php echo $form->error($model,'nip'); ?>
        <div id="nip-error" class="errorMessage" style="display:none;"></div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'nama'); ?>
        <?php echo $form->textField($model,'nama',array('size'=>60,'maxlength'=>100)); ?>
        <?php echo $form->error($model,'nama'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'posisi'); ?>
        <?php echo $form->textField($model,'posisi',array('size'=>50,'maxlength'=>50)); ?>
        <?php echo $form->error($model,'posisi'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status',
            Pegawai::getStatusOptions(),
            array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Tambah' : 'Simpan'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->