<?php
/**
 * @var $this yii\web\View
 * @var $model app\forms\RoleForm
 */
print \app\widgets\FlashMessenger::widget([
	'key' => null
]) ?>
<div class="col-xs-12">
	<div class="col-xs-8">
		<?= \yii\grid\GridView::widget([
			'columns' => [
				'id', 'name', [
					'class' => '\yii\grid\ActionColumn',
					'buttons' => [
						'update' => function($url) {
							return \yii\helpers\Html::a('Редактировать', $url, [
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
			'dataProvider' => \app\models\Role::search()
		]) ?>
	</div>
	<br>
	<div class="col-xs-4">
		<div class="panel panel-primary">
			<div class="panel-heading">Новая роль</div>
			<div class="panel-body">
				<?php $form = \yii\bootstrap\ActiveForm::begin([
					'action' => [ 'role/create' ]
				]) ?>
				<?= $form->field($model, 'name')->textInput() ?>
				<?= $form->field($model, 'permissions')->checkboxList(\yii\helpers\ArrayHelper::map(
					\app\models\Permission::find()->all(), 'id', 'name')
				) ?>
				<?= \yii\helpers\Html::submitButton('Сохранить', [
					'class' => 'btn btn-primary'
				]) ?>
				<?php $form->end() ?>
			</div>
		</div>
	</div>
</div>