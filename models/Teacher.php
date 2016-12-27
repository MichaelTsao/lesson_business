<?php

namespace dakashuo\lesson;

use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property string $teacher_id
 * @property string $name
 * @property string $phone
 * @property string $icon
 * @property string $title
 * @property string $intro
 * @property integer $status
 * @property string $ctime
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teacher_id'], 'required'],
            [['intro'], 'string'],
            [['status'], 'integer'],
            [['ctime'], 'safe'],
            [['teacher_id'], 'string', 'max' => 12],
            [['name'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['icon', 'title'], 'string', 'max' => 500],
            [['phone'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'teacher_id' => '导师ID',
            'name' => '名字',
            'phone' => '手机号',
            'icon' => '头像',
            'title' => '身份',
            'intro' => '介绍',
            'status' => '状态',
            'ctime' => '创建时间',
        ];
    }
}
