<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace cabbage\kindeditor;

use yii\web\AssetBundle;
use Yii;

class KindEditorAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = __DIR__ . "/bower_components/kindeditor";

        $this->js = [
          'kindeditor-min.js'
        ];

        $this->css = [
            'themes/default/default.css'
        ];
        parent::init(); // TODO: Change the autogenerated stub
    }
}