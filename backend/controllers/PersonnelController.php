<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:44
 */

namespace backend\controllers;

use app\models\SmsAdmin;
use app\models\SmsAdminNoAuth;
use Composer\Package\Loader\ValidatingArrayLoader;
use Yii;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\web\Controller;

class PersonnelController extends Controller
{
    public function beforeAction($action)
    {
        if (empty(Yii::$app->user->identity)){
            return $this->redirect(['/default/login']);
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        $orgid = Yii::$app->user->identity->orgid;
        $name =Yii::$app->user->identity->name;
        if ($orgid == 2) {
            $sql = "select * from sms_admin ";
            $command = Yii::$app->db->createCommand('SELECT COUNT(*) FROM sms_admin ');
            $count = $command->queryScalar();
        } else {
            $sql = "select * from sms_admin where name= '".$name . "'";
            $command = Yii::$app->db->createCommand("SELECT COUNT(*) FROM sms_admin WHERE name= '" .$name . "'" );
            $count = $command->queryScalar();
        }

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 35,
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
        $model = new SmsAdminNoAuth();
        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $model['passwordRepeat'] = $params['SmsAdminNoAuth']['password'];
            $model->setAttributes([
                'username' => $params['SmsAdminNoAuth']['username'],
                'name' => $params['SmsAdminNoAuth']['username'],
                'password' => $params['SmsAdminNoAuth']['password'],
                'orgid' => intval($params['SmsAdminNoAuth']['orgid']),
            ]);
        }

        if (!empty(Yii::$app->request->post()) && $model->save()) {
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
        $model = SmsAdminNoAuth::findOne($id);
        $model['passwordRepeat'] = $model['password'];

        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $model['passwordRepeat'] = $params['SmsAdminNoAuth']['password'];
            $orgid = empty($params['SmsAdminNoAuth']['orgid']) ? 0 : $params['SmsAdminNoAuth']['orgid'];
            $model->setAttributes([
                'username' => $params['SmsAdminNoAuth']['username'],
                'name' => $params['SmsAdminNoAuth']['username'],
                'password' => $params['SmsAdminNoAuth']['password'],
                'orgid' => intval($orgid),
            ]);
        }

        if (!empty(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete()
    {
        $query = Yii::$app->request->queryParams;
        $id = $query['id'];
        $data = SmsAdminNoAuth::findOne($id);
        $data->delete();
        Yii::$app->cache->delete('index');
        return $this->redirect(['index']);
    }
}