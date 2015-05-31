<?php

use yii\db\Schema;
use yii\db\Migration;

class m150531_060541_fake_users extends Migration
{
	public function up() {
		$this->generate(null, 750);
	}

	public function generate($role, $count) {
		$faker = \Faker\Factory::create("ru_RU");
		for ($i = 0; $i < $count; $i++) {
			try {
				$user = new \app\models\User();
				$user->setAttributes([
					"login" => $faker->userName,
					"password" => '$2y$13$KZ7pljfL9neMY5Bxhpf2g.9jZbgSj7ruDrlZ5aMIXfYhmldwEBgaS',
					"name" => $faker->firstName,
					"surname" => $faker->lastName,
					"role_id" => $role
				], false);
				$user->save();
			} catch (\Exception $e) {
			}
		}
	}
}
