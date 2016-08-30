<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHangTool | Login</title>

    <link href="/res/css/bootstrap.min.css" rel="stylesheet">
    <link href="/res/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/res/css/animate.css" rel="stylesheet">
    <link href="/res/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <img src="/res/img/LogoCompany.png" width="300px"/>
            </div>
            <h3>Welcome to ZINZA CHangTool</h3>

            <p>You must login first!!</p>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="/res/js/jquery-2.1.1.js"></script>
    <script src="/res/js/bootstrap.min.js"></script>

</body>

</html>
