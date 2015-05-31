<?php
/**
 * @var $this \yii\web\View
 * @var $login app\forms\LoginForm
 * @var $register app\forms\RegisterForm
 */
?>
<div class="col-xs-12">
	<div class="col-xs-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Вход
			</div>
			<div class="panel-body">
				<?php $form = \yii\bootstrap\ActiveForm::begin([
					'action' => [ 'user/login' ]
				]) ?>
				<?= $form->field($login, 'login')->textInput() ?>
				<?= $form->field($login, 'password')->passwordInput() ?>
				<?= \yii\helpers\Html::submitButton("Войти", [
					"class" => "btn btn-danger"
				]) ?>
				<?php $form->end() ?>
			</div>
		</div>
		<?= \app\widgets\FlashMessenger::widget() ?>
	</div>
	<div class="col-xs-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Регистрация
			</div>
			<div class="panel-body">
				<?php $form = \yii\bootstrap\ActiveForm::begin([
					'action' => [ 'user/register' ]
				]) ?>
				<?= $form->field($register, 'login')->textInput() ?>
				<?= $form->field($register, 'surname')->textInput() ?>
				<?= $form->field($register, 'name')->textInput() ?>
				<?= $form->field($register, 'password')->passwordInput() ?>
				<?= $form->field($register, 'repeat_password')->passwordInput() ?>
				<?= \yii\helpers\Html::submitButton("Отправить", [
					"class" => "btn btn-primary"
				]) ?>
				<?php $form->end() ?>
			</div>
		</div>
		<?= \app\widgets\FlashMessenger::widget() ?>
	</div>
</div>