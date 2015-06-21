<?php

namespace app\controllers;

use app\forms\LoginForm;
use app\forms\RegisterForm;
use app\forms\UserForm;
use app\models\User;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\IdentityInterface;

class UserController extends Controller {

	public function behaviors() {
		return [
			'access' => [ 'class' => AccessControl::className(),
				'except' => [ 'login', 'register', 'logout' ],
				'rules' => [
					[ 'allow' => true, 'actions' => [ 'edit', 'update', 'create', 'delete' ], 'roles' => [ 'USER_WRITE' ] ],
					[ 'allow' => true, 'actions' => [ 'list', 'vk' ], 'roles' => [ 'USER_READ' ] ]
				]
			],
		];
	}

	public function actionList() {
		return $this->render('list', [
			'model' => new UserForm([ 'scenario' => 'site.user.create' ])
		]);
	}

	public function actionEdit() {
		if (!$id = \Yii::$app->getRequest()->getQueryParam('id')) {
			return $this->redirect([ 'user/list' ]);
		}
		else if (!$ar = User::find()->where([ 'id' => $id ])->one()) {
			return $this->redirect([ 'user/list' ]);
		}
		return $this->render('edit', [
			'model' => new UserForm([ 'scenario' => 'site.user.update', 'password' => '' ] + $ar->getAttributes())
		]);
	}

	public function actionCreate() {
		$form = new UserForm([ 'scenario' => 'site.user.create' ]);
		if (!$form->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('danger', 'Невозможно загрузить форму');
			return $this->redirect([ 'user/list' ]);
		}
		else if (!$form->validate()) {
			\Yii::$app->getSession()->setFlash('danger', 'Произошли ошибки при валидации формы');
			return $this->redirect([ 'user/list' ]);
		}
		$ar = new User();
		$ar->setAttributes($form->getAttributes(), false);
		$ar->setAttribute('password', \Yii::$app->getSecurity()->generatePasswordHash(
			$ar->getAttribute('password')
		));
		$ar->save();
		\Yii::$app->getSession()->setFlash('success', 'Пользователь успешно создан');
		return $this->redirect([ 'user/list' ]);
	}

	public function actionUpdate() {
		$form = new UserForm([ 'scenario' => 'site.user.update' ]);
		if (!$form->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('danger', 'Невозможно загрузить форму');
			return $this->redirect([ 'user/list' ]);
		}
		else if (!$form->validate()) {
			\Yii::$app->getSession()->setFlash('danger', 'Произошли ошибки при валидации формы');
			return $this->redirect([ 'user/list' ]);
		}
		else if (!$ar = User::find()->where([ 'id' => $form->id ])->one()) {
			\Yii::$app->getSession()->setFlash('danger', 'Невозможно загрузить модель');
			return $this->redirect([ 'user/list' ]);
		}
		if (!empty($form->password)) {
			$form->password = \Yii::$app->getSecurity()->generatePasswordHash($form->password);
		} else {
			$form->password = $ar->getAttribute('password');
		}
		$ar->setAttributes($form->getAttributes(), false);
		$ar->setAttribute('id', $ar->getOldAttribute('id'));
		$ar->save();
		\Yii::$app->getSession()->setFlash('success', 'Пользователь успешно изменен');
		return $this->redirect([ 'user/list' ]);
	}

	public function actionDelete() {
		User::deleteAll([ 'id' => $id = \Yii::$app->getRequest()->getQueryParam('id') ]);
		\Yii::$app->getSession()->setFlash('success', 'Пользователь успешно удален');
		return $this->redirect([ 'user/list' ]);
	}

	public function actionRegister() {
		$model = new RegisterForm();
		if (!$model->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('danger', 'Невозможно загрузить клиентскую форму');
			$this->goBack();
		}
		else if (!$model->validate()) {
			\Yii::$app->getSession()->setFlash('danger', 'Произошли ошибки при валидации формы');
			$this->goBack();
		}
		$user = new User();
		$user->setAttributes($model->getAttributes(), false);
        $user->setAttribute('role_id', 1);
		$user->setAttribute("password", \Yii::$app->getSecurity()->generatePasswordHash($user->getAttribute("password")));
		$user->save();
		\Yii::$app->getSession()->setFlash('success', 'Пользователь успешно зарегистрировался');
		$this->redirect([ '/' ]);
	}

	public function actionLogin() {
		$model = new LoginForm();
		if (!$model->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('danger', 'Невозможно загрузить клиентскую форму');
			return $this->redirect([ '/' ]);
		}
		else if (!$model->validate()) {
			\Yii::$app->getSession()->setFlash('danger', 'Произошли ошибки при валидации формы');
			return $this->redirect([ '/' ]);
		}
		else if (!$user = User::find()->where([ 'login' => $model->login ])->one()) {
			\Yii::$app->getSession()->setFlash('danger', 'Неверный логин или пароль');
			return $this->redirect([ '/' ]);
		}
		else if (!\Yii::$app->getSecurity()->validatePassword($model->password, $user->getAttribute('password'))) {
			\Yii::$app->getSession()->setFlash('danger', 'Неверный логин или пароль');
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