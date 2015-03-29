<?php

namespace cabbage\kindeditor\controllers;

use cabbage\kindeditor\models\Upload;
use frontend\models\Article;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class DefaultController extends Controller
{
    public $separator = '/';

    public function actionIndex()
    {
        $file = UploadedFile::getInstanceByName('imgFile');

        $basePath = dirname(\Yii::getAlias('@common'));
        $date = date("Y{$this->separator}m", time());
        $uploadPath = "Uploads/Attachment/{$date}";

        if(!is_dir($basePath . "/" . $uploadPath)){
            FileHelper::createDirectory($basePath . "/" . $uploadPath);
        }

        if(preg_match('/(\.[\S\s]+)$/', $file->name, $match)){
            $filename = md5(uniqid(rand())) . $match[1];
        }else{
            $filename = $file->name;
        }
        $uploadData = [
            'type' => $file->type,
            'name' => $filename,
            'size' => $file->size,
            'path' => "/" . $uploadPath,

            'module' => null,//$this->action->controller->module->uniqueId,
            'controller' => null,//$this->action->controller->uniqueId,
            'action' => null,//$this->action->uniqueId,

            'user_id' => \Yii::$app->user->isGuest ? 0 : \Yii::$app->user->identity->id,
        ];
        $model = new Upload();

        $model->setAttributes($uploadData);
        $model->validate();

        if($model->save() && $file->saveAs($basePath . '/' . $uploadPath . '/' . $filename)){
            return Json::encode(array('error' => 0, 'url' => "/" . $uploadPath . '/' .$filename, 'id' => $model->id, 'name'=>$file->name));
        }else{
            return Json::encode(array('error' => 1, 'msg' => Json::encode($model->getErrors())));
        }

    }
}
