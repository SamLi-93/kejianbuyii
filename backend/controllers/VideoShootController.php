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
use app\models\VideoShootSearch;
use app\models\VideoShoot;
use Yii;
use app\models\Project;
use app\models\ProjectSearch;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\grid\GridView;

class VideoshootController extends Controller
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
        $pro_info = new Project();
        $person = new SmsAdmin();
        $teacher = new Teacher();
        $this->pro_projectname = $search_info->getProjectName();
        $this->pro_school = $pro_info->getSchoolName();
        $this->course_list = $search_info->getCourseList();
        $this->teacher_list = $teacher->getTeacherList();
        $this->person_list = $person->getPersonList();

    }

    public function actionTest()
    {
        $params['VideoShoot'] =
            ['projectname' => '人才师资培训', 'school' => '电子商务厅', 'courcename' => '电子商务专业人才师资培训',
                'teacher' => '崔相一','recordname' => [ '0' => '李温乐', '1' => '童剑凯', '2' => '葛海其' ],
        'time' => '2016-10-20 02:50', 'seat' => 444, 'uploadname' => '陈麒杰' ];


        $model = new VideoShoot();
        $recordname = implode('、', $params['VideoShoot']['recordname']);
//            var_dump($recordname);exit;
        $model->setAttributes([
            'projectname' => $params['VideoShoot']['projectname'],
            'school' => $params['VideoShoot']['school'],
            'courcename' => $params['VideoShoot']['courcename'],
            'teacher' => $params['VideoShoot']['teacher'],
            'recordname' => '一级审核中111',
            'seat' => intval($params['VideoShoot']['seat']),
            'uploadname' => $params['VideoShoot']['uploadname'],
            'status' => $recordname,
            'capture_time' => 00,
            'time1' => null,
            'time' => $params['VideoShoot']['time'],

        ]);

        var_dump($model->save());exit;

    }

    public function actionIndex()
    {
        $searchModel = new VideoShoot();
        $query = Yii::$app->request->queryParams;
        $sql_parms = '';
        if (!empty($query['VideoShoot'])) {
            $query_parms = array_filter($query['VideoShoot']);
            $sql_parms = 'where true';
        }

//        var_dump($query_parms);exit;

        if (isset($query_parms['projectname'])) {
            $sql_parms .= " and projectname = '" . $query_parms['projectname'] . "'";
        }

        if (isset($query_parms['courcename'])) {
            $sql_parms .= " and courcename = '" . $query_parms['courcename'] . "'";
        }

        if (isset($query_parms['recordname'])) {
            $sql_parms .= " and recordname like  '" . '%' . $query_parms['recordname'] . '%' . "'";
        }

        if (isset($query_parms['uploadname'])) {
            $sql_parms .= " and uploadname like '" . '%' . $query_parms['uploadname'] . '%' . "'";
        }

        if (isset($query_parms['time'])) {
            if (isset($query_parms['time1'])) { //年份月份全有
                $year = $query_parms['time'];
                $month = $query_parms['time1'];
                $time1 = $query_parms['time'] . '/' . $query_parms['time1'];
                if ($month > 9) {
                    $time2 = $year . '-' . $month;
                } else {
                    $time2 = $year . '-0' . $month;
                }

                $sql_parms .= " and time like '" . $time1 . '%' . "'" . " or time like '" . $time2 . '%' . "'";
            } else {
                $sql_parms .= " and time like '" . $query_parms['time'] . '%' . "'";
            }
        }

//        var_dump($sql_parms);exit;

        $sql = "select * from video_shoot " . $sql_parms;

        $command = Yii::$app->db->createCommand('SELECT COUNT(*) FROM video_shoot ' . $sql_parms);
//        $command->bindParam(':projectname', $projectname);
//        $command->bindParam(':courcename', $coursename);
//        $command->bindParam(':recordname', $recordname);
//        $command->bindParam(':uploadname', $uploadname);
//        $command->bindParam(':time', $time);
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
            'pro_projectname' => $this->pro_projectname,
            'course_list' => $this->course_list,
            'person_list' => $this->person_list,
        ]);
    }

    public function actionCreate()
    {
        var_dump(Yii::$app->request->post());
        $model = new VideoShoot();

        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
//            print_r($params['VideoShoot']);exit;
            $recordname = implode('、', $params['VideoShoot']['recordname']);
//            var_dump($recordname);exit;
            $model->setAttributes([
                'projectname' => $params['VideoShoot']['projectname'],
                'school' => $params['VideoShoot']['school'],
                'courcename' => $params['VideoShoot']['courcename'],
                'teacher' => $params['VideoShoot']['teacher'],
                'status' => '一级审核中',
                'seat' => intval($params['VideoShoot']['seat']),
                'uploadname' => $params['VideoShoot']['uploadname'],
                'capture_time' => 00,
                'time1' => null,
                'time' => $params['VideoShoot']['time'],
                'recordname' => $recordname,
            ]);

//            $model->projectname = $params['VideoShoot']['projectname'];
//            $model->school = $params['VideoShoot']['school'];
//            $model->courcename = $params['VideoShoot']['courcename'];
//            $model->teacher = $params['VideoShoot']['teacher'];
//            $model->status = '一级审核中';
//            $model->seat = intval($params['VideoShoot']['seat']);
//            $model->uploadname = $params['VideoShoot']['uploadname'];
//            $model->capture_time = 00;
//            $model->time1 = null;
//            $model->time = $params['VideoShoot']['time'];
//            $model->recordname = $params['VideoShoot']['recordname'];
        }

        if (!empty(Yii::$app->request->post())&&$model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'recordname1' => $model,
                'recordname2' => $model,
                'recordname3' => $model,
                'recordname4' => $model,
                'pro_projectname' => $this->pro_projectname,
                'course_list' => $this->course_list,
                'person_list' => $this->person_list,
                'pro_school' => $this->pro_school,
                'teacher_list' => $this->teacher_list,
            ]);
        }
    }

    public function actionChangecheck()
    {
        $school_list = '';
        $params =  Yii::$app->request->post();
        $pro_name = $params['value'];

        if (!empty($pro_name)) {
            $school_sql = "select school from project where projectname = :projectname" ;
            $list1 = Project::findBySql($school_sql, array(":projectname"=>$pro_name))->all();
            $course_sql = "select courcename from video_making where projectname = :projectname" ;
            $list2 = VideoMaking::findBySql($course_sql, array(":projectname"=>$pro_name))->all();
//            print_r($course_list[0]['courcename']);exit;
        } else {
            $school_sql = "select school from project" ;
            $list1 = Project::findBySql($school_sql)->all();
            $course_sql = "select courcename from video_making" ;
            $list2 = VideoMaking::findBySql($course_sql)->all();
        }
        $educational = array();
        $coursename = array();
        foreach ($list1 as $key => $value) {
            $school = $value['school'];
            if(array_search($school, $educational) !== false){

            }else{
                $educational[] = $school;
            }
        }
        foreach ($list2 as $key => $value) {
            $courcename = $value['courcename'];
            if(array_search($courcename, $coursename) !== false){

            }else{
                $coursename[] = $courcename;
            }
        }
        return $return_info = json_encode(array('coursename'=>$coursename,'educational'=>$educational));
        exit;

    }

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $model = VideoShoot::findOne($id);

        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $recordname = implode('、', $params['VideoShoot']['recordname']);
            $model->setAttributes([
                'projectname' => $params['VideoShoot']['projectname'],
                'school' => $params['VideoShoot']['school'],
                'courcename' => $params['VideoShoot']['courcename'],
                'teacher' => $params['VideoShoot']['teacher'],
                'status' => '一级审核中',
                'seat' => intval($params['VideoShoot']['seat']),
                'uploadname' => $params['VideoShoot']['uploadname'],
                'capture_time' => 00,
                'time1' => null,
                'time' => $params['VideoShoot']['time'],
                'recordname' => $recordname,
            ]);
        }

        if (!empty(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('edit', [
                'model' => $model,
                'pro_projectname' => $this->pro_projectname,
                'course_list' => $this->course_list,
                'person_list' => $this->person_list,
                'pro_school' => $this->pro_school,
                'teacher_list' => $this->teacher_list,
            ]);
        }
    }

    public function actionDelete()
    {
        $query = Yii::$app->request->queryParams;
        $id = $query['id'];
        $data = VideoShoot::findOne($id);
        $data->delete();

        Yii::$app->cache->delete('index');
        return $this->redirect(['index']);
    }
}