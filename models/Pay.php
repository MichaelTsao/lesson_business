<?php

namespace dakashuo\lesson;

use mycompany\common\Logic;
use Yii;

/**
 * This is the model class for table "pay".
 *
 * @property string $pay_id
 * @property string $user_id
 * @property string $lesson_id
 * @property string $transaction_number
 * @property integer $pay_channel
 * @property string $price
 * @property string $ctime
 * @property string $pay
 */
class Pay extends \yii\db\ActiveRecord
{
    const CHANNEL_WEIXIN = 1;
    const CHANNEL_OFFLINE = 2;

    public static $pay_channels = [
        self::CHANNEL_WEIXIN => '微信',
        self::CHANNEL_OFFLINE => '线下',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['pay_id', 'default', 'value' => Logic::makeID()],
            [['pay_id'], 'required'],
            [['pay_channel'], 'integer'],
            [['price'], 'number'],
            [['ctime'], 'safe'],
            [['pay_id', 'user_id', 'lesson_id'], 'string', 'max' => 12],
            [['transaction_number'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pay_id' => '支付ID',
            'user_id' => '用户',
            'lesson_id' => '课程ID',
            'transaction_number' => '交易单号',
            'pay_channel' => '支付渠道',
            'price' => '价格',
            'ctime' => '创建时间',
        ];
    }

    public function getLesson()
    {
        return $this->hasOne(Lesson::className(), ['lesson_id' => 'lesson_id']);
    }

    public function fields()
    {
        return [
            'pay_id',
            'price',
            'lessonName' => function ($model) {
                return $model->lesson->name;
            },
            'payChannel' => function ($model) {
                return isset(Pay::$pay_channels[$model->pay_channel]) ? Pay::$pay_channels[$model->pay_channel] : '';
            },
            'transaction_number',
            'ctime',
        ];
    }
}
