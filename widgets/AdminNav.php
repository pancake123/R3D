<?php

namespace app\widgets;

use yii\bootstrap\Nav;

class AdminNav extends Nav {

	public $items = [
		[ 'label' => 'Пользователи', 'url' => [ 'user/list' ] ],
		[ 'label' => 'Роли', 'url' => [ 'role/list' ] ],
		[ 'label' => 'Привилегии', 'url' => [ 'permission/list' ] ],
        [ 'label' => 'Файлы', 'url' => [ 'file/list' ] ],
        [ 'label' => 'Группы', 'url' => [ 'group/list' ] ],
	];

	public $options = [
		'class' => 'nav nav-tabs'
	];
}