<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/29
 * Time: 9:22
 */

namespace backend\controllers;


use app\models\Project;
use app\models\Tedeng;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use PHPExcel_IOFactory;
use Yii;

class TestController extends Controller
{

    public function actionIndex()
    {
        $k = '1';
        $type = '.jpg';
        $path = 'upload_files\pic\\' . date("Y-m-d-H-i-s") . '_' . $k . $type;
//        echo ('..\backend'. '\\web\\' . $path);
//        echo dirname(__DIR__);
        echo dirname(__DIR__) . ('\\web\\' . $path);
    }

    public function actionExport()
    {
        echo phpinfo();
        exit;
    }

    public function actionInput()
    {
        $project = new Project();
        $conn = Yii::$app->db;
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load('./1.xls');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        $k = 0;
        for ($j = 2; $j <= $highestRow; $j++) {
            $a = $objPHPExcel->getActiveSheet()->getCell("B" . $j)->getValue();//获取A列的值
            $b = $objPHPExcel->getActiveSheet()->getCell("C" . $j)->getValue();//获取B列的值
            var_dump($a);exit;
//            $sql = "insert into project(projectname, school) VALUES($a, $b) ";
//            $command = $conn->createCommand($sql)->execute();


        }


    }


}