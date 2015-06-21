<?php
/**
 * @var $this \yii\web\View
 * @var $model app\forms\LoginForm
 */
?>
<br>
<div class="col-xs-4 col-xs-offset-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            Вход
        </div>
        <div class="panel-body">
            <?php $form = \yii\bootstrap\ActiveForm::begin([
                'action' => [ 'user/login' ]
            ]) ?>
            <?= $form->field($model, 'login')->textInput() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= \yii\helpers\Html::submitButton("Войти", [
                "class" => "btn btn-danger"
            ]) ?>
            <?= \yii\helpers\Html::a('Регистрация', [ 'site/register' ], [
                'class' => 'btn btn-primary'
            ]) ?>
            <?php $form->end() ?>
        </div>
    </div>
    <?= \app\widgets\FlashMessenger::widget() ?>
</div>