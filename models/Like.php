<?php

namespace dakashuo\lesson;

use Yii;

/**
 * This is the model class for table "like".
 *
 * @property string $comment_id
 * @property string $user_id
 * @property string $ctime
 */
class Like extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_id', 'user_id'], 'required'],
            [['ctime'], 'safe'],
            [['comment_id', 'user_id'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => '留言',
            'user_id' => '用户',
            'ctime' => '创建时间',
        ];
    }
}
