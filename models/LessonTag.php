<?php

namespace dakashuo\lesson;

use Yii;

/**
 * This is the model class for table "lesson_tag".
 *
 * @property string $lesson_id
 * @property string $tag
 * @property integer $sort
 */
class LessonTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id', 'tag'], 'required'],
            [['sort'], 'integer'],
            [['lesson_id'], 'string', 'max' => 12],
            [['tag'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lesson_id' => 'Lesson ID',
            'tag' => 'Tag',
            'sort' => 'Sort',
        ];
    }
}
