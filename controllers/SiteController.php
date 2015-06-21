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
				'model' => new LoginForm()
			]);
		} else {
            $this->layout = 'center';
            return $this->render('index');
		}
    }

    public function actionRegister() {
        return $this->render('register', [
            'model' => new RegisterForm()
        ]);
    }

	public function actionLogin() {
		return $this->render('login', [
			'model' => new LoginForm()
		]);
	}
}
