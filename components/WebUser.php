<?php

namespace app\components;

use app\models\Permission;
use yii\web\User;

class WebUser extends User {

	public function can($permissionName, $params = [], $allowCaching = true) {
		if (\Yii::$app->getUser()->getIsGuest()) {
			return false;
		}
		if ($allowCaching && isset($this->_access[$permissionName])) {
			return $this->_access[$permissionName];
		}
		/* @var $user \app\models\User */
		if (!$user = \app\models\User::findOne([ "id" => $this->getId() ])) {
			return false;
		}
		$access = Permission::checkAccess($user->getAttribute("id"), $permissionName);
		if ($allowCaching && empty($params)) {
			return $this->_access[$permissionName] = $access;
		} else {
			return $access;
		}
	}

	private $_access = [];
}