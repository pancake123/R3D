<?php
/**
 * @var $this yii\web\View
 * @var $model app\forms\UserForm
 */
?>
<?= \app\widgets\FlashMessenger::widget() ?>
<div class="col-xs-12">
	<div class="col-xs-5">
		<? $form = \yii\bootstrap\ActiveForm::begin([
			'action' => [ 'user/update' ]
		]);
		print $form->field($model, 'id', [
			'options' => [ 'style' => 'display: none;' ]
		])->hiddenInput();
		print $form->field($model, 'login')->textInput();
		print $form->field($model, 'password')->passwordInput();
		print $form->field($model, 'surname')->textInput();
		print $form->field($model, 'name')->textInput();
		print $form->field($model, 'role_id')->dropDownList($model->listRoles());
		print \yii\helpers\Html::submitButton('Сохранить', [
			'class' => 'btn btn-primary'
		]);
		$form->end() ?>
	</div>
	<div class="col-xs-7"></div>
</div>