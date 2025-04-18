<?php
// File: protected/views/role/update.php
/* @var $this RoleController */
/* @var $model Role */
?>

<h1>Edit Role #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'mode'=>'update')); ?>