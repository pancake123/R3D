<?php

namespace app\widgets;

use yii\bootstrap\Widget;

class NavigationMenu extends Widget {

	public function run() {
		$menu = [
			[ 'label' => 'Главная', 'url' => [ '/' ] ],
			[ 'label' => 'Управление', 'items' => [
				[ 'label' => 'Пользователи', 'url' => [ 'user/list' ], 'can' => [ 'USER_READ', 'USER_WRITE' ] ],
				[ 'label' => 'Роли', 'url' => [ 'role/list' ], 'can' => [ 'ROLE_READ', 'USER_WRITE' ] ],
				[ 'label' => 'Привилегии', 'url' => [ 'permission/list' ], 'can' => [ 'PERMISSION_READ', 'PERMISSION_WRITE' ] ],
			] ]
		];
		if (\Yii::$app->getUser()->getIsGuest()) {
			$menu = array_merge($menu, [
				[ 'label' => 'Вход', 'url' => ['site/login'] ]
			]);
		} else {
			$menu = array_merge($menu, [
				[ 'label' =>  ' ' . \Yii::$app->getUser()->getIdentity()->{'login'},
					'linkOptions' => [ 'class' => 'fa fa-user' ],
					'items' => [
						[ 'label' => 'Кабинет', 'url' => [ 'user/cabinet' ] ],
						[ 'label' => 'Выход', 'url' => [ 'user/logout' ], 'linkOptions' => [ 'data-method' => 'post' ] ],
					]
				]
			]);
		}
		$this->checkAccess($menu);
		return $this->render("NavigationMenu", [
			"menu" => $menu
		]);
	}

	private function checkAccess(array& $items) {
		foreach ($items as &$item) {
			if (isset($item['can'])) {
				$r = true;
				foreach ((array) $item['can'] as $p) {
					if (!$r = \Yii::$app->getUser()->can($p)) {
						break;
					}
				}
				if (!$r) {
//					unset($item['url']);
				}
			} else if (is_array($item)) {
				$this->checkAccess($item);
			}
		}
	}
}
