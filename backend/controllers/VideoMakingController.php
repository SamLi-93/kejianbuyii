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
        $pro_info = new Project();
        $person = new SmsAdmin();
        $teacher = new Teacher();
        $this->pro_projectname = $search_info->getProjectName();
        $this->pro_school = $pro_info->getSchoolName();
        $this->course_list = $search_info->getCourseList();
        $this->teacher_list = $teacher->getTeacherList();
        $this->person_list = $person->getPersonList();

    }

    public function actionIndex()
    {
        $searchModel = new VideoMaking();
        $query = Yii::$app->request->queryParams;
        $sql_parms = '';
        if (!empty($query['VideoMaking'])) {
            $query_parms = array_filter($query['VideoMaking']);
            $sql_parms = 'where true';
        }

//        var_dump($query_parms);exit;

        if (isset($query_parms['projectname'])) {
            $sql_parms .= " and video_making.projectname = '" . $query_parms['projectname'] . "'";
        }

        if (isset($query_parms['school'])) {
            $sql_parms .= " and video_making.school = '" . $query_parms['school'] . "'";
        }

        if (isset($query_parms['courcename'])) {
            $sql_parms .= " and video_making.courcename = '" . $query_parms['courcename'] . "'";
        }

        if (isset($query_parms['makingname'])) {
            $sql_parms .= " and video_making.makingname like '" . '%' . $query_parms['makingname'] . '%' . "'";
        }

        if (isset($query_parms['free'])) {
            if ($query_parms['free']==2) {
                $query_parms['free'] = 0;
            }
            $sql_parms .= " and video_making.free = '" . $query_parms['free'] . "'";
        }

        if (isset($query_parms['subtitle'])) {
            if ($query_parms['subtitle']==2) {
                $query_parms['subtitle'] = 0;
            }
            $sql_parms .= " and video_making.subtitle = '" . $query_parms['subtitle'] . "'";
        }

        $sql = "select  video_making.*, courseware.state from video_making 
inner join courseware on video_making.courcename = courseware.coursename " . $sql_parms;

//        var_dump($query_parms['subtitle']);
//        var_dump($sql);exit;
        $command = Yii::$app->db->createCommand('SELECT COUNT(*) FROM video_making ' . $sql_parms);
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
            'pro_school' => $this->pro_school,
            'course_list' => $this->course_list,
            'person_list' => $this->person_list,
        ]);
    }



    public function actionCreate()
    {
        $model = new VideoMaking();

//        var_dump(Yii::$app->request->post());exit;
//        var_dump($model->load(Yii::$app->request->post()));exit;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
        $model = new VideoMaking();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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

    public function actionDelete()
    {

    }
}