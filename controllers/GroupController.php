<?php

namespace app\controllers;

use app\forms\GroupForm;
use app\models\Group;
use yii\filters\AccessControl;
use yii\web\Controller;

class GroupController extends Controller {

	public function behaviors() {
		return [
			'access' => [ 'class' => AccessControl::className(),
				'rules' => [
					[ 'allow' => true, 'actions' => [ 'edit', 'update', 'create', 'delete' ], 'roles' => [ 'GROUP_WRITE' ] ],
					[ 'allow' => true, 'actions' => [ 'list' ], 'roles' => [ 'GROUP_READ' ] ],
				]
			],
		];
	}

	public function actionList() {
		return $this->render('list', [
			'model' => new GroupForm([ 'scenario' => 'group.create' ])
		]);
	}

	public function actionEdit() {
		if (!$id = \Yii::$app->getRequest()->getQueryParam('id')) {
			return $this->redirect([ 'group/list' ]);
		}
		else if (!$ar = Group::find()->where([ 'id' => $id ])->one()) {
			return $this->redirect([ 'group/list' ]);
		}
		return $this->render('edit', [
			'model' => new GroupForm([ 'scenario' => 'group.update' ] + $ar->getAttributes())
		]);
	}

	public function actionCreate() {
		$form = new GroupForm([ 'scenario' => 'group.create' ]);
		if (!$form->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('group.create', 'Невозможно загрузить форму');
			return $this->redirect([ 'group/list' ]);
		}
		else if (!$form->validate()) {
			\Yii::$app->getSession()->setFlash('group.create', 'Произошли ошибки при валидации формы');
			return $this->redirect([ 'group/list' ]);
		}
		$ar = new Group();
		$ar->setAttributes($form->getAttributes(), false);
		$ar->save();
		\Yii::$app->getSession()->setFlash('group.create', 'Группа успешно создана');
		return $this->redirect([ 'group/list' ]);
	}

	public function actionUpdate() {
		$form = new GroupForm([ 'scenario' => 'group.update' ]);
		if (!$form->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('group.update', 'Невозможно загрузить форму');
			return $this->redirect([ 'group/list' ]);
		}
		else if (!$form->validate()) {
			\Yii::$app->getSession()->setFlash('group.update', 'Произошли ошибки при валидации формы');
			return $this->redirect([ 'group/list' ]);
		}
		else if (!$ar = Group::find()->where([ 'id' => $form->id ])->one()) {
			\Yii::$app->getSession()->setFlash('group.update', 'Отсутсвует модель объекта');
			return $this->redirect([ 'group/list' ]);
		}
		$ar->setAttributes($form->getAttributes(), false);
		$ar->save();
		\Yii::$app->getSession()->setFlash('group.update', 'Группа успешно сохранена');
		return $this->redirect([ 'group/list' ]);
	}

	public function actionDelete() {
		Group::deleteAll([ 'id' => $id = \Yii::$app->getRequest()->getQueryParam('id') ]);
		\Yii::$app->getSession()->setFlash('group.delete', 'Группа успешно удалена');
		return $this->redirect([ 'group/list' ]);
	}
}