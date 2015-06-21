<?php
/**
 * @var $this yii\web\View
 */
?>
<?= \app\widgets\AdminNav::widget() ?>
<br>
<div class="col-xs-12">
	<div class="col-xs-8">
		<?= \yii\grid\GridView::widget([
			'columns' => [
				[ 'attribute' => 'id', 'label' => '#' ],
				[ 'attribute' => 'login', 'label' => 'Логин' ],
				[ 'attribute' => 'surname', 'label' => 'Фамилия' ],
				[ 'attribute' => 'name', 'label' => 'Имя' ],
				[ 'attribute' => 'role_name', 'label' => 'Роль' ], [
					'class' => '\yii\grid\ActionColumn',
					'buttons' => [
						'update' => function($url, $model, $key) {
							return \yii\helpers\Html::a('Редактировать', [ 'user/edit', 'id' => $model['id'] ], [
								'class' => 'btn btn-primary btn-xs'
							]);
						},
						'delete' => function($url, $model, $key) {
							return \yii\helpers\Html::a('Удалить', [ 'user/delete', 'id' => $model['id'] ], [
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
			'dataProvider' => \app\models\User::search()
		]) ?>
	</div>
	<br>
	<div class="col-xs-4">
		<div class="panel panel-primary">
			<div class="panel-heading">Новый пользователь</div>
			<div class="panel-body">
				<?php $form = \yii\bootstrap\ActiveForm::begin([
					'action' => [ 'user/create' ]
				]) ?>
				<?= $form->field($model, 'login')->textInput() ?>
				<?= $form->field($model, 'password')->passwordInput() ?>
				<?= $form->field($model, 'surname')->textInput() ?>
				<?= $form->field($model, 'name')->textInput() ?>
				<?= $form->field($model, 'role_id')->dropDownList(\yii\helpers\ArrayHelper::map(
					\app\models\Role::find()->all(), 'id', 'name')
				) ?>
				<?= \yii\helpers\Html::submitButton('Сохранить', [
					'class' => 'btn btn-primary'
				]) ?>
				<?php $form->end() ?>
			</div>
		</div>
        <?= \app\widgets\FlashMessenger::widget() ?>
    </div>
</div>