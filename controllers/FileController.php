<?php

namespace app\controllers;

use app\components\MimeType;
use app\forms\UploadForm;
use app\models\File;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;

class FileController extends Controller {

    public function behaviors() {
        return [
            'access' => [ 'class' => AccessControl::className(),
                'except' => [],
                'rules' => [
                    [ 'allow' => true, 'actions' => [ 'edit', 'update', 'create', 'delete' ], 'roles' => [ 'FILE_WRITE' ] ],
                    [ 'allow' => true, 'actions' => [ 'list' ], 'roles' => [ 'FILE_READ' ] ]
                ]
            ],
        ];
    }

    public static function generateName() {
		return Yii::$app->getSecurity()->generateRandomString(32);
	}

	public function actionList() {
		return $this->render('list', []);
	}

	public function actionUpload() {
		$transaction = Yii::$app->getDb()->beginTransaction();
		try {
			if (!Yii::$app->request->isPost) {
				throw new HttpException(503);
			}
			$model = new UploadForm();
			$model->file = UploadedFile::getInstance($model, 'file');
			if (!$model->file) {
				return null;
			}
			if (!$model->validate()) {
				print json_encode([
					'errors' => $model->errors,
					'status' => false
				]);
				Yii::$app->end();
			}
			$path = $this->generateName();
			$file = new File([
				'name' => $model->file->baseName.'.'.$model->file->extension,
				'path' => $path,
				'user_id' => Yii::$app->getUser()->getId(),
				'mime_type' => MimeType::match($model->file->extension),
				'file_group_id' => 'archive',
				'file_extension' => $model->file->extension
			]);
			if (!$file->save()) {
				throw new Exception('CAN\'T SAVE FILE INFO IN DATABASE');
			}
			if (!$model->file->saveAs($this->getDirectory($path))) {
				throw new Exception('CAN\'T UPLOAD FILE ON SERVER');
			}
			while (!file_exists($this->getDirectory($path))) {
				sleep(1);
			}
			$this->extractArchive($this->getDirectory($path), $file->getAttribute('id'));
			$transaction->commit();
		} catch (Exception $e) {
			$transaction->rollBack();
			throw $e;
		}
		return $this->redirect([ 'file/list' ]);
	}

	private function extractArchive($path, $parent) {
		$zip = new \ZipArchive();
		if (($er = $zip->open($path)) !== true) {
			throw new Exception("Can't open file as archive ($er)");
		}
		for ($i = 0; $i < $zip->numFiles; $i++) {
			$name = $this->generateName();
			$filename = $zip->getNameIndex($i);
			$mime = MimeType::match($filename);
			$ext = substr($filename, strrpos($filename, '.') + 1);
			if (preg_match('/image.*/', $mime)) {
				$group = 'texture';
			} else if ($mime == 'application/x-tgif') {
				$group = 'model';
			} else if ($ext == 'mtl') {
				$group = 'material';
			} else {
				$group = 'unknown';
			}
			$file = new File([
				'name' => $filename,
				'path' => $name,
				'user_id' => Yii::$app->getUser()->getId(),
				'mime_type' => $mime,
				'file_group_id' => $group,
				'file_extension' => $ext,
				'parent_id' => $parent,
			]);
			$file->save();
			if (!$zip->extractTo($this->getDirectory(), [ $filename ])) {
				throw new Exception("Can't extract file \"$filename\"");
			}
			rename($this->getDirectory($filename), $this->getDirectory($name));
		}
		$zip->close();
	}

	public static function getDirectory($file = null, $absolute = true) {
		if (static::$_path != null) {
			if ($absolute) {
				$path = static::$_path;
			} else {
				$path = substr(static::$_path, strlen(getcwd()) + 1);
			}
			if ($file != null) {
				return $path.$file;
			} else {
				return $path;
			}
		} else {
			chdir('..');
		}
		if (!@file_exists($path = getcwd().\Yii::$app->params['uploadDirectory']) && !@mkdir($path)) {
			throw new Exception("Can't create directory for uploaded files '$path'");
		} else {
			static::$_path = $path;
		}
		if ($absolute) {
			$path = static::$_path;
		} else {
			$path = substr(static::$_path, strlen(getcwd()) + 1);
		}
		if ($file != null) {
			return $path.$file;
		} else {
			return $path;
		}
	}

	private static $_path;
}