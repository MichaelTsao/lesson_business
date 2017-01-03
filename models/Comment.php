<?php

namespace dakashuo\lesson;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property string $comment_id
 * @property string $lesson_id
 * @property string $user_id
 * @property string $ctime
 * @property string $content
 * @property integer $status
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
        self::NO_SHIELD =>'正常',
        self::IS_SHIELD =>'已屏蔽',
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
            [['comment_id'], 'required'],
            [['ctime'], 'safe'],
            [['status'], 'integer'],
            [['comment_id', 'lesson_id', 'user_id'], 'string', 'max' => 12],
            [['content'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => '留言ID',
            'lesson_id' => '课程',
            'user_id' => '用户',
            'ctime' => '创建时间',
            'content' => '提问内容',
            'status' => '状态',
        ];
    }
}
