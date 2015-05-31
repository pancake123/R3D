<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Permission extends ActiveRecord {

	public static function checkAccess($user, $permission) {
		foreach ((array) $permission as $p) {
			$row = static::find()
				->select('p.id')
				->from('permission as p')
				->innerJoin('role_to_permission as p_r', 'p_r.permission_id = p.id')
				->innerJoin('role as r', 'p_r.role_id = r.id')
				->innerJoin('user as e', 'e.role_id = r.id')
				->where('e.id = :user_id and p.id = :privilege_id', [
					':user_id' => $user,
					':privilege_id' => $p
				])->exists();
			if ($row) {
				return true;
			}
		}
		return false;
	}

	public static function search() {
		return new ActiveDataProvider([
			'query' => static::find(),
			'pagination' => [
				'pageSize' => 20
			],
			'sort' => [
				'attributes' => [
					'id', 'name'
				]
			]
		]);
	}

	public function attributeLabels() {
		return [
			'id' => '#',
			'name' => 'Наименование',
		];
	}

	public static function tableName() {
		return 'permission';
	}
}