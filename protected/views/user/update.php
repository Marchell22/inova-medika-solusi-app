
<?php
/**
 * 4.4 update.php - View untuk update
 */
?>

<h1>Update User <?php echo $model->username; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>