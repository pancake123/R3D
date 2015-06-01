<?php
/**
 * @var $this yii\web\View
 */
$model = new \app\forms\UploadForm();
?>
<?= \app\widgets\FileNav::widget() ?>
<br>
<div class="col-xs-12">
	<div class="col-xs-8">
		<?= \yii\grid\GridView::widget([
			'dataProvider' => \app\models\File::search(),
			'columns' => [
				[ 'attribute' => 'id', 'label' => '#' ],
				[ 'attribute' => 'name', 'label' => 'Имя' ],
				[ 'attribute' => 'user_login', 'label' => 'Пользователь' ],
				[ 'attribute' => 'upload_time', 'label' => 'Время загрузки' ],
				[ 'attribute' => 'file_group_name', 'label' => 'Группа файла' ],
				[ 'attribute' => 'file_extension', 'label' => 'Расширение' ],
				/* [
					'class' => '\yii\grid\ActionColumn',
					'buttons' => [
						'delete' => function($url, $model) {
							return \yii\helpers\Html::a('Удалить', [ 'file/delete', 'id' => $model['id'] ], [
								'class' => 'btn btn-danger btn-xs'
							]);
						}
					],
					'contentOptions' => [
						'width' => '200px',
						'align' => 'middle'
					],
					'template' => '{delete}',
				] */
			]
		]) ?>
	</div>
	<div class="col-xs-4">
		<br>
		<div class="panel panel-primary">
			<div class="panel-heading">Загрузка файла</div>
			<div class="panel-body">
				<?php $form = \yii\widgets\ActiveForm::begin([
					'action' => [ 'file/upload' ],
					'options' => [
						'enctype' => 'multipart/form-data',
						'method' => 'post'
					],
				]) ?>
				<h5>Загрузите архив с расширением <b>*.7z</b>, в котором хранятся: модель <b>*.obj</b>, материалы <b>*.mtl</b> и текстуры трехмерного объекта</h5>
				<?= $form->field($model, 'file', [
					'options' => [ 'class' => 'form-group clear' ]
				])->label(false)->fileInput([
					'data-toggle' => 'fileinput'
				]) ?>
				<?php $form->end() ?>
			</div>
		</div>
	</div>
</div>