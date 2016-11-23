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
            'header' => '项目名称',
            'attribute' => 'projectname',
            'value' => function ($model) {
                return $model['projectname'];
            }
        ],

        [
            'header' => '学校',
            'attribute' => 'school',
            'value' => function ($model) {
                return $model['school'];
            }
        ],

        [
            'header' => '课程名称',
            'attribute' => 'coursename',
            'value' => function ($model) {
                return $model['coursename'];
            }
        ],

        [
            'header' => '视频标题',
            'attribute' => 'title',
            'value' => function ($model) {
                if ($model['title'] == null) {
                    return '';
                }
                return $model['title'];
            }
        ],

        [
            'header' => '讲师',
            'attribute' => 'teacher',
            'value' => function ($model) {
                if ($model['teacher'] == null) {
                    return '';
                }
                return $model['teacher'];
            }
        ],

        [
            'header' => '时长',
            'attribute' => 'time',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['time'] == null) {
                    return '';
                }
                $h = floor($model['time'] / 3600);
                $m = floor(($model['time'] - $h * 3600) / 60);
                $s = ($model['time'] - $h * 3600) % 60;
                return $h."时".$m."分".$s."秒";
            }
        ],

        [
            'header' => '制作人',
            'attribute' => 'makingname',
            'value' => function ($model) {
                if ($model['makingname'] == null) {
                    return '';
                }
                return $model['makingname'];
            }
        ],

        [
            'header' => '开始日期',
            'attribute' => 'date',
            'value' => function ($model) {
                if ($model['date'] == null) {
                    return '';
                }
                return date('Y-m-d', $model['date']);
            }
        ],

        [
            'header' => '制作天数',
            'attribute' => 'totalday',
            'value' => function ($model) {
                if ($model['totalday'] == null) {
                    return '';
                }
                return $model['totalday'];
            }
        ],

        [
            'header' => '备注',
            'attribute' => 'remark',
            'value' => function ($model) {
                if ($model['remark'] == '') {
                    return '';
                }
                return $model['remark'];
            }
        ],
    ],
]);

?>

