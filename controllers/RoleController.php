<?php

namespace app\controllers;

use app\forms\RoleForm;
use yii\web\Controller;

class RoleController extends Controller {

	public function actionList() {
		return $this->render('list', [ 'model' => new RoleForm([ 'scenario' => 'site.role.new' ]) ]);
	}

	public function actionNew() {
		return $this->render('new', [ 'model' => new RoleForm([ 'scenario' => 'site.role.new' ]) ]);
	}
}