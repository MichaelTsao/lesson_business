<?php

namespace dakashuo\lesson;

/**
 * This is the model class for table "user".
 *
 * @property string $user_id
 * @property string $name
 * @property string $icon
 * @property string $weixin_id
 * @property integer $status
 * @property string $ctime
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_NORMAL = 1;
    const STATUS_CLOSED = 2;

    public $statuses = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_CLOSED => '关闭',
    ];

    public static function tableName()
    {
        return 'user';
    }

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

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if ('token' === $token) {
            $id = 1;
            return User::findOne($id);
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
//        return $this->password === $password;
        return false;
    }
}
