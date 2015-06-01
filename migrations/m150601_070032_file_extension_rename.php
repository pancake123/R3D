<?php

use yii\db\Schema;
use yii\db\Migration;

class m150601_070032_file_extension_rename extends Migration
{
	public function safeUp()
	{
		$sql = <<< SQL

DROP TABLE IF EXISTS file;

CREATE TABLE file(
  id INT PRIMARY KEY AUTO_INCREMENT, -- Первичный ключ
  name VARCHAR(255) NOT NULL, -- Оригинальное азвание файла (без расширения)
  path VARCHAR(255) NOT NULL, -- Относительное имя файла (генерируется рандомно)
  user_id INT REFERENCES user(id), -- Пользователь, загрузивший файл
  upload_time TIMESTAMP DEFAULT current_timestamp, -- Дата загрузки Y-m-d
  mime_type VARCHAR(200), -- MIME тип файла
  file_group_id VARCHAR(50) REFERENCES file_group(id) ON DELETE SET NULL, -- Группа файла
  file_extension VARCHAR(20) NOT NULL, -- Расширение файла
  parent_id INT DEFAULT NULL
) DEFAULT CHAR SET utf8

SQL;
		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
	}

	public function safeDown()
	{
		$sql = <<< SQL

DROP TABLE file;

CREATE TABLE file(
  id INT PRIMARY KEY AUTO_INCREMENT, -- Первичный ключ
  name VARCHAR(255) NOT NULL, -- Оригинальное азвание файла (без расширения)
  path VARCHAR(255) NOT NULL, -- Относительное имя файла (генерируется рандомно)
  user_id INT REFERENCES user(id), -- Пользователь, загрузивший файл
  upload_time TIMESTAMP DEFAULT current_timestamp, -- Дата загрузки Y-m-d
  mime_type VARCHAR(200), -- MIME тип файла
  file_group_id INT REFERENCES file_group(id) ON DELETE SET NULL, -- Группа файла
  file_extention VARCHAR(20) NOT NULL -- Расширение файла
) DEFAULT CHAR SET utf8

SQL;
		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
	}
}
