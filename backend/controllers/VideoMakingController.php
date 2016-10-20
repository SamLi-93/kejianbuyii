<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:50
 */

namespace backend\controllers;

use app\models\SmsAdmin;
use app\models\Teacher;
use app\models\VideoMaking;
use app\models\VideoShoot;
use Yii;
use app\models\Project;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\grid\GridView;

class VideomakingController extends Controller
{
    private $pro_projectname = [];
    private $course_list = [];
    private $person_list = [];
    private $pro_school = [];
    private $teacher_list = [];

    public function init()
    {
        parent::init();
        $search_info = new VideoShoot();
        $course_info = new VideoMaking();
        $pro_info = new Project();
        $person = new SmsAdmin();
        $teacher = new Teacher();
        $this->pro_projectname = $pro_info->getProjectName();
        $this->pro_school = $pro_info->getSchoolName();
        $this->course_list = $course_info->getCourseList();
        $this->teacher_list = $teacher->getTeacherList();
        $this->person_list = $person->getPersonList();

    }

    public function actionIndex()
    {
        $searchModel = new VideoMaking();
        $query = Yii::$app->request->queryParams;
        $sql_parms = 'where a.pid = b.id';
        if (!empty($query['VideoMaking'])) {
            $query_parms = array_filter($query['VideoMaking']);
            $sql_parms = 'where a.pid = b.id';
        }

//        var_dump($query_parms);exit;

        if (isset($query_parms['projectname'])) {
            $sql_parms .= " and a.pid = '" . $query_parms['projectname'] . "'";
        }

        if (isset($query_parms['school'])) {
            $sql_parms .= " and b.school = '" . $query_parms['school'] . "'";
        }

        if (isset($query_parms['courcename'])) {
            $sql_parms .= " and a.courcename = '" . $query_parms['courcename'] . "'";
        }

        if (isset($query_parms['status'])) {
            $sql_parms .= " and a.status = '" . $query_parms['status'] . "'";
        }

        if (isset($query_parms['makingname'])) {
            $sql_parms .= " and a.makingname like '" . '%' . $query_parms['makingname'] . '%' . "'";
        }

        if (isset($query_parms['free'])) {
            if ($query_parms['free'] == 2) {
                $query_parms['free'] = 0;
            }
            $sql_parms .= " and a.free = '" . $query_parms['free'] . "'";
        }

        if (isset($query_parms['subtitle'])) {
            if ($query_parms['subtitle'] == 2) {
                $query_parms['subtitle'] = 0;
            }
            $sql_parms .= " and a.subtitle = '" . $query_parms['subtitle'] . "'";
        }

//        $sql = "select video_making.*, courseware.state from video_making
//inner join courseware on video_making.courcename = courseware.coursename " . $sql_parms;
//        $sql = "select * from video_making " . $sql_parms;
        $sql = "select a.id,a.makingname,a.subtitle,a.free,a.teacher,a.status, b.projectname,b.school,a.courcename,a.pid 
from video_making as a,project as b  " . $sql_parms;

//        var_dump($sql);exit;
        $command = Yii::$app->db->createCommand('SELECT COUNT(a.id) as num,a.makingname,a.subtitle,a.free,a.teacher,a.status, b.projectname,b.school,a.courcename,a.pid
 FROM video_making as a, project as b ' . $sql_parms);
        $count = $command->queryScalar();

//        var_dump($count);exit;

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
            'pro_projectname' => $this->pro_projectname,
            'pro_school' => $this->pro_school,
            'course_list' => $this->course_list,
            'person_list' => $this->person_list,
        ]);
    }


    public function actionCreate()
    {
        $model = new VideoMaking();
        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
//            print_r($params['VideoMaking']);exit;
            $makingname = implode('、', $params['VideoMaking']['makingname']);
            $model->setAttributes([
                'projectname' => $params['VideoMaking']['projectname'],
                'school' => $params['VideoMaking']['school'],
                'courcename' => $params['VideoMaking']['courcename'],
                'teacher' => $params['VideoMaking']['teacher'],
                'subtitle' => $params['VideoMaking']['subtitle'],
                'free' => $params['VideoMaking']['free'],
                'makingname' => $makingname,
                'pid' => $params['VideoMaking']['projectname']
            ]);
        }

//        var_dump(Yii::$app->request->post());exit;
//        var_dump($model->load(Yii::$app->request->post()));exit;

        if (!empty(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'pro_projectname' => $this->pro_projectname,
                'pro_school' => $this->pro_school,
                'course_list' => $this->course_list,
                'person_list' => $this->person_list,
                'teacher_list' => $this->teacher_list
            ]);
        }
    }

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $model = VideoMaking::findOne($id);
        $pid = $model['pid'];
        $project = Project::findBySql("select school from project where id = " . $pid)->all();
//        var_dump($project[0]['school']);exit;
        $model['school'] = $project[0]['school'];
//        print_r($model);exit;
//        var_dump(Yii::$app->request->post());exit;

        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
//            print_r($params['VideoMaking']);exit;
            $makingname = implode('、', $params['VideoMaking']['makingname']);
            $model->setAttributes([
                'projectname' => $params['VideoMaking']['projectname'],
                'school' => $params['VideoMaking']['school'],
                'courcename' => $params['VideoMaking']['courcename'],
                'teacher' => $params['VideoMaking']['teacher'],
                'subtitle' => $params['VideoMaking']['subtitle'],
                'free' => $params['VideoMaking']['free'],
                'makingname' => $makingname,
                'pid' => $params['VideoMaking']['projectname']
            ]);
        }


        if (!empty(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('edit', [
                'model' => $model,
                'pro_projectname' => $this->pro_projectname,
                'pro_school' => $this->pro_school,
                'course_list' => $this->course_list,
                'person_list' => $this->person_list,
                'teacher_list' => $this->teacher_list
            ]);
        }
    }

    public function actionDelete()
    {
        $query = Yii::$app->request->queryParams;
        $id = $query['id'];
        $data = VideoMaking::findOne($id);
        $data->delete();

        Yii::$app->cache->delete('index');
        return $this->redirect(['index']);

    }

    public function actionVerified()
    {
        $id_list = Yii::$app->request->post('ids');
        $db = Yii::$app->db;
        foreach ($id_list as $k => $v) {
            $res = $db->createCommand("update video_making set status = 1 where id=:id", array(":id" => $v))->execute();
        }

    }
}