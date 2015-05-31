<?php

namespace app\controllers;

use app\forms\PermissionForm;
use app\models\Permission;
use yii\web\Controller;

class PermissionController extends Controller {

	public function actionList() {
		return $this->render('list', [ 'model' => new PermissionForm([ 'scenario' => 'site.permission.new' ]) ]);
	}

	public function actionNew() {
		return $this->render('new', [ 'model' => new PermissionForm([ 'scenario' => 'site.permission.new' ]) ]);
	}

	public function actionCreate() {
		$form = new PermissionForm([ 'scenario' => 'site.permission.new' ]);
		if (!$form->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('permission.create', 'Невозможно загрузить форму');
			return $this->redirect([ 'permission/list' ]);
		}
		else if (!$form->validate()) {
			\Yii::$app->getSession()->setFlash('permission.create', 'Произошли ошибки при валидации формы');
			return $this->redirect([ 'permission/list' ]);
		}
		$ar = new Permission();
		$ar->setAttributes($form->getAttributes(), false);
		$ar->save();
		\Yii::$app->getSession()->setFlash('permission.create', 'Привилегия успешно создана');
		return $this->redirect([ 'permission/list' ]);
	}

	public function actionDelete() {
		Permission::deleteAll([ 'id' => $id = \Yii::$app->getRequest()->getQueryParam('id') ]);
		\Yii::$app->getSession()->setFlash('permission.delete', 'Привилегия успешно удалена');
		return $this->redirect([ 'permission/list' ]);
	}
}