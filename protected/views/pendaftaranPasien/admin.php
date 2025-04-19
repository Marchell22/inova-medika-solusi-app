<?php
/* @var $this PendaftaranPasienController */
/* @var $model PendaftaranPasien */

$this->breadcrumbs=array(
    'Pendaftaran Pasien'=>array('admin'),
    'Kelola',
);

// Menambahkan CSS inline
Yii::app()->clientScript->registerCSS('createButton', "
.create-button {
    display: inline-block;
    padding: 8px 15px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
    margin-bottom: 15px;
}

.create-button:hover {
    background-color: #45a049;
    text-decoration: none;
    color: white;
}

.actions {
    margin: 15px 0;
}
");

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#pendaftaran-pasien-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Kelola Pendaftaran Pasien</h1>

<div class="actions">
    <?php echo CHtml::link('Pendaftaran Pasien Baru', array('create'), array('class'=>'create-button')); ?>
</div>

<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<p>
Anda dapat memasukkan operator perbandingan (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
atau <b>=</b>) di awal setiap nilai pencarian untuk menentukan bagaimana perbandingan harus dilakukan.
</p>

<?php echo CHtml::link('Pencarian Lanjutan','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'pendaftaran-pasien-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'no_registrasi',
        'tanggal_pendaftaran',
        'nama_pasien',
        array(
            'name'=>'jenis_kelamin',
            'filter'=>PendaftaranPasien::getJenisKelaminOptions(),
        ),
        array(
            'name'=>'jenis_kunjungan',
            'filter'=>PendaftaranPasien::getJenisKunjunganOptions(),
        ),
        array(
            'name'=>'status_kunjungan',
            'filter'=>PendaftaranPasien::getStatusKunjunganOptions(),
            'htmlOptions'=>array('style'=>'width: 100px;'),
        ),
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>