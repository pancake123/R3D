<?php

namespace app\widgets;

use yii\bootstrap\Widget;
use yii\helpers\Html;

class FlashMessenger extends Widget {

	public function run() {
		ob_start();
        foreach (\Yii::$app->getSession()->getAllFlashes() as $k => $m) {
            $this->renderFlash($k, $m);
        }
		return ob_get_clean();
	}

	public function renderFlash($type, $message) {
		if (empty($message)) {
			return ;
		}
		$button = Html::tag('button', Html::tag('span', '&times;', [ 'aria-hidden' => 'true' ]), [
			'class' => 'close', 'type' => 'button', 'data-dismiss' => 'alert', 'aria-label' => 'Закрыть'
		]);
		print Html::tag('div', $button . $message, [
			'class' => 'alert alert-dismissible fade in alert-' . $type
		]);
	}
}