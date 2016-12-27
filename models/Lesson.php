<?php

namespace dakashuo\lesson;

use mycompany\common\Logic;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "lesson".
 *
 * @property string $lesson_id
 * @property string $name
 * @property string $price
 * @property integer $period
 * @property string $intro
 * @property string $details
 * @property string $cover
 * @property string $poster
 * @property integer $status
 * @property string $start_time
 * @property string $end_time
 * @property string $ctime
 * @property string $coverUrl
 */
class Lesson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id'], 'required'],
            [['price'], 'number'],
            [['details'], 'string'],
            [['period', 'status'], 'integer'],
            [['start_time', 'end_time', 'ctime'], 'safe'],
            [['lesson_id'], 'string', 'max' => 12],
            [['name', 'intro', 'cover', 'poster'], 'string', 'max' => 1000],
            [['name'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lesson_id' => '课程ID',
            'name' => '名字',
            'price' => '价格',
            'period' => '价格周期',
            'intro' => '简介',
            'details' => '详情',
            'cover' => '封面',
            'poster' => '海报',
            'status' => '状态',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'ctime' => '创建时间',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'lesson_id',
                ],
                'value' => Logic::makeID(),
            ],
        ];
    }

    public function getCoverUrl()
    {
        $host = '';
        if (isset(Yii::$app->params['imageHost'])) {
            $host = Yii::$app->params['imageHost'];
        }
        return $host . $this->cover;
    }

    public function fields()
    {
        return [
            'lesson_id',
            'name',
            'cover' => 'coverUrl',
        ];
    }
}
