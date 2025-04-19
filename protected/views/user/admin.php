<?php
?>

<h1>Kelola User</h1>

<?php echo CHtml::link('Tambah User', array('create'), array('class'=>'btn btn-success')); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'user-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'username',
        array(
            'name'=>'role_id',
            'value'=>'$data->getRoleName()',
            'filter'=>CHtml::listData(Role::model()->findAll(), 'id', 'name'),
        ),
        // array(
        //     'name'=>'created_at',
        //     'value'=>'$data->created_at',
        //     'filter'=>false,
        // ),
        // array(
        //     'name'=>'updated_at',
        //     'value'=>'$data->updated_at ? $data->updated_at : "Belum diperbarui"',
        //     'filter'=>false,
        // ),
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>