<?php
/**
 * @var $this yii\web\View
 * @var $model app\forms\PermissionForm
 */
?>
<?= \app\widgets\FlashMessenger::widget([
	'key' => null
]) ?>
<div class="col-xs-12">
	<div class="col-xs-5">
		<? $form = \yii\bootstrap\ActiveForm::begin([
			'action' => [ 'permission/update' ]
		]);
		print $form->field($model, 'id')->textInput();
		print $form->field($model, 'name')->textInput();
		print \yii\helpers\Html::submitButton('Сохранить', [
			'class' => 'btn btn-primary'
		]);
		$form->end() ?>
	</div>
	<div class="col-xs-7"></div>
</div>