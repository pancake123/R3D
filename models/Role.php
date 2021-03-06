<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Role extends ActiveRecord {

	public static function search() {
		return new ActiveDataProvider([
			'query' => static::find(),
			'pagination' => [
				'pageSize' => 10
			],
			'sort' => [
				'attributes' => [
					'id', 'name'
				]
			]
		]);
	}

	public static function findPermissions($role) {
		return Permission::find()->select('p.*')->from('permission as p')
			->innerJoin('role_to_permission as r_p', 'p.id = r_p.permission_id')
			->where('r_p.role_id = :role_id', [
				':role_id' => $role
			])->all();
	}

	public function attributeLabels() {
		return [
			'id' => '#',
			'name' => 'Наименование',
		];
	}

	public static function tableName() {
		return 'role';
	}
}