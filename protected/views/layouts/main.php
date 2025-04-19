<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
		media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
		media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

	<div class="container" id="page">

		<div id="header">
			<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
		</div><!-- header -->

		<div id="mainmenu">
			<?php $this->widget('zii.widgets.CMenu', array(
				'items' => array(
					array('label' => 'Home', 'url' => array('/site/index')),
					// array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					// array('label'=>'Contact', 'url'=>array('/site/contact')),
					array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
					array('label' => 'Role', 'url' => array('/role'), 'visible' => !Yii::app()->user->isGuest && User::model()->findByPk(Yii::app()->user->id)->role_id == 1),
					array('label' => 'Akun Pengguna', 'url' => array('/user'), 'visible' => !Yii::app()->user->isGuest && User::model()->findByPk(Yii::app()->user->id)->role_id == 1),
					array('label' => 'Wilayah', 'url' => array('/wilayah'), 'visible' => !Yii::app()->user->isGuest && User::model()->findByPk(Yii::app()->user->id)->role_id == 1),
					array('label' => 'Pegawai', 'url' => array('/pegawai'), 'visible' => !Yii::app()->user->isGuest && User::model()->findByPk(Yii::app()->user->id)->role_id == 1),
					array('label' => 'Tindakan', 'url' => array('/tindakan'), 'visible' => !Yii::app()->user->isGuest && User::model()->findByPk(Yii::app()->user->id)->role_id == 1),
					array('label' => 'Obat', 'url' => array('/obat'), 'visible' => !Yii::app()->user->isGuest && User::model()->findByPk(Yii::app()->user->id)->role_id == 1),
					array('label' => 'Pendaftaran Pasien', 'url' => array('/pendaftaranPasien'), 'visible' => !Yii::app()->user->isGuest && User::model()->findByPk(Yii::app()->user->id)->role_id == 3),
					array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
				),
			)); ?>
		</div><!-- mainmenu -->
		<?php if (isset($this->breadcrumbs)): ?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links' => $this->breadcrumbs,
			)); ?><!-- breadcrumbs -->
		<?php endif ?>

		<?php echo $content; ?>

		<div class="clear"></div>

		<div id="footer">
			Copyright &copy; <?php echo date('Y'); ?> by My Company.<br />
			All Rights Reserved.<br />
			<?php echo Yii::powered(); ?>
		</div><!-- footer -->

	</div><!-- page -->

</body>

</html>