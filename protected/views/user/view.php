<?php
/**
 * 4.5 view.php - View untuk detail user
 */
?>

<h1>Detail User #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'username',
        array(
            'name'=>'role_id',
            'value'=>$model->getRoleName(),
        ),
        'created_at',
        'updated_at',
    ),
)); ?>

<div class="row buttons">
    <?php echo CHtml::link('Update', array('update', 'id'=>$model->id), array('class'=>'btn btn-primary')); ?>
    <?php echo CHtml::linkButton('Delete', array(
        'submit'=>array('delete', 'id'=>$model->id),
        'confirm'=>'Apakah Anda yakin ingin menghapus item ini?',
        'class'=>'btn btn-danger'
    )); ?>
</div>