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
<br><br>
<div class="row clear">
    <?= \yii\helpers\Html::tag('div', '', [
        'id' => 'webgl-preview'
    ]) ?>
</div>
<br>
<br>
<br>
<div class="col-xs-4 col-xs-offset-8">
    <div class="row clear preview-control-wrapper">
        <label class="white-label col-xs-6 text-right">Угол обзора</label>
        <div class="btn-group">
            <button class="btn btn-primary btn-sm fa fa-minus" onclick="changeParameter.call(this, -5)"></button>
            <button class="btn btn-primary btn-sm fa fa-plus" onclick="changeParameter.call(this, +5)"></button>
        </div>
        <label id="fov" class="white-label label-border">45</label>
    </div>
    <div class="row clear preview-control-wrapper">
        <label class="white-label col-xs-6 text-right">Начало сцены</label>
        <div class="btn-group">
            <button class="btn btn-primary btn-sm fa fa-minus" onclick="changeParameter.call(this, -10)"></button>
            <button class="btn btn-primary btn-sm fa fa-plus" onclick="changeParameter.call(this, +10)"></button>
        </div>
        <label id="near" class="white-label label-border">1</label>
    </div>
    <div class="row clear preview-control-wrapper">
        <label class="white-label col-xs-6 text-right">Конец сцены</label>
        <div class="btn-group">
            <button class="btn btn-primary btn-sm fa fa-minus" onclick="changeParameter.call(this, -10)"></button>
            <button class="btn btn-primary btn-sm fa fa-plus" onclick="changeParameter.call(this, +10)"></button>
        </div>
        <label id="far" class="white-label label-border">1000</label>
    </div>
    <div class="row clear preview-control-wrapper">
        <label class="white-label col-xs-6 text-right">Угол поворота</label>
        <div class="btn-group">
            <button class="btn btn-primary btn-sm fa fa-minus" onclick="changeParameter.call(this, -10)" disabled></button>
            <button class="btn btn-primary btn-sm fa fa-plus" onclick="changeParameter.call(this, +10)" disabled></button>
        </div>
        <label id="angle" class="white-label label-border">0</label>
    </div>
</div>
<?php
$obj = Yii::$app->getUrlManager()->createUrl([ 'model/object', 'id' => $id ]);
$mtl = Yii::$app->getUrlManager()->createUrl([ 'model/material', 'id' => $id ]);
$this->registerJs(<<< JS
var modes = [ MODE_DEPTH, MODE_REVERSE, MODE_LINEAR ];
var load = function(mode, callback) {
    var loader = new THREE.OBJMTLLoader(), mtl;
    if (mode != MODE_DEPTH) {
        mtl = '$mtl';
    } else {
        mtl = null;
    }
    loader.load('$obj', mtl, function(obj) {
        init(obj, mode); callback && callback();
    });
};
var repeater = function() {
    if (!modes.length) {
        return void 0;
    }
    load(modes.pop(), function() {
        repeater();
    });
};
repeater();
JS
) ?>