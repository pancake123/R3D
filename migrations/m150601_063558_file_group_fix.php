<?php

use yii\db\Schema;
use yii\db\Migration;

class m150601_063558_file_group_fix extends Migration
{
	public function safeUp()
	{
		$sql = <<< SQL

DROP TABLE file_group;

CREATE TABLE file_group(
  id VARCHAR(50) PRIMARY KEY,
  name VARCHAR(255) NOT NULL
) DEFAULT CHAR SET utf8

SQL;
		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
	}

	public function safeDown()
	{
		$sql = <<< SQL

DROP TABLE file_group;

CREATE TABLE file_group(
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL
) DEFAULT CHAR SET utf8

SQL;
		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
	}
}
