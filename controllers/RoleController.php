<?php

namespace app\controllers;

use app\forms\RoleForm;
use app\models\Permission;
use app\models\Role;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class RoleController extends Controller {

	public function behaviors() {
		return [
			'access' => [ 'class' => AccessControl::className(),
				'rules' => [
					[ 'allow' => true, 'actions' => [ 'edit', 'update', 'create', 'delete' ], 'roles' => [ 'ROLE_WRITE' ] ],
					[ 'allow' => true, 'actions' => [ 'list' ], 'roles' => [ 'ROLE_READ' ] ]
				]
			],
		];
	}

	public function actionList() {
		return $this->render('list', [
			'model' => new RoleForm([ 'scenario' => 'site.role.create' ])
		]);
	}

	public function actionEdit() {
		if (!$id = \Yii::$app->getRequest()->getQueryParam('id')) {
			return $this->redirect([ 'role/list' ]);
		}
		else if (!$ar = Role::find()->where([ 'id' => $id ])->one()) {
			return $this->redirect([ 'role/list' ]);
		}
		return $this->render('edit', [
			'model' => new RoleForm([ 'scenario' => 'site.role.update' ] + $ar->getAttributes() + [
					'permissions' => ArrayHelper::getColumn(Role::findPermissions($id), 'id', false)
				])
		]);
	}

	public function actionCreate() {
		$form = new RoleForm([ 'scenario' => 'site.role.create' ]);
		if (!$form->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('permission.create', 'Невозможно загрузить форму');
			return $this->redirect([ 'role/list' ]);
		}
		else if (!$form->validate()) {
			\Yii::$app->getSession()->setFlash('permission.create', 'Произошли ошибки при валидации формы');
			return $this->redirect([ 'role/list' ]);
		}
		$transaction = \Yii::$app->getDb()->beginTransaction();
		try {
			$ar = new Role();
			$ar->setAttributes($form->getAttributes(), false);
			$ar->save();
			foreach ($form->permissions as $k => $p) {
				\Yii::$app->getDb()->createCommand()->insert('role_to_permission', [
					'role_id' => $ar->getAttribute('id'),
					'permission_id' => $p
				])->execute();
			}
			$transaction->commit();
		} catch (\Exception $e) {
			$transaction->rollBack();
			throw $e;
		}
		\Yii::$app->getSession()->setFlash('permission.create', 'Роль успешно создана');
		return $this->redirect([ 'role/list' ]);
	}

	public function actionUpdate() {
		$form = new RoleForm([ 'scenario' => 'site.role.update' ]);
		if (!$form->load(\Yii::$app->getRequest()->getBodyParams())) {
			\Yii::$app->getSession()->setFlash('permission.update', 'Невозможно загрузить форму');
			return $this->redirect([ 'role/list' ]);
		}
		else if (!$form->validate()) {
			\Yii::$app->getSession()->setFlash('permission.update', 'Произошли ошибки при валидации формы');
			return $this->redirect([ 'role/list' ]);
		}
		$list = ArrayHelper::getColumn(Role::findPermissions($form->id), 'id', false);
		$transaction = \Yii::$app->getDb()->beginTransaction();
		try {
			$ar = Role::find()->where([ 'id' => $form->id ])->one();
			$ar->setAttributes($form->getAttributes(), false);
			$ar->save();
			foreach ($form->permissions as $k => $p) {
				if (!in_array($p, $list)) {
					\Yii::$app->getDb()->createCommand()->insert('role_to_permission', [
						'role_id' => $ar->getAttribute('id'),
						'permission_id' => $p
					])->execute();
				} else {
					array_splice($list, array_search($p, $list), 1);
				}
			}
			foreach ($list as $p) {
				\Yii::$app->getDb()->createCommand()->delete('role_to_permission', [
					'role_id' => $ar->getAttribute('id'),
					'permission_id' => $p
				])->execute();
			}
			$transaction->commit();
		} catch (\Exception $e) {
			$transaction->rollBack();
			throw $e;
		}
		\Yii::$app->getSession()->setFlash('permission.update', 'Роль успешно создана');
		return $this->redirect([ 'role/list' ]);
	}

	public function actionDelete() {
		Role::deleteAll([ 'id' => $id = \Yii::$app->getRequest()->getQueryParam('id') ]);
		\Yii::$app->getSession()->setFlash('permission.delete', 'Роль успешно удалена');
		return $this->redirect([ 'role/list' ]);
	}
}