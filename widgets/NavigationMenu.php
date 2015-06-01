<?php

namespace app\widgets;

use Yii;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Widget;

class NavigationMenu extends Widget {

	public function run() {
		$menu = [
			[ 'label' => 'Главная', 'url' => [ '/' ] ],
			[ 'label' => 'Модели', 'url' => [ 'model/list' ] ],
			[ 'label' => 'Файлы', 'url' => [ 'file/list' ] ],
			[ 'label' => 'Управление', 'url' => [ 'user/list' ] ],
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
		ob_start();
		NavBar::begin([
			'brandLabel' => 'R3D',
			'brandUrl' => Yii::$app->homeUrl,
			'options' => [
				'class' => 'navbar-inverse navbar-fixed-top',
			],
		]);
		print Nav::widget([
			'options' => ['class' => 'navbar-nav navbar-right'],
			'items' => $menu
		]);
		NavBar::end();
		return ob_get_clean();
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
					unset($item['url']);
				}
			} else if (is_array($item)) {
				$this->checkAccess($item);
			}
		}
	}
}
