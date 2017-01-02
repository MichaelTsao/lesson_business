<?php

namespace dakashuo\lesson;

use mycompany\common\Logic;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeTypecastBehavior;

/**
 * This is the model class for table "lesson".
 *
 * @property string $lesson_id
 * @property string $name
 * @property string $slogan
 * @property string $price
 * @property integer $period
 * @property integer $virtual_sub
 * @property string $intro
 * @property string $suitable
 * @property string $details
 * @property string $cover
 * @property string $poster
 * @property integer $status
 * @property string $start_time
 * @property string $end_time
 * @property string $ctime
 * @property string $coverUrl
 * @property string $posterUrl
 * @property \dakashuo\lesson\Teacher[] $teacher 授课老师
 * @property string $lastUpdateTime 最新章节更新时间
 * @property bool $isSubscribed
 * @property integer $subscribeCount
 * @property bool $hasFree
 */
class Lesson extends \yii\db\ActiveRecord
{
    const STATUS_NORMAL = 1;
    const STATUS_NOT_OPEN = 2;
    const STATUS_CLOSED = 3;

    public static $statuses = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_NOT_OPEN => '未开始',
        self::STATUS_CLOSED => '已下线',
    ];

    const PERIOD_YEAR = 1;
    const PERIOD_QUARTER = 2;
    const PERIOD_MONTH = 3;

    public static $periods = [
        self::PERIOD_MONTH => '月',
        self::PERIOD_QUARTER => '季',
        self::PERIOD_YEAR => '年',
    ];

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
            [['price'], 'number'],
            [['intro', 'suitable', 'details'], 'string'],
            [['period', 'virtual_sub', 'status'], 'integer'],
            [['start_time', 'end_time', 'ctime'], 'safe'],
            [['lesson_id'], 'string', 'max' => 12],
            [['name', 'slogan', 'cover', 'poster'], 'string', 'max' => 1000],
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
            'slogan' => '标语',
            'price' => '价格',
            'period' => '价格周期',
            'virtual_sub' => '虚拟订阅',
            'intro' => '简介',
            'suitable' => '适宜人群',
            'details' => '订阅须知',
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
            'typecast' => [
                'class' => AttributeTypecastBehavior::className(),
                'typecastAfterFind' => true,
            ],
        ];
    }

    public function getCoverUrl()
    {
        return Logic::getImageHost() . $this->cover;
    }

    public function getPosterUrl()
    {
        return Logic::getImageHost() . $this->poster;
    }

    public function getTeacher()
    {
        return Teacher::find()->joinWith('lesson l')->where(['l.lesson_id' => $this->lesson_id])->all();
    }

    public function getLastUpdateTime()
    {
        return '';
    }

    public function getLastUpdate()
    {
        return [];
    }

    public function getHasFree()
    {
        return false;
    }

    public function getIsSubscribed()
    {
        if (!Yii::$app->user->isGuest) {
            if (LessonUser::find()
                ->where([
                    'lesson_id' => $this->lesson_id,
                    'user_id' => Yii::$app->user->id,
                    'status' => LessonUser::STATUS_NORMAL
                ])
                ->one()
            ) {
                return true;
            }
        }
        return false;
    }

    public function getSubscribeCount()
    {
        return 0 + $this->virtual_sub;
    }

    public function fields()
    {
        return [
            'lesson_id',
            'name',
            'cover' => 'coverUrl',
            'poster' => 'posterUrl',
            'lastUpdate',
            'isSubscribed',
            'price',
            'period',
            'teacher',
            'slogan',
            'intro',
            'suitable',
            'details',
            'subscribeCount',
            'lastUpdateTime',
            'hasFree',
            'startTime' => 'start_time',
            'endTime' => 'end_time',
        ];
    }
}
