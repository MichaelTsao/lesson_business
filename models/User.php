<?php

namespace dakashuo\lesson;

use mycompany\common\Logic;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property string $user_id
 * @property string $name
 * @property string $icon
 * @property string $iconUrl
 * @property string $weixin_id
 * @property integer $status
 * @property string $ctime 创建时间
 * @property \dakashuo\lesson\Lesson[] $lesson 订阅课程
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_NORMAL = 1;
    const STATUS_CLOSED = 2;

    public static $statuses = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_CLOSED => '关闭',
    ];

    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['status'], 'integer'],
            [['ctime'], 'safe'],
            [['user_id'], 'string', 'max' => 12],
            [['name', 'icon'], 'string', 'max' => 500],
            [['weixin_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户ID',
            'name' => '名字',
            'icon' => '头像',
            'weixin_id' => '微信open_id',
            'status' => '用户状态',
            'ctime' => '创建时间',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        if ($user = static::findOne($id)) {
            return $user;
        }

        return null;
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'user_id',
                ],
                'value' => Logic::makeID(),
            ],
        ];
    }

    public function getLesson()
    {
        return $this->hasMany(Lesson::className(), ['lesson_id' => 'lesson_id'])
            ->viaTable('lesson_user', ['user_id' => 'user_id'], function($query){
                $query->andWhere(['status' => LessonUser::STATUS_NORMAL]);
            });
    }

    public function getIconUrl()
    {
        return Logic::getImageHost() . $this->icon;
    }

    /*
     * functions below is import from Interface IdentityInterface
     */

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if ('token' === $token) {
            return User::find()->one();
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        if ($user = static::findOne(['name' => $username])) {
            return $user;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return false;
    }
}
