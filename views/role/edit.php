<?php
/**
 * @var $this yii\web\View
 * @var $model app\forms\RoleForm
 */
?>
<?= \app\widgets\FlashMessenger::widget([
	'key' => null
]) ?>
<div class="col-xs-12">
	<div class="col-xs-5">
		<? $form = \yii\bootstrap\ActiveForm::begin([
			'action' => [ 'role/update' ]
		]);
		print $form->field($model, 'id', [
			'options' => [ 'style' => 'display: none;' ]
		])->hiddenInput();
		print $form->field($model, 'name')->textInput();
		print $form->field($model, 'permissions')->checkboxList($model->listPermissions());
		print \yii\helpers\Html::submitButton('Сохранить', [
			'class' => 'btn btn-primary'
		]);
		$form->end() ?>
	</div>
	<div class="col-xs-7"></div>
</div>