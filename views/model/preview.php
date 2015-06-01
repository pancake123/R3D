<?php
/**
 * @var $this yii\web\View
 */
$this->registerAssetBundle(\app\assets\PreviewAsset::className());
$id = Yii::$app->getRequest()->getQueryParam('id');
?>
<div class="col-xs-9 text-left">
	<?= \yii\helpers\Html::a('Назад', [ 'model/list' ], [
		'class' => 'btn btn-default'
	]) ?>
</div>
<div class="col-xs-3 text-right">
	<?= \yii\helpers\Html::dropDownList('list', $id,
		\yii\helpers\ArrayHelper::map(\app\models\File::find()->where([ 'file_group_id' => 'archive' ])->all(), 'id', function($model) {
			return basename($model->name, '.zip');
		}), [
			'class' => 'form-control',
			'onchange' => 'window.location.href = \''.Yii::$app->getUrlManager()->createUrl([ 'model/preview' ]).'?id=\' + $(this).val()'
		]
	) ?>
</div>
<?= \yii\helpers\Html::tag('div', '', [
	'id' => 'webgl-preview'
]) ?>
<?php
$obj = Yii::$app->getUrlManager()->createUrl([ 'model/object', 'id' => $id ]);
$mtl = Yii::$app->getUrlManager()->createUrl([ 'model/material', 'id' => $id ]);
$this->registerJs(<<< JS
var loader = new THREE.OBJMTLLoader();
loader.load('$obj', '$mtl', function(obj) {
	scene.add(obj); window.object = obj;
});
JS
) ?>