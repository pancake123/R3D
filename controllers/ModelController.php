<?php

namespace app\controllers;

use app\models\File;
use yii\base\Exception;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\web\HttpException;

class ModelController extends Controller {

	public function actionList() {
		return $this->render('list');
	}

	public function actionPreview() {
		if (!$id = \Yii::$app->getRequest()->getQueryParam('id')) {
			return $this->redirect([ 'model/list' ]);
		} else {
			return $this->render('preview', []);
		}
	}

	public function actionObject() {
		if (!$id = \Yii::$app->getRequest()->getQueryParam('id')) {
			throw new HttpException(400, 'Bad Request');
		}
		$file = File::find()->where([ 'parent_id' => $id, 'file_group_id' => 'model' ])->one();
		\Yii::$app->getResponse()->setDownloadHeaders($file->getAttribute('name'), $file->getAttribute('mime_type'))
			->sendFile(FileController::getDirectory($file->getAttribute('path')));
	}

	public function actionMaterial() {
		if (!$id = \Yii::$app->getRequest()->getQueryParam('id')) {
			throw new HttpException(400, 'Bad Request');
		}
		$file = File::find()->where([ 'parent_id' => $id, 'file_group_id' => 'material' ])->one();
		\Yii::$app->getResponse()->setDownloadHeaders($file->getAttribute('name'), $file->getAttribute('mime_type'))
			->sendFile(FileController::getDirectory($file->getAttribute('path')));
	}

	public function actionTexture() {
		if (!$id = \Yii::$app->getRequest()->getQueryParam('id')) {
			throw new HttpException(400, 'Bad Request');
		} else if (!$name = \Yii::$app->getRequest()->getQueryParam('name')) {
			throw new HttpException(400, 'Bad Request');
		}
		$file = File::find()->where([ 'parent_id' => $id, 'name' => $name, 'file_group_id' => 'texture' ])->one();
		\Yii::$app->getResponse()->setDownloadHeaders($file->getAttribute('name'), $file->getAttribute('mime_type'))
			->sendFile(FileController::getDirectory($file->getAttribute('path')));
	}
}