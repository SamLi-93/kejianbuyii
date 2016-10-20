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
        $course_info = new VideoMaking();
        $person = new SmsAdmin();
        $teacher = new Teacher();
        $this->pro_projectname = $pro_info->getProjectName();
        $this->pro_school = $pro_info->getSchoolName();
        $this->course_list = $course_info->getCourseList();
        $this->teacher_list = $teacher->getTeacherList();
        $this->person_list = $person->getPersonList();

    }

    public function actionTest()
    {
//        var_dump('test');exit;
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
            'status' => '一级审核中111',
            'seat' => intval($params['VideoShoot']['seat']),
            'uploadname' => $params['VideoShoot']['uploadname'],
            'recordname' => $recordname,
            'capture_time' => 00,
            'time1' => (string)strtotime(date('Y-m-d H:0:0')),
            'time' => $params['VideoShoot']['time'],
            'cid' => intval($params['VideoShoot']['seat']),
        ]);

//        var_dump($model);exit;

        var_dump($model->save());

    }

    public function actionIndex()
    {
        $searchModel = new VideoShoot();
        $query = Yii::$app->request->queryParams;
        $sql_parms = 'where a.cid = b.id';
        if (!empty($query['VideoShoot'])) {
            $query_parms = array_filter($query['VideoShoot']);
            $sql_parms = 'where a.cid = b.id and b.pid = c.id ';
        }

//        var_dump($query_parms);exit;

        if (isset($query_parms['projectname'])) {
            $sql_parms .= " and b.pid = '" . $query_parms['projectname'] . "'";
        }

        if (isset($query_parms['courcename'])) {
            $sql_parms .= " and a.courcename = '" . $query_parms['courcename'] . "'";
        }

        if (isset($query_parms['recordname'])) {
            $sql_parms .= " and a.recordname like  '" . '%' . $query_parms['recordname'] . '%' . "'";
        }

        if (isset($query_parms['uploadname'])) {
            $sql_parms .= " and a.uploadname like '" . '%' . $query_parms['uploadname'] . '%' . "'";
//            $sql_parms .= " and a.uploadname = '" . $query_parms['uploadname'] . "'";
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

                $sql_parms .= " and a.time like '" . $time1 . '%' . "'" . " or a.time like '" . $time2 . '%' . "'";
            } else {
                $sql_parms .= " and a.time like '" . $query_parms['time'] . '%' . "'";
            }
        }

//        var_dump($sql_parms);exit;

        $sql = "SELECT a.id, a.recordname, a.time, a.time1, a.capture_time, a.uploadname, a.seat, a.teacher, a.status, 
c.projectname,c.school,b.courcename,b.pid, a.cid  FROM `video_shoot` as a, `video_making` as b, `project` as c " . $sql_parms;

        $command = Yii::$app->db->createCommand('SELECT COUNT(a.id) as num,a.id, a.recordname, a.time, a.time1, a.capture_time, a.uploadname, a.seat, a.teacher, a.status, 
c.projectname,c.school,b.courcename,b.pid, a.cid  FROM `video_shoot` as a, `video_making` as b, `project` as c  ' . $sql_parms);

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
//        var_dump(Yii::$app->request->post());exit;
        $model = new VideoShoot();
        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
//            var_dump($params['VideoShoot']);
            $recordname = implode('、', $params['VideoShoot']['recordname']);
//            var_dump($recordname);exit;
            $sql = "select id from video_making where pid =:pid and school =:school and courcename=:courcename ";
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(':pid', $params['VideoShoot']['projectname']);
            $command->bindParam(':school', $params['VideoShoot']['school']);
            $command->bindParam(':courcename', $params['VideoShoot']['courcename']);
            $cid = $command->queryAll();
//            var_dump($cid[0]['id']);exit;

            $model->setAttributes([
                'projectname' => $params['VideoShoot']['projectname'],
                'school' => $params['VideoShoot']['school'],
                'courcename' => $params['VideoShoot']['courcename'],
                'teacher' => $params['VideoShoot']['teacher'],
                'status' => '一级审核中',
                'seat' => intval($params['VideoShoot']['seat']),
                'uploadname' => $params['VideoShoot']['uploadname'],
                'capture_time' => intval($params['VideoShoot']['capture_time']),
                'time1' => (string)strtotime(date('Y-m-d H:0:0')),
                'time' => $params['VideoShoot']['time'],
                'recordname' => $recordname,
                'cid' => $cid[0]['id'],
            ]);
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
        $model = VideoShoot::findOne($id);
        $cid = $model['cid'];  //拿到cid
        //获取视频拍摄表中的pid
        $video_pid = VideoMaking::findBySql("select pid from video_making where id = " .$cid)->all();
        $pid = $video_pid[0]['pid'];
        //得到project表中的学校
        $project = Project::findBySql("select school from project where id = " . $pid)->all();
        $model['school'] = $project[0]['school'];
        //得到视频表中的coucename
        $video_courcename = VideoMaking::findBySql("select courcename from video_making where id =" .$cid )->all();
        $model['courcename'] = $video_courcename[0]['courcename'];

        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $sql = "select id from video_making where pid =:pid and school =:school and courcename=:courcename ";
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(':pid', $params['VideoShoot']['projectname']);
            $command->bindParam(':school', $params['VideoShoot']['school']);
            $command->bindParam(':courcename', $params['VideoShoot']['courcename']);
            $cid = $command->queryAll();
//            $params = Yii::$app->request->post();
            $recordname = implode('、', $params['VideoShoot']['recordname']);
            $model->setAttributes([
                'projectname' => $params['VideoShoot']['projectname'],
                'school' => $params['VideoShoot']['school'],
                'courcename' => $params['VideoShoot']['courcename'],
                'teacher' => $params['VideoShoot']['teacher'],
                'status' => '一级审核中',
                'seat' => intval($params['VideoShoot']['seat']),
                'uploadname' => $params['VideoShoot']['uploadname'],
                'capture_time' => intval($params['VideoShoot']['capture_time']),
                'time1' => (string)strtotime(date('Y-m-d H:0:0')),
                'time' => $params['VideoShoot']['time'],
                'recordname' => $recordname,
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
        $data = VideoShoot::findOne($id);
        $data->delete();

        Yii::$app->cache->delete('index');
        return $this->redirect(['index']);
    }
}