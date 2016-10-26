<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:50
 */

namespace backend\controllers;

use app\models\Pic;
use app\models\SmsAdmin;
use app\models\Teacher;
use app\models\VideoMaking;
use app\models\VideoShoot;
use Yii;
use app\models\Project;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\grid\GridView;
use yii\web\UploadedFile;

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
            $sql_parms = 'where a.pid = b.id ';
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
from video_making as a,project as b " . $sql_parms . " order by a.id desc ";

        $command = Yii::$app->db->createCommand('SELECT COUNT(a.id) as num,a.makingname,a.subtitle,a.free,a.teacher,a.status, b.projectname,b.school,a.courcename,a.pid 
 FROM video_making as a, project as b ' . $sql_parms);
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
        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
//            var_dump($params['VideoMaking']);exit;
            $status = 0;
            // 保存图片   ---------------------------------------------
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->imageFiles) {
                $status = 1;
            }
            // ------------------------------------------------------------------------------
            $makingname = implode('、', $params['VideoMaking']['makingname']);
            $model->setAttributes([
                'status' => $status,
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
        //获得项目名称和图片路径和id
        $id = Yii::$app->request->get('id');
        $model = VideoMaking::findOne($id);
        $pid = $model['pid'];
        $project = Project::findBySql("select school from project where id = " . $pid)->all();
        $pic_path = Pic::findBySql("select id, path from pic where cid = :cid", [':cid' => $id])->all();

        $model['imageFiles'] = $pic_path;
        $model['school'] = $project[0]['school'];
        $makingname_arr = explode('、', $model['makingname']);
        $model['makingname'] = $makingname_arr;

        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();

            if ($model['status'] == 2) {
                $status = 6;
            } elseif ($model['status'] == 5) {
                $status = 6;
            } elseif ($model['status'] == 3) {
                $status = 1;
            } elseif ($model['status'] == 0) {
                $status = 1;
            }
            // 保存图片   ---------------------------------------------
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->imageFiles) {
//                if ($model['status'] == 2) {
//                    $status = 6;
//                } elseif ($model['status'] == 5) {
//                    $status = 6;
//                } elseif ($model['status'] == 3) {
//                    $status = 1;
//                } elseif ($model['status'] == 0) {
//                    $status = 1;
//                }
//                $model->upload();
            }
            // ------------------------------------------------------------------------------
            $makingname = implode('、', $params['VideoMaking']['makingname']);
            $model->setAttributes([
                'status' => $status,
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

        //删除数据同时删除pic表中的数据 和文件
        $pic_date = Pic::findBySql("select path from pic where cid=:cid", [':cid' => $id])->all();
        foreach ($pic_date as $k => $v) {
            $is_delete = unlink(dirname(__DIR__) . '\\web\\' . $v['path']);
        }

        $conn = Yii::$app->db;
        $sql = "delete from pic where cid=:cid";
        $command = $conn->createCommand($sql, [':cid' => $id]);
        $command->execute();

        Yii::$app->cache->delete('index');
        return $this->redirect(['index']);
    }

    public function actionVerified()
    {
        $id_list = Yii::$app->request->post('ids');
        $db = Yii::$app->db;
        foreach ($id_list as $k => $v) {
            $res = $db->createCommand("update video_making set status = 2 where id=:id and status=1 ", [':id' => $v])->execute();
            $res1 = $db->createCommand("update video_making set status = 4 where id=:id and status=6 ", [':id' => $v])->execute();
        }
    }

    public function actionReject()
    {
        $id = Yii::$app->request->get('id');
        $model = VideoMaking::findOne($id);
        $status = $model['status'];
        if ($status == 1) {
            $model->status = 3;
        }
        if ($status == 6) {
            $model->status = 5;
        }
        if ($model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        }
    }

    public function actionPicdelete()
    {
        $id = Yii::$app->request->post('id');
        $data = Pic::findOne($id);
        $file_path = $data['path'];
        $data->delete();
//        var_dump(dirname(__DIR__) . '\\web\\');exit;
        $is_delete = unlink(dirname(__DIR__) . '\\web\\' . $file_path);
        echo $is_delete;
    }

    public function actionTest()
    {
        var_dump(Yii::$app->user->identity->name);
        exit;
    }
}