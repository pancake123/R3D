<?php

namespace app\assets;

use yii\web\AssetBundle;

class PreviewAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		'css/preview.css',
	];

	public $js = [
		'js/three.js',
		'js/preview.js',
		'js/loaders/DDSLoader.js',
		'js/loaders/MTLLoader.js',
		'js/loaders/OBJMTLLoader.js',
	];

	public $depends = [
		'app\assets\AppAsset',
	];
}