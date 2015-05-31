<?php

namespace app\forms;

use yii\base\Model;

class UserForm extends Model {

	public $id;
	public $login;
	public $password;
	public $surname;
	public $name;
	public $role_id;

	public function rules() {
		return [
			/* defaults */
			[ 'login', 'string', 'max' => 20 ],
			[ 'surname', 'string', 'max' => 30 ],
			[ 'name', 'string', 'max' => 30 ],
			[ 'password', 'string', 'max' => 50 ],

			/* site.user.new */
			[ [ 'login', 'password', 'surname', 'name', 'role_id' ], 'required', 'on' => 'site.user.new' ],
		];
	}

	public function attributeLabels() {
		return [
			'id' => 'Идентификатор',
			'login' => 'Логин',
			'password' => 'Пароль',
			'surname' => 'Фамилия',
			'name' => 'Имя',
			'role_id' => 'Роль',
		];
	}
}