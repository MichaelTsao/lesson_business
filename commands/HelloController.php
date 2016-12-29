<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use dakashuo\lesson\Lesson;
use dakashuo\lesson\User;
use mycompany\common\Logic;
use yii\console\Controller;
use yii\debug\models\search\Log;
use yii\helpers\ArrayHelper;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        echo Logic::makeID()."\n";

        $lesson = Lesson::findOne('5ojj0wzrw4z');
        foreach($lesson->teacher as $teacher){
            echo $teacher->name."\n";
        }
    }
}
