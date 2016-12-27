<?php

namespace dakashuo\lesson;

use mycompany\common\Logic;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

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
            [['teacher_id', 'name'], 'required'],
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

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'teacher_id',
                ],
                'value' => Logic::makeID(),
            ],
        ];
    }
}
