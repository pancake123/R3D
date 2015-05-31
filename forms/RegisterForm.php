<?php

namespace app\forms;

use yii\base\Model;

class RegisterForm extends Model {

	public $login;
	public $surname;
	public $name;
	public $password;
	public $repeat_password;

	public function rules() {
		return [
			[ [ 'login', 'surname', 'name', 'password', 'repeat_password' ], 'required' ],
			[ 'login', 'string', 'max' => 20 ],
			[ [ 'surname', 'name' ], 'string', 'max' => 30 ],
			[ 'password', 'string', 'max' => 100 ],
			[ 'repeat_password', 'compare', 'compareAttribute' => 'password' ],
		];
	}

	public function attributeLabels() {
		return [
			'login' => 'Логин',
			'surname' => 'Фамилия',
			'name' => 'Имя',
			'password' => 'Пароль',
			'repeat_password' => 'Повтор пароля',
		];
	}
}