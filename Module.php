<?php

namespace cabbage\kindeditor;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'cabbage\kindeditor\controllers';

    public $type = 'file';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
