<?php

use yii\db\Schema;
use yii\db\Migration;

class m150531_042147_default_roles extends Migration
{
	public function safeUp()
	{
		$sql = <<< SQL

INSERT INTO role (name) VALUES
  ('Пользователь'),
  ('Администратор');

INSERT INTO permission (id, name) VALUES
  ('ROLE_READ', 'Может просматривать роли'),
  ('ROLE_WRITE', 'Может редактировать роли'),
  ('PRIVILEGE_READ', 'Может просматривать привилегии'),
  ('PRIVILEGE_WRITE', 'Может редактировать привилегии'),
  ('USER_READ', 'Может просматривать пользователей'),
  ('USER_WRITE', 'Может редактировать пользователей')

SQL;
		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
	}

	public function safeDown()
	{
		$sql = <<< SQL

TRUNCATE permission;
TRUNCATE role

SQL;
		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
	}
}
