<?php

namespace app\widgets;

use yii\bootstrap\Nav;

class FileNav extends Nav {

	public $items = [
		[ 'label' => 'Файлы', 'url' => [ 'file/list' ] ],
		[ 'label' => 'Группы', 'url' => [ 'group/list' ] ],
	];

	public $options = [
		'class' => 'nav nav-tabs'
	];
}