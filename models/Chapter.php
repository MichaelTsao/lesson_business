<?php

namespace dakashuo\lesson;

use Yii;

/**
 * This is the model class for table "chapter".
 *
 * @property string $chpater_id
 * @property string $lesson_id
 * @property string $name
 * @property string $cover
 * @property string $audio
 * @property string $contents
 * @property string $ctime
 */
class Chapter extends \yii\db\ActiveRecord
{
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
            [['chpater_id'], 'required'],
            [['ctime'], 'safe'],
            [['chpater_id', 'lesson_id'], 'string', 'max' => 12],
            [['name', 'cover', 'audio'], 'string', 'max' => 1000],
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
            'cover' => '封面',
            'audio' => '音频',
            'contents' => '内容',
            'ctime' => '创建时间',
        ];
    }
}
