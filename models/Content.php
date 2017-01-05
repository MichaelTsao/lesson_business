<?php

namespace dakashuo\lesson;

use Yii;
use mycompany\common\Logic;

/**
 * This is the model class for table "content".
 *
 * @property string $content_id
 * @property integer $type
 * @property string $url
 * @property string $urlFull
 * @property string $content
 * @property string $ctime
 */
class Content extends \yii\db\ActiveRecord
{
    const TYPE_TITLE = 1;
    const TYPE_BODY = 2;
    const TYPE_IMAGE = 3;

    public static $types = [
        self::TYPE_TITLE => '标题',
        self::TYPE_BODY => '正文',
        self::TYPE_IMAGE => '图片',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['content_id', 'default', 'value' => Logic::makeID()],
            [['type'], 'required'],
            [['type'], 'integer'],
            [['content'], 'string'],
            [['ctime'], 'safe'],
            [['content_id'], 'string', 'max' => 12],
            [['url'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content_id' => '内容ID',
            'type' => '类型',
            'url' => '资源URL',
            'content' => '文字内容',
            'ctime' => '创建时间',
        ];
    }

    public function getUrlFull()
    {
        return Logic::getImageHost() . $this->url;
    }

    public function fields()
    {
        return [
            'content_id',
            'type',
            'url' => 'urlFull',
            'content',
        ];
    }
}
