<?php

namespace app\forms;

use yii\base\Model;

class RoleForm extends Model {

	public $id;
	public $permissions;
	public $name;

	public function rules() {
		return [
			/* defaults */
			[ 'name', 'string', 'max' => 20 ],

			/* site.role.new */
			[ [ 'name', 'permissions' ], 'required', 'on' => 'site.role.new' ],

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
}