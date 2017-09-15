<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%wechat_reply}}".
 *
 * @property integer $id
 * @property integer $status
 * @property string $input_key
 * @property string $result_content
 * @property string $add_time
 */
class WechatReplyModel extends ActiveRecord
{
    //启用状态
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_reply}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['result_content', 'add_time'], 'required'],
            [['result_content'], 'string'],
            [['add_time'], 'safe'],
            [['input_key'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => '状态是否启用',
            'input_key' => '用户输入的关键字',
            'result_content' => '微信回复的内容',
            'add_time' => '添加时间',
        ];
    }
}
