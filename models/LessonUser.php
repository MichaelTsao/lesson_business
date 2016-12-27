<?php

namespace dakashuo\lesson;

use Yii;

/**
 * This is the model class for table "lesson_user".
 *
 * @property string $lesson_id
 * @property string $user_id
 * @property integer $type
 * @property integer $pay_id
 * @property string $start_time
 * @property string $end_time
 * @property integer $status
 * @property string $remark
 * @property string $ctime
 */
class LessonUser extends \yii\db\ActiveRecord
{
    const STATUS_NORMAL = 1;
    const STATUS_CLOSED = 2;
    const STATUS_FINISH = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id', 'user_id'], 'required'],
            [['type', 'pay_id', 'status'], 'integer'],
            [['start_time', 'end_time', 'ctime'], 'safe'],
            [['lesson_id', 'user_id'], 'string', 'max' => 12],
            [['remark'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lesson_id' => '课程',
            'user_id' => '用户',
            'type' => '支付方式',
            'pay_id' => '支付',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'status' => '状态',
            'remark' => '备注',
            'ctime' => '创建时间',
        ];
    }
}
