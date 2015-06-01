<?php

namespace app\forms;

use yii\base\Model;

class UploadForm extends Model {

	public $file;

	public function rules() {
		return [
			[ 'file', 'file', 'extensions' => 'zip' ],
			[ 'file', 'required' ],
		];
	}

	public function attributeLabels() {
		return [
			'file' => 'Файл'
		];
	}
}