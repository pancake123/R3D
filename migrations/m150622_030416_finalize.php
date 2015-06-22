<?php

use yii\db\Schema;
use yii\db\Migration;

class m150622_030416_finalize extends Migration
{
    public function safeUp()
    {
        $sql = <<< SQL

TRUNCATE TABLE role_to_permission;
TRUNCATE TABLE role;
TRUNCATE TABLE permission;
TRUNCATE TABLE file_group;

DELETE FROM role_to_permission;
DELETE FROM role;
DELETE FROM permission;
DELETE FROM file_group;

INSERT INTO role (id, name) VALUES (1, 'Пользователь');
INSERT INTO role (id, name) VALUES (2, 'Администратор');
INSERT INTO role (id, name) VALUES (3, 'Модератор');

INSERT INTO permission (id, name) VALUES ('FILE_READ', 'Может просматривать файлы');
INSERT INTO permission (id, name) VALUES ('FILE_WRITE', 'Может загружать файлы');
INSERT INTO permission (id, name) VALUES ('GROUP_READ', 'Может просматривать группы файлов');
INSERT INTO permission (id, name) VALUES ('GROUP_WRITE', 'Может изменять группы файлов');
INSERT INTO permission (id, name) VALUES ('MATERIAL_READ', 'Может просматривать материалы');
INSERT INTO permission (id, name) VALUES ('MATERIAL_WRITE', 'Может редактировать материалы');
INSERT INTO permission (id, name) VALUES ('MODEL_WRITE', 'Может редактировать модели файлов');
INSERT INTO permission (id, name) VALUES ('MODEL__READ', 'Может просматривать модели');
INSERT INTO permission (id, name) VALUES ('PERMISSION_READ', 'Может просматривать привилегии');
INSERT INTO permission (id, name) VALUES ('PERMISSION_WRITE', 'Может редактировать привилегии');
INSERT INTO permission (id, name) VALUES ('ROLE_READ', 'Может просматривать роли');
INSERT INTO permission (id, name) VALUES ('ROLE_WRITE', 'Может редактировать роли');
INSERT INTO permission (id, name) VALUES ('TEXTURE_READ', 'Может просматривать текстуры');
INSERT INTO permission (id, name) VALUES ('TEXTURE_WRITE', 'Может редактировать текстуры');
INSERT INTO permission (id, name) VALUES ('USER_READ', 'Может просматривать пользователей');
INSERT INTO permission (id, name) VALUES ('USER_WRITE', 'Может редактировать пользователей');

INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'ROLE_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'ROLE_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'USER_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'USER_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('12', 'ROLE_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('13', 'ROLE_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'PERMISSION_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'PERMISSION_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'FILE_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'FILE_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'GROUP_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'GROUP_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'MODEL_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'MODEL__READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('1', 'FILE_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('1', 'FILE_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('1', 'MODEL__READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('1', 'GROUP_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('1', 'MODEL_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'FILE_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'FILE_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'GROUP_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'GROUP_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'MODEL_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'MODEL__READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'PERMISSION_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'ROLE_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'TEXTURE_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'TEXTURE_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'USER_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'TEXTURE_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'TEXTURE_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('1', 'MATERIAL_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('1', 'TEXTURE_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'MATERIAL_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('2', 'MATERIAL_WRITE');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'MATERIAL_READ');
INSERT INTO role_to_permission (role_id, permission_id) VALUES ('3', 'MATERIAL_WRITE');

INSERT INTO file_group (id, name) VALUES ('archive', 'Архив');
INSERT INTO file_group (id, name) VALUES ('material', 'Материал');
INSERT INTO file_group (id, name) VALUES ('model', 'Модель');
INSERT INTO file_group (id, name) VALUES ('texture', 'Текстура');
INSERT INTO file_group (id, name) VALUES ('unknown', 'Неизвестный')

SQL;
        foreach (explode(";", $sql) as $s) {
            $this->execute($s);
        }
    }

    public function safeDown()  {
    }
}
