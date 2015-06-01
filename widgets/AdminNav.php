<?php

namespace app\widgets;

use yii\bootstrap\Nav;

class AdminNav extends Nav {

	public $items = [
		[ 'label' => 'Пользователи', 'url' => [ 'user/list' ] ],
		[ 'label' => 'Роли', 'url' => [ 'role/list' ] ],
		[ 'label' => 'Привилегии', 'url' => [ 'permission/list' ] ],
	];

	public $options = [
		'class' => 'nav nav-tabs'
	];
}