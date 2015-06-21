<?php

namespace app\controllers;

use app\models\File;
use yii\web\Controller;
use yii\web\HttpException;

class MaterialController extends Controller {

    public function actionList() {
        return $this->render('list');
    }

    public function actionLoad() {
        if (!$id = \Yii::$app->getRequest()->getQueryParam('id')) {
            throw new HttpException(400, 'Bad Request');
        }
        $file = File::find()->where([ 'id' => $id ])->one();
        print file_get_contents(FileController::getDirectory($file->getAttribute('path')));
    }
}