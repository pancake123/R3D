<?php
/**
 * @var $this yii\web\View
 */
?>
<?= \app\widgets\ModelNav::widget() ?>
<br>
<?= \yii\grid\GridView::widget([
	'dataProvider' => \app\models\File::search([ 'file_group_id' => 'archive' ]),
	'columns' => [
		[ 'attribute' => 'id', 'label' => '#' ],
		[ 'attribute' => 'name', 'label' => 'Имя' ],
		[ 'attribute' => 'user_login', 'label' => 'Пользователь' ],
		[ 'attribute' => 'upload_time', 'label' => 'Время загрузки' ],
		[ 'attribute' => 'file_group_name', 'label' => 'Группа файла' ],
		[ 'attribute' => 'file_extension', 'label' => 'Расширение' ],
		[
			'class' => '\yii\grid\ActionColumn',
			'buttons' => [
				'preview' => function($url, $model) {
					return \yii\helpers\Html::a('Предпросмотр', [ 'model/preview', 'id' => $model['id'] ], [
						'class' => 'btn btn-success btn-xs'
					]);
				}
			],
			'contentOptions' => [
				'width' => '200px',
				'align' => 'middle'
			],
			'template' => '{preview}',
		]
	]
]) ?>