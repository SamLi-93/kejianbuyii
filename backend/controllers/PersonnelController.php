<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:44
 */

namespace backend\controllers;

use app\models\SmsAdmin;
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

    public function actionCreate()
    {
        $model = new SmsAdmin();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $model = Project::findOne($id);
//        $list = SmsAdmin::findBySql("SELECT name FROM sms_admin")->all();
//        foreach ($list as $k => $v) {
//            $key = $v['name'];
//            $uploadname_list[$key] = $v['name'];
//        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('edit', [
                'model' => $model,
                'person_list' => $this->person_list,
            ]);
        }

    }

    public function actionDelete()
    {

    }
}