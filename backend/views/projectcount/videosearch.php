<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目课时统计';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>项目管理</span>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],

        [
            'header' => '学校',
            'attribute' => 'school',
            'value' => function ($model) {
                return $model['school'];
            }
        ],

        [
            'header' => '课程名称',
            'attribute' => 'courcename',
            'format' => 'raw',
            'value' => function ($model) {
                return $model['courcename'];
            }
        ],

        [
            'header' => '录制人员',
            'attribute' => 'recordname',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['recordname'] == null ){
                    return '';
                }
                return $model['recordname'];
            }
        ],

        [
            'header' => '主讲人',
            'attribute' => 'teacher',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['teacher'] == null ){
                    return '';
                }
                return $model['teacher'];
            }
        ],

        [
            'header' => '拍摄时间',
            'attribute' => 'time',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['time'] == null ){
                    return '';
                }
                return $model['time'];
            }
        ],

        [
            'header' => '拍摄时长(时)',
            'attribute' => 'capture_time',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['capture_time'] == null ){
                    return '';
                }
                return $model['capture_time'];
            }
        ],

        [
            'header' => '机位',
            'attribute' => 'seat',
            'value' => function ($model) {
                if ($model['seat'] == null ){
                    return '';
                }
                return $model['seat'];
            }
        ],

        [
            'header' => '上传人',
            'attribute' => 'uploadname',
            'value' => function ($model) {
                if ($model['uploadname'] == null ){
                    return '';
                }
                return $model['uploadname'];
            }
        ],

        [
            'header' => '备注',
            'attribute' => 'remark',
            'value' => function ($model) {
                if ($model['remark'] == null ){
                    return '';
                }
                return $model['remark'];
            }
        ],

        [
            'header' => '审核',
            'attribute' => 'status',
            'value' => function ($model) {
                if ($model['status'] == 0) {
                    return '未审核';
                } elseif ($model['status'] == 1) {
                    return '一级审核中';
                } elseif ($model['status'] == 2) {
                    return '一级通过';
                } elseif ($model['status'] == 3) {
                    return '一级驳回';
                } elseif ($model['status'] == 4) {
                    return '二级通过';
                } elseif ($model['status'] == 5) {
                    return '二级驳回';
                } elseif ($model['status'] == 6) {
                    return '二级审核中';
                }
                return '';
            }
        ],
    ],
]);

?>

