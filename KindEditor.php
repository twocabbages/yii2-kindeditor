<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace cabbage\kindeditor;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * CKEditor renders a CKEditor js plugin for classic editing.
 * @see http://docs.ckeditor.com/
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\ckeditor
 */
class KindEditor extends InputWidget
{
    public $clientOptions = [];

    public $uploadOptions = [];

    public $id = null;

    public $language = null;
	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		$this->initOptions();
	}

    public function initOptions(){
        if($this->language == null) $this->language = \Yii::$app->language;

        $this->clientOptions['allowFileManager'] = ArrayHelper::getValue($this->clientOptions, 'allowFileManager', false);
        $this->clientOptions['width'] = ArrayHelper::getValue($this->clientOptions, 'width', "100%");
        $this->clientOptions['minHeight'] = ArrayHelper::getValue($this->clientOptions, 'minHeight', "200px");
        $this->clientOptions['uploadJson'] = \Yii::$app->urlManager->createUrl(ArrayHelper::getValue($this->clientOptions, 'uploadJson', ['/upload']));
        $this->clientOptions['extraFileUploadParams'] = [\Yii::$app->request->csrfParam=>\Yii::$app->request->csrfToken];
        $this->clientOptions['uploadButtonExtraParams'] = [\Yii::$app->request->csrfParam=>\Yii::$app->request->csrfToken];


        $this->id = $this->options['id'];
    }

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		if ($this->hasModel()) {
			echo Html::activeTextarea($this->model, $this->attribute, $this->options);
		} else {
			echo Html::textarea($this->name, $this->value, $this->options);
		}
		$this->registerPlugin();
	}

	/**
	 * Registers CKEditor plugin
	 */
	protected function registerPlugin()
	{
		$view = $this->getView();

        $asset = KindEditorAsset::register($view);
        $asset->js[] = 'lang/' . $this->language . '.js';
        $asset->js[] = 'plugins/image/image.js';



//        $js = KindEditor.ready(function(K) {
//                editor = K.create('textarea[name="content"]', {
//                    allowFileManager : true
//                });
        $clientOptions = Json::encode($this->clientOptions);
        $js[] = "KindEditor.ready(function(K) {editor = K.create('textarea[id=\"{$this->id}\"]', {$clientOptions});})";

        $view->registerJs(implode('\n', $js));
	}
}