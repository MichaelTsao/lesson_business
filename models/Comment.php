<?php

namespace dakashuo\lesson;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use mycompany\common\Logic;

/**
 * This is the model class for table "comment".
 *
 * @property string $comment_id
 * @property string $chapter_id
 * @property string $user_id
 * @property string $ctime
 * @property string $content
 * @property integer $status
 * @property integer $is_shield
 * @property User $user
 * @property Chapter $chapter
 * @property integer $like
 */
class Comment extends \yii\db\ActiveRecord
{
    const STATUS_AUDIT = 1;
    const STATUS_PASS = 2;
    const STATUS_REFUSE = 3;

    const NO_SHIELD = 1;
    const IS_SHIELD = 2;

    public static $statuses = [
        self::STATUS_AUDIT => '未审核',
        self::STATUS_PASS => '通过',
        self::STATUS_REFUSE => '拒绝',
    ];

    public static $shield = [
        self::NO_SHIELD => '正常',
        self::IS_SHIELD => '已屏蔽',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chapter_id', 'user_id', 'content'], 'required'],
            [['ctime'], 'safe'],
            [['status', 'is_shield'], 'integer'],
            [['comment_id', 'chapter_id', 'user_id'], 'string', 'max' => 12],
            [['content'], 'string', 'max' => 1000],
            ['chapter_id', 'exist', 'targetAttribute' => 'chapter_id', 'targetClass' => '\dakashuo\lesson\Chapter'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => '留言ID',
            'chapter_id' => '章节',
            'user_id' => '用户',
            'ctime' => '创建时间',
            'content' => '提问内容',
            'status' => '状态',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'comment_id',
                ],
                'value' => Logic::makeID(),
            ],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    public function getChapter()
    {
        return $this->hasOne(Chapter::className(), ['chapter_id' => 'chapter_id']);
    }

    public function getLike()
    {
        return Like::find()->where(['comment_id' => $this->comment_id])->count();
    }

    public function fields()
    {
        return [
            'comment_id',
            'name' => function ($model) {
                return $model->user->name;
            },
            'icon' => function ($model) {
                return $model->user->iconUrl;
            },
            'like',
            'content',
            'ctime',
        ];
    }
}
