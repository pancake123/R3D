<?php

namespace app\controllers;

use app\forms\PermissionForm;
use app\models\Permission;
use yii\filters\AccessControl;
use yii\web\Controller;

class PermissionController extends Controller {

	public function behaviors() {
		return [
			'access' => [ 'class' => AccessControl::className(),
				'rules' => [
					[ 'allow' => true, 'actions' => [ 'edit', 'update', 'create', 'delete' ], 'roles' => [ 'PERMISSION_WRITE' ] ],
					[ 'allow' => true, 'actions' => [ 'list' ], 'roles' => [ 'PERMISSION_READ' ] ]
				]
			],
		];
	}

	public function actionList() {
		return $this->render('list', [
			'model' => new PermissionForm([ 'scenario' => 'site.permission.create' ])
		]);
	}

	public function actionEdit() {
		if (!$id = \Yii::$app->getRequest()->getQueryParam('id')) {
			return $this->redirect([ 'permission/list' ]);
		}
		else if (!$ar = Permission::find()->where([ 'id' => $id ])->one()) {
			return $this->redirect([ 'permission/list' ]);
		}
		return $this->render('edit', [
			'model' => new PermissionForm([ 'scenario' => 'site.permission.update' ] + $ar->getAttributes())
		]);
	}

	public function actionCreate() {
		$form = new PermissionForm([ 'scenario' => 'site.permission.create' ]);
		if (!$form->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('danger', 'Невозможно загрузить форму');
			return $this->redirect([ 'permission/list' ]);
		}
		else if (!$form->validate()) {
			\Yii::$app->getSession()->setFlash('danger', 'Произошли ошибки при валидации формы');
			return $this->redirect([ 'permission/list' ]);
		}
		$ar = new Permission();
		$ar->setAttributes($form->getAttributes(), false);
		$ar->save();
		\Yii::$app->getSession()->setFlash('success', 'Привилегия успешно создана');
		return $this->redirect([ 'permission/list' ]);
	}

	public function actionUpdate() {
		$form = new PermissionForm([ 'scenario' => 'site.permission.update' ]);
		if (!$form->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('danger', 'Невозможно загрузить форму');
			return $this->redirect([ 'permission/list' ]);
		}
		else if (!$form->validate()) {
			\Yii::$app->getSession()->setFlash('danger', 'Произошли ошибки при валидации формы');
			return $this->redirect([ 'permission/list' ]);
		}
		else if (!$ar = Permission::find()->where([ 'id' => $form->id ])->one()) {
			\Yii::$app->getSession()->setFlash('danger', 'Отсутсвует модель объекта');
			return $this->redirect([ 'permission/list' ]);
		}
		$ar->setAttributes($form->getAttributes(), false);
		$ar->save();
		\Yii::$app->getSession()->setFlash('success', 'Привилегия успешно создана');
		return $this->redirect([ 'permission/list' ]);
	}

	public function actionDelete() {
		Permission::deleteAll([ 'id' => $id = \Yii::$app->getRequest()->getQueryParam('id') ]);
		\Yii::$app->getSession()->setFlash('success', 'Привилегия успешно удалена');
		return $this->redirect([ 'permission/list' ]);
	}
}