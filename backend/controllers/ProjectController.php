<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:47
 */

namespace backend\controllers;

use app\models\SmsAdmin;
use Yii;
use app\models\Project;
use app\models\ProjectSearch;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;


class ProjectController extends Controller
{
    private $pro_projectname = [];
    private $pro_school = [];
    private $pro_teacher = [];
    private $pro_over = [];


    public function init()
    {
        parent::init();
        $pro_info = new Project();
        $this->pro_projectname = $pro_info->getProjectName();
        $this->pro_school = $pro_info->getSchoolName();
        $this->pro_teacher = $pro_info->getTeacherName();
        $this->pro_over = $pro_info->getOverList();
    }

    public function actionTest()
    {
        $model['id'] = '123';
        $tst = "changeover(this.options[this.options.selectedIndex].value," . $model['id'] . " , few)";
        print_r($tst);
        exit;
    }

    public function actionIndex()
    {
        $this->layout = 'main';
        $searchModel = new ProjectSearch();
        $query = Yii::$app->request->queryParams;
        $sql_parms = '';
        if (!empty($query['ProjectSearch'])) {
            $query_parms = array_filter($query['ProjectSearch']);
            $sql_parms = 'where true';
        }

        if (isset($query_parms['projectname'])) {
            $sql_parms .= " and projectname = '" . $query_parms['projectname'] . "'";
        }

        if (isset($query_parms['school'])) {
            $sql_parms .= " and school = '" . $query_parms['school'] . "'";
        }

        if (isset($query_parms['teacher'])) {
            $sql_parms .= " and teacher = '" . $query_parms['teacher'] . "'";
        }

        if (isset($query_parms['over'])) {
            if ($query_parms['over'] == 2) {
                $query_parms['over'] = 0;
            }
            $sql_parms .= " and over = '" . $query_parms['over'] . "'";
        }

        $sql = "select * from project " . $sql_parms;

        $command = Yii::$app->db->createCommand('SELECT COUNT(*) FROM project ' . $sql_parms);
        $command->bindParam(':projectname', $projectname);
        $command->bindParam(':school', $school);
        $command->bindParam(':teacher', $teacher);
        $command->bindParam(':over', $over);
        $count = $command->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
//            'params' => [':status' => 1],
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
            'pro_projectname' => $this->pro_projectname,
            'pro_school' => $this->pro_school,
            'pro_teacher' => $this->pro_teacher,
            'pro_over' => $this->pro_over,
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new Project();
        $list = SmsAdmin::findBySql("SELECT name FROM sms_admin")->all();
        foreach ($list as $k => $v) {
            $key = $v['name'];
            $uploadname_list[$key] = $v['name'];
        }
//        print_r($uploadname_list);exit;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'pro_projectname' => $this->pro_projectname,
                'pro_school' => $this->pro_school,
                'pro_teacher' => $this->pro_teacher,
                'pro_over' => $this->pro_over,
                'uploadname_list' => $uploadname_list,
            ]);
        }
    }

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $model = Project::findOne($id);
        $list = SmsAdmin::findBySql("SELECT name FROM sms_admin")->all();
        foreach ($list as $k => $v) {
            $key = $v['name'];
            $uploadname_list[$key] = $v['name'];
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('edit', [
                'model' => $model,
                'uploadname_list' => $uploadname_list,
            ]);
        }
    }

    public function actionDelete()
    {
        $query = Yii::$app->request->queryParams;
        $id = $query['id'];
        $data = Project::findOne($id);
        $data->delete();

        Yii::$app->cache->delete('index');
        return $this->redirect(['index']);
    }

    public function actionChangeover()
    {
        $query = Yii::$app->request->post();
        $id = $query['id'];
        $value = $query['value'];
        $model= Project::findOne($id);
        $model->over = $value;
        if ($model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return \Yii::$app->getSession()->setFlash('error', '修改失败');
        }
    }

    public function actionChangefree()
    {
        $query = Yii::$app->request->post();
        $id = $query['id'];
        $value = $query['value'];
        $model= Project::findOne($id);
        $model->free = $value;
        if ($model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return \Yii::$app->getSession()->setFlash('error', '修改失败');
        }
    }


}