<?php

namespace dakashuo\lesson;

use Yii;
use mycompany\common\Logic;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "chapter".
 *
 * @property string $chapter_id
 * @property string $lesson_id
 * @property string $name
 * @property string $slogan
 * @property string $cover
 * @property string $coverUrl
 * @property string $audio
 * @property string $audioUrl
 * @property integer $listen
 * @property integer $virtual_listen
 * @property integer $listenCount
 * @property integer $is_free
 * @property string $teller
 * @property string $contents
 * @property \dakashuo\lesson\Content[] $content
 * @property integer $status
 * @property string $ctime
 */
class Chapter extends \yii\db\ActiveRecord
{
    const STATUS_ONLINE = 1;
    const STATUS_OFFLINE = 2;

    public static $statuses = [
        self::STATUS_ONLINE => '上线',
        self::STATUS_OFFLINE => '下线',
    ];

    const IS_FREE_YES = 1;
    const IS_FREE_NO = 2;

    public static $isFree = [
        self::IS_FREE_YES => '免费',
        self::IS_FREE_NO => '收费',
    ];

    protected $_content = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chapter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['listen', 'virtual_listen', 'is_free', 'status'], 'integer'],
            [['ctime'], 'safe'],
            [['chpater_id', 'lesson_id'], 'string', 'max' => 12],
            [['name', 'slogan', 'cover', 'audio'], 'string', 'max' => 1000],
            [['teller'], 'string', 'max' => 50],
            [['contents'], 'string', 'max' => 10000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chpater_id' => '章节ID',
            'lesson_id' => '课程',
            'name' => '标题',
            'slogan' => '标语',
            'cover' => '封面',
            'audio' => '音频',
            'listen' => '收听次数',
            'virtual_listen' => '虚拟收听',
            'is_free' => '是否免费',
            'teller' => '讲述者',
            'contents' => '内容',
            'status' => '状态',
            'ctime' => '创建时间',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'chapter_id',
                ],
                'value' => Logic::makeID(),
            ],
        ];
    }

    public function getCoverUrl()
    {
        return Logic::getImageHost() . $this->cover;
    }

    public function getAudioUrl()
    {
        return Logic::getImageHost() . $this->audio;
    }

    public function getListenCount()
    {
        return $this->listen + $this->virtual_listen;
    }

    public function getContent()
    {
        if ($this->_content === null) {
            $this->_content = [];
            if ($contentId = json_decode($this->contents, true)) {
                foreach ($contentId as $id) {
                    $this->_content[] = Content::findOne($id);
                }
            }
        }
        return $this->_content;
    }

    public function getLesson()
    {
        return $this->hasOne(Lesson::className(), ['lesson_id' => 'lesson_id']);
    }

    public function fields()
    {
        return [
            'chapter_id',
            'name',
            'slogan',
            'cover' => 'coverUrl',
            'audio' => 'audioUrl',
            'listenCount',
            'isFree' => 'is_free',
            'teller',
            'content',
            'ctime',
        ];
    }
}
