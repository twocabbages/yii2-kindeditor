<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace cabbage\kindeditor;

use cabbage\kindeditor\models\Upload;
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
class MultiImage extends InputWidget
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
			echo Html::activeHiddenInput($this->model, $this->attribute, $this->options);
		} else {
			echo Html::hiddenInput($this->name, $this->value, $this->options);
		}
        echo Html::buttonInput('批量上传', ['id' => $this->id . '-button', 'class' => 'btn btn-primary']);


        $html =[];
        if($this->model->{$this->attribute}){
            foreach (Upload::find()->where(['IN', 'id', explode(',', $this->model->{$this->attribute})])->all() as $uploadModel) {
                $html[]= "<li id=\"li_{$uploadModel->id}\"><img src=\"{$uploadModel->path}\/{$uploadModel->name}\" width=\"80\" height=\"80\" /><a href=\"javascript:;\" onclick=\"removeImage('#{$this->id}', {$uploadModel->id})\"><span class=\"del\">delete</span></a></li>";
            }
        }
        $html = implode(PHP_EOL, $html);
        echo <<<STR
    <div class="img-list clearfix">
        <ul id="{$this->id}-view" style="-webkit-padding-start: 0px;list-style: none;">
        {$html}
        </ul>
    </div>
STR;
		$this->registerPlugin();
	}

	/**
	 * Registers CKEditor plugin
	 */
	protected function registerPlugin()
	{
		$view = $this->getView();

        $asset = MultiImageAsset::register($view);
        $asset->js[] = 'kindeditor/lang/' . $this->language . '.js';
        $asset->js[] = 'kindeditor/plugins/image/image.js';


        $clientOptions = Json::encode($this->clientOptions);

        $js[] = <<<STR
            KindEditor.ready(function(K) {
				var editor = K.editor({$clientOptions});
				K('#{$this->id}-button').click(function() {
					editor.loadPlugin('multiimage', function() {
						editor.plugin.multiImageDialog({
							clickFn : function(urlList) {
								var div = K('#{$this->id}-view');
								div.html('');
								K.each(urlList, function(i, data) {
									div.append('<li id="li_'+data.id+'"><img src="'+data.url+'" width="80" height="80" /><a href="javascript:;" onclick="removeImage("#{$this->id}",'+data.id+')"><span class="del">delete</span></a></li>');
									// 动态设置数目
                                    upNumVal( "#{$this->id}", 'inc');
                                    // 设置附件的值
                                    upAttachVal("#{$this->id}", 'add', data.id);
								});
								editor.hideDialog();
							}
						});
					});
				});
			});
STR;


        $view->registerJs(implode('\n', $js));
	}
}