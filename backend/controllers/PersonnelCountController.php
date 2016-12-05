<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:46
 */

namespace backend\controllers;


use yii\data\ArrayDataProvider;
use yii\web\Controller;
use app\models\SmsAdmin;
use app\models\Teacher;
use app\models\VideoMaking;
use Yii;
use app\models\Project;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use app\models\ProjectSearch;

class PersonnelcountController extends Controller
{

    public function beforeAction($action)
    {
        if (empty(Yii::$app->user->identity)) {
            return $this->redirect(['/default/login']);
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }


    public function actionIndex()
    {
        $is_neibu = '';
        $is_neibu_total = '';
        $firstday = strtotime(date('Y-m-01  ', time()));
        $lastday = strtotime(date('Y-m-31  ', time()));
        $db = Yii::$app->db;
        $model = new Project();
        $query = Yii::$app->request->queryParams;
        $sql_parms = ' and date between ' . $firstday . ' and ' . $lastday;
        $from_date = '';
        $to_date = '';
        if (!empty($query['Project'])) {
            if (!empty($query['Project']['from_date'])) {
                if (!empty($query['Project']['to_date'])) {
                    $to_date = strtotime($query['Project']['to_date']);
                } else {
                    $to_date = $lastday;
                }
                $from_date = strtotime($query['Project']['from_date']);
                $firstday = $from_date;
                $lastday = $to_date;
                $sql_parms = ' and a.date between ' . $from_date . ' and ' . $to_date;
            }
            if (!empty($query['Project']['is_neibu'])) {
                if ($query['Project']['is_neibu'] == 2) {
                    $query['Project']['is_neibu'] = 0;
                }
                $is_neibu .= " and b.is_neibu = '" . $query['Project']['is_neibu'] . "'";
                $is_neibu_total = " and is_neibu = '" . $query['Project']['is_neibu'] . "'";
            }
        }
        //
        $total_num_total = $db->createCommand("SELECT count(b.pid) as total_time  FROM courseware as b,project as a 
where date between " . $firstday . " and " . $lastday . " and a.id = b.pid " .$is_neibu_total)->queryAll();
        //人员全部姓名
        $person_list = $db->createCommand("select name from sms_admin ")->queryAll();
        //课件中存在的项目名
        $project_list = $db->createCommand("SELECT a.pid,b.projectname,b.is_neibu FROM courseware as a,project as b where a.pid =b.id and date between " . $firstday . " and " . $lastday .$is_neibu . " group by a.pid ")->queryAll();

        $test = $db->createCommand("select a.makingname, a.pid, count(makingname) as count_num, b.projectname  from courseware as a, project as b where date between " . $firstday . " and " . $lastday . " and a.pid = b.id group by a.pid,a.makingname")->queryAll();
        $sam = [];
        foreach ($test as $key => $value) {
            if (isset($sam[$value['makingname']])) {
                $sam[$value['makingname']][$value['pid']] = $value['count_num'];
            } else {
                $sam[$value['makingname']] = [$value['pid'] => $value['count_num']];
            }
        }

        $person_count_total = $db->createCommand("select a.pid, count(makingname) as count_num, b.projectname from courseware as a, project as b where date between " . $firstday . " and " . $lastday . " and a.pid = b.id group by a.pid")->queryAll();
        $total_count = 0;
        foreach ($person_count_total as $k => $v) {
            $total_count += $v['count_num'];
        }
//        echo  $total_count;exit;
//        print_r($person_count_total);exit;

//        print_r($sam);exit;
//        print_r($test);exit;
        return $this->render('index', [
            'person_count_total' => $person_count_total,
            'total_count' => $total_count,
            'model' => $model,
            'data' => $sam,
//            'dataProvider' => $dataProvider,
            'project_list' => $project_list,
            'person_list' => $person_list,
            'query' => $query,
        ]);
    }
}