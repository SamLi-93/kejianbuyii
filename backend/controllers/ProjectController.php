<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:47
 */

namespace backend\controllers;

use app\models\Project;
use app\models\ProjectSearch;
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

    public function actionTest() {
        $project = new Project();
        $list = $project::find();
        print_r($list);exit;
    }


    public function actionIndex()
    {

        $this->layout = 'main';
        $searchModel = new ProjectSearch();

        $dataProvider = new ActiveDataProvider([
            'query' => Project::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        GridView::widget([
            'dataProvider' => $dataProvider,
        ]);

//        var_dump($dataProvider);exit;
        return $this->render('index',[
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