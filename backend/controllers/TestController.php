<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/29
 * Time: 9:22
 */

namespace backend\controllers;


use app\models\Tedeng;
use yii\web\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {
        $t1 = microtime(true);
        $conn = \Yii::$app->db;
        $sql = "select * from tedeng";
        $list = $conn->createCommand($sql)->queryAll();
        $t2 = microtime(true);
        $time = ($t2 - $t1) * 1000;
        var_dump($time);
        exit;
    }

    public function actionTest()
    {
        $t1 = microtime(true);
        $list = Tedeng::find()->all();
        $t2 = microtime(true);
        $time = ($t2 - $t1) * 1000;
        var_dump($time);
        exit;
    }
}