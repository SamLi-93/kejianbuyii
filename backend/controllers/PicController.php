<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:47
 */

namespace backend\controllers;


use app\models\Pic;
use yii\web\Controller;

class PicController extends Controller
{
    public function actionIndex()
    {
        $this->layout = false;
        $id = \Yii::$app->request->get('id');
        $sql = "select path from pic where cid = :cid ";
        $model = Pic::findBySql($sql, [':cid' => $id])->all();
        return $this->render('index', ['model' =>$model ]);

    }

}