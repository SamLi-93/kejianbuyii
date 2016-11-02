<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/29
 * Time: 9:22
 */

namespace backend\controllers;


use app\models\Tedeng;
use yii\data\SqlDataProvider;
use yii\web\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {
        echo 'tet';


    }
    public  function actionExport()
    {
        $sql_parms = 'where a.cid = b.id and b.pid = c.id';
        $sql = "SELECT a.id, a.recordname, a.time, a.time1, a.capture_time, a.uploadname, a.seat, a.teacher, a.status, a.remark, 
c.projectname,c.school,b.courcename,b.pid, a.cid  FROM `video_shoot` as a, `video_making` as b, `project` as c " . $sql_parms . " order by a.id desc ";

        $command = \Yii::$app->db->createCommand('SELECT COUNT(a.id) as num,a.id, a.recordname, a.time, a.time1, a.capture_time, a.uploadname, a.seat, a.teacher, a.status, 
c.projectname,c.school,b.courcename,b.pid, a.cid  FROM `video_shoot` as a, `video_making` as b, `project` as c  ' . $sql_parms);
        $count = $command->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            'pagination' => false,
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);
        $models = $dataProvider->getModels();


        $objectPHPExcel = new \PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
        $n = 0;
        foreach ($models as $product) {

                //报表头的输出
                $objectPHPExcel->getActiveSheet()->mergeCells('B1:G1');
                $objectPHPExcel->getActiveSheet()->setCellValue('B1', '视频拍摄');

                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '产品信息表');
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '产品信息表');
                $objectPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->getFont()->setSize(24);
                $objectPHPExcel->setActiveSheetIndex(0)->getStyle('B1')
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '日期：' . date("Y年m月j日"));
                $objectPHPExcel->setActiveSheetIndex(0)->getStyle('G2')
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                //表格头的输出
                $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'id');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(6.5);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', '项目名称');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', '学校');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(32);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', '课程名');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', '备注');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', 'test');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

                //设置居中
                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                //设置边框
                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
                    ->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
                    ->getBorders()->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
                    ->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
                    ->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
                    ->getBorders()->getVertical()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

                //设置颜色
                $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')->getFill()
                    ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF66CCCC');

            //明细的输出
            $objectPHPExcel->getActiveSheet()->setCellValue('B' . ($n + 4), $product['id']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C' . ($n + 4), $product['projectname']);
            $objectPHPExcel->getActiveSheet()->setCellValue('D' . ($n + 4), $product['school']);
            $objectPHPExcel->getActiveSheet()->setCellValue('E' . ($n + 4), $product['courcename']);
            $objectPHPExcel->getActiveSheet()->setCellValue('F' . ($n + 4), $product['status']);
            $objectPHPExcel->getActiveSheet()->setCellValue('G' . ($n + 4), $product['pid']);
            //设置边框
            $currentRowNum = $n + 4;
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':G' . $currentRowNum)
                ->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':G' . $currentRowNum)
                ->getBorders()->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':G' . $currentRowNum)
                ->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':G' . $currentRowNum)
                ->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':G' . $currentRowNum)
                ->getBorders()->getVertical()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $n = $n + 1;
        }

        //设置分页显示
        //$objectPHPExcel->getActiveSheet()->setBreak( 'I55' , PHPExcel_Worksheet::BREAK_ROW );
        //$objectPHPExcel->getActiveSheet()->setBreak( 'I10' , PHPExcel_Worksheet::BREAK_COLUMN );
//        $objectPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
//        $objectPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);


        ob_end_clean();
        ob_start();

        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="' . '测试数据-' . date("Y年m月j日") . '.xls"');
        $objWriter = \PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }


}