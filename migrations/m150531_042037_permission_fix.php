<?php

use yii\db\Migration;

class m150531_042037_permission_fix extends Migration
{
    public function safeUp()
    {
		$sql = <<< SQL

DROP TABLE IF EXISTS role_to_permission;
DROP TABLE IF EXISTS permission;

CREATE TABLE permission(
  id VARCHAR(50) PRIMARY KEY,
  name VARCHAR(100) NOT NULL
) DEFAULT CHAR SET utf8;

CREATE TABLE role_to_permission(
  role_id INT REFERENCES role(id) ON DELETE CASCADE,
  permission_id VARCHAR(50) REFERENCES permission(id) ON DELETE CASCADE
) DEFAULT CHAR SET utf8

SQL;
		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
    }
    
    public function safeDown()
    {
		$sql = <<< SQL

DROP TABLE IF EXISTS role_to_permission;
DROP TABLE IF EXISTS permission;

CREATE TABLE permission(
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(20) UNIQUE NOT NULL
) DEFAULT CHAR SET utf8;

CREATE TABLE role_to_permission(
  role_id VARCHAR(20) REFERENCES role(id) ON DELETE CASCADE,
  permission_id VARCHAR(20) REFERENCES permission(id) ON DELETE CASCADE
) DEFAULT CHAR SET utf8

SQL;
		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
    }
}
