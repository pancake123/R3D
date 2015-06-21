<?php
/**
 * @var $this yii\web\View
 * @var $model app\forms\PermissionForm
 */
?>
<?= \app\widgets\AdminNav::widget() ?>
<br>
<div class="col-xs-12">
	<div class="col-xs-8">
		<?= \yii\grid\GridView::widget([
			'columns' => [
				'id', 'name', [
					'class' => '\yii\grid\ActionColumn',
					'buttons' => [
						'update' => function($url, $model) {
							return \yii\helpers\Html::a('Редактировать', [ 'permission/edit', 'id' => $model['id'] ], [
								'class' => 'btn btn-primary btn-xs'
							]);
						},
						'delete' => function($url) {
							return \yii\helpers\Html::a('Удалить', $url, [
								'class' => 'btn btn-danger btn-xs'
							]);
						}
					],
					'contentOptions' => [
						'width' => '200px',
						'align' => 'middle'
					],
					'template' => '{update} {delete}',
				]
			],
			'dataProvider' => \app\models\Permission::search()
		]) ?>
	</div>
	<br>
	<div class="col-xs-4">
		<div class="panel panel-primary">
			<div class="panel-heading">Новая привилегия</div>
			<div class="panel-body">
				<?php $form = \yii\bootstrap\ActiveForm::begin([
					'action' => [ 'permission/create' ]
				]) ?>
				<?= $form->field($model, 'id')->textInput() ?>
				<?= $form->field($model, 'name')->textInput() ?>
				<?= \yii\helpers\Html::submitButton('Сохранить', [
					'class' => 'btn btn-primary'
				]) ?>
				<?php $form->end() ?>
			</div>
		</div>
        <?= \app\widgets\FlashMessenger::widget() ?>
	</div>
</div>