<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:43
 */

namespace backend\controllers;


use app\models\Courseware;
use app\models\SmsAdmin;
use app\models\Teacher;
use app\models\VideoMaking;
use app\models\VideoShoot;
use Yii;
use app\models\Project;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\grid\GridView;

class CoursewareController extends Controller
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
        $course_info = new VideoMaking();
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
        $searchModel = new Courseware();
        $query = Yii::$app->request->queryParams;
        $sql_parms = 'where a.cid = b.id and b.pid = c.id ';
        if (!empty($query['Courseware'])) {
            $query_parms = array_filter($query['Courseware']);
            $sql_parms = 'where a.cid = b.id and b.pid = c.id ';
        }
//        var_dump($query_parms);exit;

        if (isset($query_parms['projectname'])) {
            $sql_parms .= " and b.pid = '" . $query_parms['projectname'] . "'";
        }

        if (isset($query_parms['courcename'])) {
            $sql_parms .= " and a.courcename = '" . $query_parms['courcename'] . "'";
        }

        if (isset($query_parms['teacher'])) {
            $sql_parms .= " and a.teacher = '" . $query_parms['teacher'] . "'";
        }

        if (isset($query_parms['recordname'])) {
            $sql_parms .= " and a.recordname like  '" . '%' . $query_parms['recordname'] . '%' . "'";
        }

        if (isset($query_parms['uploadname'])) {
            $sql_parms .= " and a.uploadname like '" . '%' . $query_parms['uploadname'] . '%' . "'";
//            $sql_parms .= " and a.uploadname = '" . $query_parms['uploadname'] . "'";
        }

//        if (isset($query_parms['date'])) {
//            if (isset($query_parms['endtime'])) { //年份月份全有
//                $year = $query_parms['date'];
//                $month = $query_parms['endtime'];
//                $time1 = $query_parms['date'] . '/' . $query_parms['endtime'];
//                if ($month > 9) {
//                    $time2 = $year . '-' . $month;
//                } else {
//                    $time2 = $year . '-0' . $month;
//                }
//
//                $sql_parms .= " and a.date like '" . $time1 . '%' . "'" . " or a.date like '" . $time2 . '%' . "'";
//            } else {
//                $sql_parms .= " and a.date like '" . $query_parms['date'] . '%' . "'";
//            }
//        }

        if (isset($query_parms['date'])) {
            if (isset($query_parms['enddate'])) { //年份月份全有
                $year = $query_parms['date'];
                $month = $query_parms['enddate'];
                $min_year = $year . '-'.$month . '-01';
                $minyear = strtotime($min_year);
                $max_year = $year .'-'. $month . '-31';
                $maxyear = strtotime($max_year);
                $sql_parms .= " and a.date >= '" . $minyear . "' and a.date <= '" .$maxyear. "'" ;
            }
            else {
                $year = $query_parms['date'];
                $ages = $year . '-01-01';
                $minyear = strtotime($ages);
                $maxyear = $minyear+31449600;
                $sql_parms .= " and a.date >= '" . $minyear . "' and a.date <= '" .$maxyear. "'" ;
            }
        }

        $sql = "SELECT a.id, a.title, a.teacher, a.time, a.makingname, a.uploadname, a.date, a.enddate, a.totalday,a.remark, a.cid,
