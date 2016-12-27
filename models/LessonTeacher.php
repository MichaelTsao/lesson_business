<?php

namespace dakashuo\lesson;

use Yii;

/**
 * This is the model class for table "lesson_teacher".
 *
 * @property string $lesson_id
 * @property string $teacher_id
 * @property integer $sort
 */
class LessonTeacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson_teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id', 'teacher_id'], 'required'],
            [['sort'], 'integer'],
            [['lesson_id', 'teacher_id'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lesson_id' => '课程',
            'teacher_id' => '导师',
            'sort' => '排序',
        ];
    }
}
