<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface {

	public static function search() {
		$query = (new Query())->select('u.*, r.name as role_name')->from('user as u')
			->leftJoin('role as r', 'u.role_id = r.id');
		return new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 25
			],
			'sort' => [
				'attributes' => [
					'id', 'login', 'name', 'surname', 'role_name'
				]
			]
		]);
	}

	public static function tableName() {
		return 'user';
	}

	public function attributeLabels() {
		return [
			'id' => '#',
			'login' => 'Логин',
			'name' => 'Имя',
			'surname' => 'Фамилия',
			'role_id' => 'Роль',
			'role_name' => 'Роль',
		];
	}

	public static function findIdentity($id) {
		return static::findOne([ 'id' => $id ]);
    }

    public function getId() {
        return $this->getAttribute('id');
    }

    public function validatePassword($password) {
		return \Yii::$app->getSecurity()->validatePassword($this->getAttribute('password'), $password);
    }

	public static function findIdentityByAccessToken($token, $type = null) {
		return null;
	}

	public function getAuthKey() {
		return null;
	}

	public function validateAuthKey($authKey) {
		return false;
	}
}