b.courcename,b.pid,c.projectname,c.school  FROM `courseware` as a , `video_making` as b, `project` as c " . $sql_parms;

        $command = Yii::$app->db->createCommand('SELECT count(a.id) as num, a.id, a.title, a.teacher, a.time, a.makingname, a.uploadname, 
a.date, a.enddate, a.totalday,a.remark, a.cid,b.courcename,b.pid,c.projectname,c.school 
FROM `courseware` as a , `video_making` as b, `project` as c ' . $sql_parms );
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
            'teacher_list' => $this->teacher_list,
        ]);
    }

    public function actionCreate()
    {
        $model = new Courseware();

        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
//            var_dump(($params['Courseware']['date']));exit;
//            var_dump($params['Courseware']);exit;
            $sql = "select id from video_making where pid =:pid and school =:school and courcename=:courcename ";
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(':pid', $params["Courseware"]["projectname"]);
            $command->bindParam(':school', $params['Courseware']['school']);
            $command->bindParam(':courcename', $params['Courseware']['courcename']);
            $cid = $command->queryAll();
//            var_dump($cid[0]['id']);exit;
            $time = $params['Courseware']['time0'] * 3600 + $params['Courseware']['time1'] *60 +$params['Courseware']['time2'];

            $model->setAttributes([
                'projectname' => $params['Courseware']['projectname'],
                'school' => $params['Courseware']['school'],
                'coursename' => $params['Courseware']['courcename'],
                'title' =>$params['Courseware']['title'],
                'teacher' => $params['Courseware']['teacher'],
                'time' => $time,
                'makingname' =>$params['Courseware']['makingname'],
                'uploadname' => $params['Courseware']['uploadname'],
                'date' => strtotime($params['Courseware']['date']),
                'enddate' => strtotime($params['Courseware']['enddate']),
//                'totalday' => $params['Courseware']['totalday'],
                'remark' => $params['Courseware']['remark'],
                'cid' => $cid[0]['id'],
            ]);
//            var_dump($model);exit;
        }

        if (!empty(Yii::$app->request->post())&&$model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
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
        $pro_id = $params['value'];
//        var_dump($pro_name);exit;

        if (!empty($pro_id)) {
            $school_sql = "select school from project where id = :id" ;
            $list1 = Project::findBySql($school_sql, array(":id"=>$pro_id))->all();
            $course_sql = "select courcename from video_making where pid = :pid" ;
            $list2 = VideoMaking::findBySql($course_sql, array(":pid"=>$pro_id))->all();
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
        $model = Courseware::findOne($id);
        $cid = $model['cid'];  //拿到cid
        //获取视频拍摄表中的pid
        $video_pid = VideoMaking::findBySql("select pid from video_making where id = " .$cid)->all();
        $pid = $video_pid[0]['pid'];
        //得到project表中的学校
        $project = Project::findBySql("select school from project where id = " . $pid)->all();
        $model['school'] = $project[0]['school'];
        //得到视频表中的coucename
        $video_courcename = VideoMaking::findBySql("select courcename from video_making where id =" .$cid )->all();
        $model['coursename'] = $video_courcename[0]['courcename'];
        $model['date'] = date('Y-m-d',$model['date']);
        $model['enddate'] = date('Y-m-d',$model['enddate']);
        $time_total = $model['time'];
        $h = floor($time_total/3600);
        $m = floor(($time_total-$h*3600)/60);
        $s = ($time_total-$h*3600)%60;
        $model['time0'] = $h;
        $model['time1'] = $m;
        $model['time2'] = $s;

        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $sql = "select id from video_making where pid =:pid and school =:school and courcename=:courcename ";
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(':pid', $params['Courseware']['projectname']);
            $command->bindParam(':school', $params['Courseware']['school']);
            $command->bindParam(':courcename', $params['Courseware']['coursename']);
            $cid = $command->queryAll();
//            $params = Yii::$app->request->post();
            $time = $params['Courseware']['time0'] * 3600 + $params['Courseware']['time1'] *60 +$params['Courseware']['time2'];
            $model->setAttributes([
                'projectname' => $params['Courseware']['projectname'],
                'school' => $params['Courseware']['school'],
                'coursename' => $params['Courseware']['coursename'],
                'title' =>$params['Courseware']['title'],
                'teacher' => $params['Courseware']['teacher'],
                'time' => $time,
                'makingname' =>$params['Courseware']['makingname'],
                'uploadname' => $params['Courseware']['uploadname'],
                'date' => strtotime($params['Courseware']['date']),
                'enddate' => strtotime($params['Courseware']['enddate']),
//                'totalday' => $params['Courseware']['totalday'],
                'remark' => $params['Courseware']['remark'],
                'cid' => $cid[0]['id'],
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
        $data = Courseware::findOne($id);
        $data->delete();

        Yii::$app->cache->delete('index');
        return $this->redirect(['index']);
    }
}