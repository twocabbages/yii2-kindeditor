<?php

namespace cabbage\kindeditor\controllers;

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

        $basePath = \Yii::getAlias('@common/..');
        $date = date("Y{$this->separator}m", time());
        $uploadPath = "/Uploads/Attachment/{$date}";

        if(!is_dir($basePath . "/" . $uploadPath)){
            FileHelper::createDirectory($basePath . "/" . $uploadPath);
        }

        if(preg_match('/(\.[\S\s]+)$/', $file->name, $match)){
            $filename = md5(uniqid(rand())) . $match[1];
        }else{
            $filename = $file->name;
        }

        if($file->saveAs($basePath . '/' . $uploadPath . '/' . $filename)){
            return Json::encode(array('error' => 0, 'url' => $uploadPath . '/' .$filename));
        }else{
            return Json::encode(array('error' => 1, 'msg' => "上传失败"));
        }

    }
}
