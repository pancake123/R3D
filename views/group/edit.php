<?php
/**
 * @var $this yii\web\View
 * @var $model app\forms\GroupForm
 */
?>
<?= \app\widgets\FlashMessenger::widget() ?>
<div class="col-xs-12">
	<div class="col-xs-5">
		<? $form = \yii\bootstrap\ActiveForm::begin([
			'action' => [ 'group/update' ]
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