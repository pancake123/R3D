<?php
/**
 * @var $this \yii\web\View
 * @var $model app\forms\RegisterForm
 */
?>
<br>
<div class="col-xs-4 col-xs-offset-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            Регистрация
        </div>
        <?php $form = \yii\bootstrap\ActiveForm::begin([
            'action' => [ 'user/register' ]
        ]) ?>
        <div class="panel-body">
            <?= $form->field($model, 'login')->textInput() ?>
            <?= $form->field($model, 'surname')->textInput() ?>
            <?= $form->field($model, 'name')->textInput() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'repeat_password')->passwordInput() ?>
        </div>
        <div class="panel-footer text-center">
            <?= \yii\helpers\Html::submitButton("Отправить", [
                "class" => "btn btn-danger"
            ]) ?>
            <?= \yii\helpers\Html::a('Назад', [ 'site/login' ], [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>
        <?php $form->end() ?>
    </div>
    <?= \app\widgets\FlashMessenger::widget() ?>
</div>