<?php

namespace app\forms;

use yii\base\Model;

class LoginForm extends Model {

	public $login;
	public $password;

	public function rules() {
		return [
			[ [ 'login', 'password' ], 'required' ],
			[ 'login', 'string', 'max' => 20 ],
		];
	}

	public function attributeLabels() {
		return [
			'login' => 'Логин',
			'password' => 'Пароль',
		];
	}
}