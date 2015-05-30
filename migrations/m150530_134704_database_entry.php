<?php

use yii\db\Schema;
use yii\db\Migration;

class m150530_134704_database_entry extends Migration
{
    public function safeUp()
    {
        $sql = <<< SQL

CREATE TABLE role(
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(20) UNIQUE NOT NULL
) DEFAULT CHAR SET utf8;

CREATE TABLE permission(
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(20) UNIQUE NOT NULL
) DEFAULT CHAR SET utf8;

CREATE TABLE role_to_permission(
  role_id VARCHAR(20) REFERENCES role(id) ON DELETE CASCADE,
  permission_id VARCHAR(20) REFERENCES permission(id) ON DELETE CASCADE
) DEFAULT CHAR SET utf8;

CREATE TABLE user(
  id INT PRIMARY KEY AUTO_INCREMENT,
  login VARCHAR(20) UNIQUE NOT NULL,
  password VARCHAR(123) NOT NULL,
  name VARCHAR(30) NOT NULL,
  surname VARCHAR(30) NOT NULL,
  role_id INT REFERENCES role(id) ON DELETE SET NULL
) DEFAULT CHAR SET utf8;

CREATE TABLE file_group(
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL
) DEFAULT CHAR SET utf8;

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

    public function safeDown()
    {
        $sql = <<< SQL

DROP TABLE file;
DROP TABLE file_group;
DROP TABLE user;
DROP TABLE role_to_permission;
DROP TABLE permission;
DROP TABLE role

SQL;
        foreach (explode(";", $sql) as $s) {
            $this->execute($s);
        }
    }
}
