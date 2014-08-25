### Install
```
composer require "cabbage/yii2-kindeditor"
```
### In config
```
'modules'=>[
    'upload' => [
        'class' => 'cabbage\kindeditor\Module',
    ],
]
```
### In view
```
    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'content'=>['type'=> Form::INPUT_WIDGET,'widgetClass'=>\cabbage\kindeditor\KindEditor::className(), 'options'=>[]],
    ]
    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>
```
