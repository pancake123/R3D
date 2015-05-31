<?php

namespace app\widgets;

use yii\bootstrap\Widget;
use yii\helpers\Html;

class FlashMessenger extends Widget {

	public $key = null;

	public $type = 'info';

	public function run() {
		ob_start();
		if ($this->key == null) {
			foreach (\Yii::$app->getSession()->getAllFlashes() as $k => $m) {
				$this->renderFlash($m);
			}
		} else {
			foreach ((array) $this->key as $key) {
				$this->renderFlash(\Yii::$app->getSession()->getFlash($key));
			}
		}
		return ob_get_clean();
	}

	public function renderFlash($message) {
		if (empty($message)) {
			return ;
		}
		print Html::tag('div', $message, [
			'class' => 'alert alert-dismissible alert-' . $this->type
		]);
	}
}