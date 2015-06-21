<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Query;

class File extends ActiveRecord {

	public static function search($condition = null, $params = []) {
		$query = (new Query())->select('f.*, g.name as file_group_name, u.login as user_login')->from('file as f')
			->leftJoin('user as u', 'f.user_id = u.id')
			->leftJoin('file_group as g', 'f.file_group_id = g.id');
		if ($condition != null) {
			$query->where($condition, $params);
		}
		return new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 20
			],
			'sort' => [
				'attributes' => [
					'id', 'name', 'user_login', 'upload_time', 'file_group_name', 'file_extension'
				],
				'defaultOrder' => [
					'id' => SORT_ASC
				]
			],
            'key' => 'id'
		]);
	}

	public function attributeLabels() {
		return [
			'id' => 'Идентификатор',
			'name' => 'Имя',
			'path' => 'Путь к файлу',
			'user_id' => 'Пользователь',
			'upload_time' => 'Время загрузки',
			'mime_type' => 'Тип файла',
			'file_group_id' => 'Группа',
			'file_extension' => 'Расширение'
		];
	}

	public static function tableName() 	{
		return 'file';
	}
}