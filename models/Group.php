<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Group extends ActiveRecord {

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
		return 'file_group';
	}
}