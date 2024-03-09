<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;


/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ProcessController extends Controller
{

    public function actionQueue()
    {
        $counter = 0;
        while (true) {
            $counter++;

            if (file_exists(__DIR__ . '\..\runtime\queue.job') == true) {
                $file = file_get_contents(__DIR__ . '\..\runtime\queue.job');
                echo $file;
                unlink(__DIR__ . '\..\runtime\queue.job');
            } else {
            }

            echo 'Количество итераций: ' . $counter . PHP_EOL;
            sleep(2);
        }

        return ExitCode::OK;
    }
}