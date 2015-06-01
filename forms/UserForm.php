<?php

namespace app\forms;

use app\models\Role;
use yii\base\Model;
use yii\helpers\ArrayHelper;

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

			/* site.user.create */
			[ [ 'login', 'password', 'surname', 'name', 'role_id' ], 'required', 'on' => 'site.user.create' ],

			/* site.user.update */
			[ [ 'id', 'login', 'surname', 'name', 'role_id' ], 'required', 'on' => 'site.user.update' ],
			[ 'password', 'safe', 'on' => 'site.user.update', 'when' => function($model) {
				return !empty($model->password);
			} ]
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

	public static function listRoles() {
		return [ null => 'Нет' ] + ArrayHelper::map(Role::find()->all(), 'id', 'name');
	}
}