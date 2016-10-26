<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:47
 */

namespace backend\controllers;


use app\models\Pic;
use app\models\ShootPic;
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

    public function actionMakingpic()
    {
        $this->layout = false;
        $id = \Yii::$app->request->get('id');
        $sql = "select path from pic where cid = :cid ";
        $model = Pic::findBySql($sql, [':cid' => $id])->all();
        return $this->render('makingpic', ['model' =>$model ]);
    }

    public function actionShootpic()
    {
        $this->layout = false;
        $id = \Yii::$app->request->get('id');
        $sql = "select path from shoot_pic where shoot_id = :shoot_id ";
        $model = ShootPic::findBySql($sql, [':shoot_id' => $id])->all();
        return $this->render('shootpic', ['model' =>$model ]);
    }

    public function actionMakingsingle()
    {
        $this->layout = false;
        $path = \Yii::$app->request->get('path');
        return $this->render('makingsingle', ['path' =>$path ]);
    }

    public function actionShootsingle()
    {
        $this->layout = false;
        $path = \Yii::$app->request->get('path');
        return $this->render('shootsingle', ['path' =>$path ]);
    }

}