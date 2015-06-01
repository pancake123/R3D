<?php

namespace app\forms;

use app\models\Permission;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model {

	public $id;
	public $permissions;
	public $name;

	public function rules() {
		return [
			/* defaults */
			[ 'name', 'string', 'max' => 20 ],

			/* site.role.create */
			[ [ 'name', 'permissions' ], 'required', 'on' => 'site.role.create' ],

			/* site.role.update */
			[ [ 'id', 'name', 'permissions' ], 'required', 'on' => 'site.role.update' ],
		];
	}

	public function attributeLabels() {
		return [
			'id' => 'Идентификатор',
			'permissions' => 'Привилегии',
			'name' => 'Наименование',
		];
	}

	public function listPermissions() {
		return ArrayHelper::map(Permission::find()->all(), 'id', 'name');
	}
}