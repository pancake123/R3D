<?php

namespace app\widgets;

use Yii;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Widget;
use yii\helpers\Html;

class NavigationMenu extends Widget {

    public $top = [
        [ 'label' => 'Главная', 'url' => [ '/' ], 'icon' => ' fa fa-home', ],
        [ 'label' => 'Кабинет', 'url' => [ 'user/cabinet' ], 'icon' => 'fa fa-group', ],
        [ 'label' => 'Модели', 'url' => [ 'model/list' ], 'icon' => 'fa fa-cube', ],
    ];

    public $bottom = [
        [ 'label' => 'Репозиторий', 'url' => 'http://github.com/pancake123/r3d', 'icon' => 'fa fa-github', ],
        [ 'label' => 'Управление', 'url' => [ 'user/list' ], 'icon' => 'fa fa-cog', ],
        [ 'label' => 'Выход', 'url' => [ 'user/logout' ], 'linkOptions' => [ 'data-method' => 'post' ], 'icon' => 'fa fa-power-off', ],
    ];

	public function run() {
        if (\Yii::$app->getUser()->getIsGuest()) {
            return '';
        }
		$this->checkAccess($this->top);
        $this->checkAccess($this->bottom);
		ob_start();
        print Html::beginTag('div', [
            'class' => 'nav-menu-wrapper'
        ]);
        $this->printMenu($this->top, true);
        $this->printMenu($this->bottom);
        print Html::endTag('div');
		return ob_get_clean();
	}

    private function printMenu(array $items, $first = false) {
        if (Yii::$app->getRequest()->getUrl() == Yii::$app->getUrlManager()->createUrl([ '/' ])) {
            $index = true;
        } else {
            $index = false;
        }
        if ($index) {
            $class = ' nav-center';
        } else {
            $class = '';
        }
        if (!$first) {
            if (!empty($class)) {
                $offset = ' - 50%';
            } else {
                $offset = '';
            }
            $style = 'top: calc(100% - '. count($items) * 65 .'px'. $offset .')';
        } else {
            $style = null;
        }
        print Html::beginTag('div', [
            'class' => 'nav-menu' . $class,
            'style' => $style
        ]);
        print Html::beginTag('div', [
            'class' => 'nav nav-stacked' . (!empty($class) ? ' nav-pills' : '')
        ]);
        foreach ($items as $i => $item) {
            $options = [];
            if (isset($item['url'])) {
                $url = $item['url'];
            } else {
                $url = 'javascript:void(0)';
            }
            $label = $item['label'];
            if (isset($item['icon'])) {
                $options += [
                    'onmouseenter' => '$(this).tooltip({ container: ".page-content" }).tooltip("show")',
                    'data-original-title' => $label,
                    'data-placement' => 'right'
                ];
                $label = Html::tag('span', '', [
                    'class' => $item['icon'].' fa-3x'
                ]);
            }
            print Html::beginTag('li', $options);
            print Html::a($label, $url);
            print Html::endTag('li');
        }
        print Html::endTag('div');
        print Html::endTag('div');
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
