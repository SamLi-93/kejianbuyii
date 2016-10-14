<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:48
 */

namespace backend\controllers;

use app\models\Project;
use app\models\Teacher;
use Yii;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\web\Controller;

class TeacherController extends Controller
{

    private $pro_school = [];
    private $teacher_list = [];

    public function init()
    {
        parent::init();
        $teacher = new Teacher();
        $pro_info = new Project();
        $this->teacher_list = $teacher->getTeacherList();
        $this->pro_school = $pro_info->getSchoolName();
    }

    public function actionIndex()
    {
        $searchModel = new Teacher();
        $query = Yii::$app->request->queryParams;
//        var_dump($query);exit;
        $sql_parms = '';
        if (!empty($query['Teacher'])) {
            $query_parms = array_filter($query['Teacher']);
            $sql_parms = 'where true';
        }

        if (isset($query_parms['teacher'])) {
            $sql_parms .= " and teacher = '" . $query_parms['teacher'] . "'";
        }

        if (isset($query_parms['college'])) {
            $sql_parms .= " and college = '" . $query_parms['college'] . "'";
        }

        $sql = "select * from teacher " . $sql_parms;

        $command = Yii::$app->db->createCommand('SELECT COUNT(*) FROM teacher ' . $sql_parms);
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
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'teacher_list' => $this->teacher_list,
            'pro_school' => $this->pro_school,
        ]);
    }

    public function actionCreate()
    {
        $model = new Teacher();
        $model->uploadname = 'test';   //目前是test   之后可以选择在登陆的时候 把username放到cache里 然后可以用.
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'pro_school' => $this->pro_school,
            ]);
        }
    }

    public function actionEdit()
    {

        $id = Yii::$app->request->get('id');
        $model = Teacher::findOne($id);

        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $model->setAttributes([
                'teacher' => $params['Teacher']['teacher'],
                'sex' => $params['Teacher']['sex'],
                'college' => $params['Teacher']['college'],
                'phone' => $params['Teacher']['phone'],
                'qq' => $params['Teacher']['qq'],
                'remarks' => $params['Teacher']['remarks'],
            ]);
        }

        if (!empty(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('edit', [
                'model' => $model,
                'pro_school' => $this->pro_school,
            ]);
        }
    }

    public function actionDelete()
    {
        $query = Yii::$app->request->queryParams;
        $id = $query['id'];
        $data = Teacher::findOne($id);
        $data->delete();

        Yii::$app->cache->delete('index');
        return $this->redirect(['index']);
    }
}