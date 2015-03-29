<?php

namespace cabbage\kindeditor\models;

use Yii;

/**
 * This is the model class for table "uploads".
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $size
 * @property string $path
 * @property integer $user_id
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Upload extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uploads';
    }

//    /**
//     * @return \yii\db\Connection the database connection used by this AR class.
//     */
//    public static function getDb()
//    {
//        return Yii::$app->get('mrdadatour');
//    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['user_id', 'status', 'created_at', 'updated_at', 'size'], 'integer'],
            [['name', 'type', 'path', 'module', 'controller', 'action'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'size' => Yii::t('app', 'Size'),
            'path' => Yii::t('app', 'Path'),
            'user_id' => Yii::t('app', 'User ID'),
            'module' => Yii::t('app', 'Module'),
            'controller' => Yii::t('app', 'Controller'),
            'action' => Yii::t('app', 'Action'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
