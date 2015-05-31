<?php

namespace app\controllers;

use app\forms\LoginForm;
use app\forms\RegisterForm;
use Yii;
use yii\web\Controller;

class SiteController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
		if (Yii::$app->getUser()->getIsGuest()) {
			return $this->render('login', [
				"login" => new LoginForm(),
				"register" => new RegisterForm()
			]);
		} else {
			return $this->render('index');
		}
    }

	public function actionLogin() {
		return $this->render('login', [
			"login" => new LoginForm(),
			"register" => new RegisterForm()
		]);
	}
}
