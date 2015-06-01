<?php

namespace app\forms;

use yii\base\Model;

class GroupForm extends Model {

	public $id;
	public $name;

	public function rules() {
		return [
			/* defaults */
			[ 'name', 'string', 'max' => 255 ],

			/* site.permission.create */
			[ [ 'id', 'name' ], 'required', 'on' => 'group.create' ],
			/* site.permission.update */
			[ [ 'id', 'name' ], 'required', 'on' => 'group.update' ],
		];
	}

	public function attributeLabels() {
		return [
			'id' => 'Идентификатор',
			'name' => 'Наименование',
		];
	}
}