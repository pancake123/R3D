<?php

namespace app\forms;

use yii\base\Model;

class PermissionForm extends Model {

	public $id;
	public $name;

	public function rules() {
		return [
			/* defaults */
			[ 'id', 'string', 'max' => 50 ],
			[ 'name', 'string', 'max' => 100 ],

			/* site.permission.new */
			[ [ 'id', 'name' ], 'required', 'on' => 'site.permission.new' ],
			/* site.permission.update */
			[ [ 'id', 'name' ], 'required', 'on' => 'site.permission.update' ],
		];
	}

	public function attributeLabels() {
		return [
			'id' => 'Идентификатор',
			'name' => 'Наименование',
		];
	}
}