<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:48
 */

namespace backend\controllers;

use app\models\SmsAdmin;
use app\models\Teacher;
use app\models\VideoMaking;
use Yii;
use app\models\Project;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use app\models\ProjectSearch;
use yii\web\Controller;

class ProjectcountController extends Controller
{
    private $pro_projectname = [];
    private $pro_school = [];
    private $pro_over = [];
    private $course_list = [];
    private $person_list = [];
    private $teacher_list = [];

    public function beforeAction($action)
    {
        if (empty(Yii::$app->user->identity)) {
            return $this->redirect(['/default/login']);
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function init()
    {
        parent::init();
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
        $model = new Project();
        $query = Yii::$app->request->queryParams;
        $sql_parms = ' where a.cid = b.id and b.pid = c.id ';
        if (!empty($query['ProjectSearch'])) {
            $query_parms = array_filter($query['ProjectSearch']);
            $sql_parms = ' where a.cid = b.id and b.pid = c.id ';
        }

        if (isset($query_parms['projectname'])) {
            $sql_parms .= " and id = '" . $query_parms['projectname'] . "'";
        }

        if (isset($query_parms['school'])) {
            $sql_parms .= " and school = '" . $query_parms['school'] . "'";
        }

        $sql = "SELECT a.id, sum(a.capture_time) as record_time, c.projectname,c.school FROM `video_shoot` as a, `video_making` as b, `project` as c "
            . $sql_parms . " GROUP BY b.pid ORDER BY `record_time` DESC ";

        $command = Yii::$app->db->createCommand("select count(*) from (select  a.id, sum(a.capture_time) as record_time, c.projectname,c.school
 FROM `video_shoot` as a, `video_making` as b, `project` as c " . $sql_parms . " GROUP BY b.pid) as test " );
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

//        var_dump($dataProvider);exit;

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'pro_projectname' => $this->pro_projectname,
            'pro_school' => $this->pro_school,
            'pro_teacher' => $this->teacher_list,
            'pro_over' => $this->pro_over,
            'query' => $query,
        ]);
    }

    public function actionCoursetotal()
    {
        $model = new Project();
        $query = Yii::$app->request->queryParams;
        $sql_parms = ' where a.cid = b.id and b.pid = c.id ';
        if (!empty($query['ProjectSearch'])) {
            $query_parms = array_filter($query['ProjectSearch']);
            $sql_parms = ' where a.cid = b.id and b.pid = c.id ';
        }

        if (isset($query_parms['projectname'])) {
            $sql_parms .= " and id = '" . $query_parms['projectname'] . "'";
        }

        if (isset($query_parms['school'])) {
            $sql_parms .= " and school = '" . $query_parms['school'] . "'";
        }

        $sql = "SELECT sum(a.time) as video_total,COUNT(*) as total_num,a.id, c.projectname,c.school FROM `courseware` as a, `video_making` as b, `project` as c "
            . $sql_parms . " GROUP BY b.pid";

        $command = Yii::$app->db->createCommand("select count(*) from (select  a.id, c.projectname,c.school
 FROM `courseware` as a, `video_making` as b, `project` as c " . $sql_parms . " GROUP BY b.pid) as test " );
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

//        var_dump($dataProvider);exit;

        return $this->render('coursetotal', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'pro_projectname' => $this->pro_projectname,
            'pro_school' => $this->pro_school,
            'pro_teacher' => $this->teacher_list,
            'pro_over' => $this->pro_over,
            'query' => $query,
        ]);
    }

    public function actionVideototal()
    {
        $model = new Project();
        $query = Yii::$app->request->queryParams;
        $sql_parms = ' where a.cid = b.id and b.pid = c.id ';
        if (!empty($query['ProjectSearch'])) {
            $query_parms = array_filter($query['ProjectSearch']);
            $sql_parms = ' where a.cid = b.id and b.pid = c.id ';
        }

        if (isset($query_parms['projectname'])) {
            $sql_parms .= " and id = '" . $query_parms['projectname'] . "'";
        }

        if (isset($query_parms['school'])) {
            $sql_parms .= " and school = '" . $query_parms['school'] . "'";
        }

        $sql = "SELECT sum(a.time) as total_num,a.id, c.projectname,c.school FROM `courseware` as a, `video_making` as b, `project` as c "
            . $sql_parms . " GROUP BY b.pid";

        $command = Yii::$app->db->createCommand("select count(*) from (select  a.id, c.projectname,c.school
 FROM `courseware` as a, `video_making` as b, `project` as c " . $sql_parms . " GROUP BY b.pid) as test " );
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

//        var_dump($dataProvider);exit;

        return $this->render('videototal', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'pro_projectname' => $this->pro_projectname,
            'pro_school' => $this->pro_school,
            'pro_teacher' => $this->teacher_list,
            'pro_over' => $this->pro_over,
            'query' => $query,
        ]);
    }

}