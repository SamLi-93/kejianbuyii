<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:47
 */

namespace backend\controllers;

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
        $searchModel = new ProjectSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Project::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('test', [
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
            'pro_over' => $this->pro_over,
        ]);
    }


    public function actionIndex()
    {

        $this->layout = 'main';
        $searchModel = new ProjectSearch();
        $query = Yii::$app->request->queryParams;
//        print_r($query['ProjectSearch']['projectname']); exit;

//        if (empty($query)) {
//            $projectname = "'%%'";
//            $school = "'%%'";
//            $teacher = "'%%'";
//            $over = "'%%'";
//        } else {
//            $projectname = $query['ProjectSearch']['projectname'];
//            $school = $query['ProjectSearch']['school'];
//            $teacher = $query['ProjectSearch']['teacher'];
//            $over = $query['ProjectSearch']['over'];
//        }

        $projectname = "'%%'";
        $school = "'%%'";
        $teacher = "'%%'";
        $over = "'%%'";
        $sql_add = '';

        if (!empty($query['ProjectSearch'])) {
            $sql_add = "where";
            if(empty($query['ProjectSearch']['projectname'])) {
                $projectname = "'%%'";
            } else {
                $projectname = $query['ProjectSearch']['projectname'];
                $sql_add .= " projectname like " . '. $projectname  .'  ;
            }
            if(empty($query['ProjectSearch']['school'])) {
                $school = "'%%'";
            } else {
                $school = $query['ProjectSearch']['school'];
                $sql_add .= " school like " . '. $school  .'  ;
            }
            if(empty($query['ProjectSearch']['teacher'])) {
                $teacher = "'%%'";
            } else {
                $teacher = $query['ProjectSearch']['teacher'];
                $sql_add .= " teacher like " . '. $teacher  .'  ;
            }
            if(empty($query['ProjectSearch']['over'])) {
                $over = "'%%'";
            } else {
                $over = $query['ProjectSearch']['over'];
                $sql_add .= " over like " . '. $over  .'  ;
            }
        }




//        $dataProvider = new ActiveDataProvider([
//            'query' => Project::find(),
//            'pagination' => [
//                'pageSize' => 20,
//            ],
//        ]);

//        $test1 = Project::findBySql("select * from project
//where projectname=:projectname and school=:school and teacher=:teacher and over=:over ")->all();

        var_dump($sql_add);exit;

        $conn = Yii::$app->db;
        $sql = "select * from project " . $sql_add;
        $test1 = $conn->createCommand($sql)->queryAll();


        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM project')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => "select * from project 
where projectname like ". $projectname." and school like " . $school. " and teacher like " . $teacher. " and over like " . $over,
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

        $test = Project::find()->orFilterWhere([
            'projectname' => $projectname,
            'school' =>  $school,
            'teacher' => $teacher,
            'over' => $over,
        ])->all();

        $test1 = Project::findBySql("select * from project 
where projectname like ". $projectname." and school like " . $school. " and teacher like " . $teacher. " and over like " . $over)->all();

//        print_r($test1);exit;

//        print_r($test);exit;

//        print_r($dataProvider);exit;

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

    }

    public function actionEdit()
    {

    }

    public function actionDelete()
    {

    }
}