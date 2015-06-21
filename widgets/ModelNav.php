<?php

namespace app\widgets;

use yii\bootstrap\Nav;

class ModelNav extends Nav {

	public $items = [
		[ 'label' => 'Модели', 'url' => [ 'model/list' ] ],
        [ 'label' => 'Текстуры', 'url' => [ 'texture/list' ] ],
        [ 'label' => 'Материалы', 'url' => [ 'material/list' ] ],
	];

	public $options = [
		'class' => 'nav nav-tabs'
	];
}