<?php

namespace dakashuo\lesson;

use Yii;

/**
 * This is the model class for table "reply".
 *
 * @property string $reply_id
 * @property string $comment_id
 * @property string $user_id
 * @property string $content
 * @property string $ctime
 */
class Reply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reply_id'], 'required'],
            [['ctime'], 'safe'],
            [['reply_id', 'comment_id', 'user_id'], 'string', 'max' => 12],
            [['content'], 'string', 'max' => 5000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reply_id' => '回复ID',
            'comment_id' => '留言',
            'user_id' => '用户',
            'content' => '内容',
            'ctime' => '创建时间',
        ];
    }
}
