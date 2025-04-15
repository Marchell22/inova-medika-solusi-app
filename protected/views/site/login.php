<div class="login-container">
    <div class="login-box">
        <h2>Login Sistem</h2>
        
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        )); ?>
        
        <div class="form-group">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'Masukkan username')); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
        
        <div class="form-group">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'Masukkan password')); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
        
        <div class="form-group remember-me">
            <?php echo $form->checkBox($model, 'rememberMe'); ?>
            <?php echo $form->label($model, 'rememberMe', array('class' => 'remember-label')); ?>
        </div>
        
        <div class="form-group buttons">
            <?php echo CHtml::submitButton('Login', array('class' => 'btn-login')); ?>
        </div>
        
        <?php $this->endWidget(); ?>
    </div>
</div>
<style>
/* CSS untuk tampilan login */
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
    background-color: #f7f7f7;
}

.login-box {
    width: 350px;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.login-box h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
    font-weight: 500;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #555;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
    transition: border-color 0.3s;
}

.form-control:focus {
    border-color: #66afe9;
    outline: 0;
    box-shadow: 0 0 5px rgba(102, 175, 233, 0.5);
}

.remember-me {
    display: flex;
    align-items: center;
}

.remember-label {
    display: inline !important;
    margin-left: 5px;
}

.errorMessage {
    color: #d9534f;
    font-size: 12px;
    margin-top: 5px;
}

.btn-login {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #337ab7;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-login:hover {
    background-color: #286090;
}

/* Responsive styling */
@media (max-width: 480px) {
    .login-box {
        width: 100%;
        padding: 20px;
    }
}
</style>