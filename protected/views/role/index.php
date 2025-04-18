<?php
// File: protected/views/role/index.php
/* @var $this RoleController */
/* @var $roles Role[] */

$this->breadcrumbs = array(
    'Daftar Role',
);
?>

<h1>Manajemen Role</h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<div class="action-buttons">
    <?php echo CHtml::link('Tambah Role Baru', array('create'), array('class'=>'btn btn-success')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'role-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'name',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'update' => array(
                    'label' => 'Edit',
                    'imageUrl' => false,
                    'options' => array('class' => 'btn-edit'),
                ),
                'delete' => array(
                    'label' => 'Hapus',
                    'imageUrl' => false,
                    'options' => array('class' => 'btn-delete'),
                    'click' => 'function() {
                        if(!confirm("Apakah Anda yakin ingin menghapus role ini?")) return false;
                        return true;
                    }',
                ),
            ),
        ),
    ),
)); ?>

<style>
    .grid-view table.items th a {
    color: #000; /* Ubah warna link menjadi hitam */
    text-decoration: none;
}

.grid-view table.items th a:hover {
    color: #333; /* Warna link saat hover */
    text-decoration: underline;
}

/* Pastikan warna header tetap hitam bahkan saat sorting */
.grid-view table.items th a.asc,
.grid-view table.items th a.desc {
    color: #000;
}
.grid-view table.items th {
    background: #f5f5f5;
    color: #000; /* Ubah warna teks menjadi hitam */
    font-weight: bold;
}

.flash-success {
    background-color: #dff0d8;
    border: 1px solid #d6e9c6;
    color: #3c763d;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.action-buttons {
    margin-bottom: 20px;
}

.btn-success {
    background-color: #5cb85c;
    color: white;
    padding: 8px 16px;
    text-decoration: none;
    border-radius: 4px;
    display: inline-block;
}

.btn-success:hover {
    background-color: #4cae4c;
}

.btn-edit {
    background-color: #f0ad4e;
    color: white;
    padding: 3px 8px;
    text-decoration: none;
    border-radius: 3px;
    margin-right: 5px;
}

.btn-edit:hover {
    background-color: #eea236;
    color: white;
}

.btn-delete {
    background-color: #d9534f;
    color: white;
    padding: 3px 8px;
    text-decoration: none;
    border-radius: 3px;
}

.btn-delete:hover {
    background-color: #c9302c;
    color: white;
}

.grid-view {
    padding-top: 0;
}

.grid-view table.items {
    width: 100%;
    border-collapse: collapse;
    background: white;
    margin-top: 10px;
}

.grid-view table.items th, 
.grid-view table.items td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

.grid-view table.items th {
    background: #f5f5f5;
    color: #333;
}

.grid-view table.items tr:hover {
    background-color: #f9f9f9;
}

.grid-view .button-column {
    text-align: center;
    width: 120px;
}
</style>