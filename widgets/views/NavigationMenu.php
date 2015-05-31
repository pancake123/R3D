<?php
/**
 * @var $this \yii\web\View
 * @var $menu array
 */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

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