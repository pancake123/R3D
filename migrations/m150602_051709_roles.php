<?php

use yii\db\Schema;
use yii\db\Migration;

class m150602_051709_roles extends Migration
{
	public function safeUp()
	{
		$sql = <<< SQL

INSERT INTO r3d.permission (id, name) VALUES ('FILE_READ', 'Может просматривать файлы');
INSERT INTO r3d.permission (id, name) VALUES ('FILE_WRITE', 'Может загружать файлы');
INSERT INTO r3d.permission (id, name) VALUES ('GROUP_READ', 'Может просматривать группы файлов');
INSERT INTO r3d.permission (id, name) VALUES ('GROUP_WRITE', 'Может изменять группы файлов');

SQL;
		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
	}

	public function safeDown()
	{
		$sql = <<< SQL



SQL;
		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
	}
}
