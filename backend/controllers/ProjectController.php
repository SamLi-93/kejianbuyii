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
use app\models\Teacher;
use app\models\VideoMaking;
use app\models\Project;
use app\models\VideoShoot;
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
    private $course_list = [];
    private $person_list = [];
    private $teacher_list = [];


    public function init()
    {
        parent::init();
//        $pro_info = new Project();
//        $this->pro_projectname = $pro_info->getProjectName();
//        $this->pro_school = $pro_info->getSchoolName();
//        $this->pro_teacher = $pro_info->getTeacherName();
//        $this->pro_over = $pro_info->getOverList();

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

    public function actionTest()
    {
//        $id_arr = [];
//        $idst = Project::findBySql('select id from video_making')->all();
//        foreach ($idst as $k => $v) {
//            array_push($id_arr, $v['id']);
//        }
//        print_r($id_arr);exit;
//        print_r($idst);exit;
//        $project_list = Project::findBySql('select id, projectname,school,pid from project')->all();
        $video = VideoMaking::findBySql('SELECT projectname,school ,courcename,pid,cid FROM `video_making`')->all();
//        foreach ($video as $k => $v) {
//            print_r($video[$k]['courcename']);
//            print_r($v['courcename']);exit;
//            if ($video[$k]['courcename'] == $v['courcename']) {
//                echo '1';
//            }
//        }

//        for ($i=0; $i<563;$i++) {
//            for ($j=1;$j<563;$j++) {
//                if($video[$i]['courcename'] == $video[$j]['courcename']) {
//                    print_r($video[$i]['courcename']);
//                    print_r("\n");
//
//                }
//            }
//        }

//        for ($i= 0; $i<564; $i++ ) {
//            for ($j=0; $j<73; $j++) {
//                $video = VideoMaking::find()->where(['id'=>$id_arr[$i]])->one();
//                if ($video['projectname'] == $project_list[$j]['projectname'] && $video['school'] == $project_list[$j]['school'])
//                    $video->pid = $project_list[$j]['pid'];
//                    $video->save();
//            }
//        }
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
            $sql_parms .= " and id = '" . $query_parms['projectname'] . "'";
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
            'pro_teacher' => $this->teacher_list,
            'pro_over' => $this->pro_over,
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new Project();
//        $list = SmsAdmin::findBySql("SELECT name FROM sms_admin")->all();
//        foreach ($list as $k => $v) {
//            $key = $v['name'];
//            $uploadname_list[$key] = $v['name'];
//        }
//        print_r($uploadname_list);exit;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'pro_projectname' => $this->pro_projectname,
                'pro_school' => $this->pro_school,
                'pro_teacher' => $this->teacher_list,
                'pro_over' => $this->pro_over,
                'uploadname_list' => $this->person_list,
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