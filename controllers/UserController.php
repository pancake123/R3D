<?php

namespace app\controllers;

use app\forms\LoginForm;
use app\forms\RegisterForm;
use app\forms\UserForm;
use app\models\User;
use yii\web\Controller;
use yii\web\IdentityInterface;

class UserController extends Controller {

	public function actionList() {
		return $this->render('list', [ 'model' => new UserForm([ 'scenario' => 'site.user.new' ]) ]);
	}

	public function actionNew() {
		return $this->render('new', [ 'model' => new UserForm([ 'scenario' => 'site.user.new' ]) ]);
	}

	public function actionCreate() {
		$form = new UserForm([ 'scenario' => 'site.user.new' ]);
		if (!$form->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('user.new', 'Невозможно загрузить форму');
			return $this->redirect([ 'permission/list' ]);
		}
		else if (!$form->validate()) {
			\Yii::$app->getSession()->setFlash('user.new', 'Произошли ошибки при валидации формы');
			return $this->redirect([ 'permission/list' ]);
		}
		$ar = new User();
		$ar->setAttributes($form->getAttributes(), false);
		$ar->setAttribute('password', \Yii::$app->getSecurity()->generatePasswordHash(
			$ar->getAttribute('password')
		));
		$ar->save();
		\Yii::$app->getSession()->setFlash('user.new', 'Пользователь успешно создан');
		return $this->redirect([ 'user/list' ]);
	}

	public function actionDelete() {
		User::deleteAll([ 'id' => $id = \Yii::$app->getRequest()->getQueryParam('id') ]);
		\Yii::$app->getSession()->setFlash('permission.delete', 'Пользователь успешно удален');
		return $this->redirect([ 'user/list' ]);
	}

	public function actionRegister() {
		$model = new RegisterForm();
		if (!$model->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('user.register', 'Невозможно загрузить клиентскую форму');
			$this->goBack();
		}
		else if (!$model->validate()) {
			\Yii::$app->getSession()->setFlash('user.register', 'Произошли ошибки при валидации формы');
			$this->goBack();
		}
		$user = new User();
		$user->setAttributes($model->getAttributes(), false);
		$user->setAttribute("password", \Yii::$app->getSecurity()->generatePasswordHash($user->getAttribute("password")));
		$user->save();
		\Yii::$app->getSession()->setFlash('user.register', 'Пользователь успешно зарегистрировался');
		$this->redirect([ '/' ]);
	}

	public function actionLogin() {
		$model = new LoginForm();
		if (!$model->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('user.login', 'Невозможно загрузить клиентскую форму');
			return $this->redirect([ '/' ]);
		}
		else if (!$model->validate()) {
			\Yii::$app->getSession()->setFlash('user.login', 'Произошли ошибки при валидации формы');
			return $this->redirect([ '/' ]);
		}
		else if (!$user = User::find()->where([ 'login' => $model->login ])->one()) {
			\Yii::$app->getSession()->setFlash('user.login', 'Неверный логин или пароль');
			return $this->redirect([ '/' ]);
		}
		else if (!\Yii::$app->getSecurity()->validatePassword($model->password, $user->getAttribute('password'))) {
			\Yii::$app->getSession()->setFlash('user.login', 'Неверный логин или пароль');
			return $this->redirect([ '/' ]);
		}
		/* @var $user IdentityInterface */
		\Yii::$app->getUser()->login($user);
		return $this->goHome();
	}

	public function actionLogout() {
		\Yii::$app->getUser()->logout();
		$this->goHome();
	}
}