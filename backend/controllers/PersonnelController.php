<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:44
 */

namespace backend\controllers;

use Yii;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\web\Controller;

class PersonnelController extends Controller
{
    public function actionIndex()
    {
        $sql = "select * from sms_admin ";
        $command = Yii::$app->db->createCommand('SELECT COUNT(*) FROM sms_admin ');
        $count = $command->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);

        GridView::widget([
            'dataProvider' => $dataProvider,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEdit()
    {

    }

    public function actionDelete()
    {

    }
}