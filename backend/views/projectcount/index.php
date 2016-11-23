<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>项目管理</span>
</div>

<?// var_dump($model);exit; ?>

<?php echo $this->render('_search', [
    'model' => $model,
    'query' => $query
]); ?>
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
            'header' => '录制时长',
            'attribute' => 'record_time',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model['record_time'], ['videosearch', [
                    'id' => $model['id'],
                    'from_date' => $model['from_date'],
                    'to_date' =>   $model['to_date'],
                    ]]);
            }
        ],

        [
            'header' => '课时总数',
            'attribute' => 'total_num',
            'format' => 'raw',
            'value' => function ($model) {
//                return $model['total_num'];
                return Html::a($model['total_num'], ['coursesearch', [
                    'id' => $model['id'],
                    'from_date' => $model['from_date'],
                    'to_date' =>   $model['to_date'],
                ]]);
            }
        ],

        [
            'header' => '视频总时长',
            'attribute' => 'video_time',
            'format' => 'raw',
            'value' => function ($model) {
                $h = intval($model['video_time'] / 3600);
                $min = intval($model['video_time'] % 3600 / 60);
                $sec = $model['video_time'] % 60;
//                return $h . ':' . $min . ':' . $sec;
                return Html::a($h . ':' . $min . ':' . $sec, ['coursesearch', [
                    'id' => $model['id'],
                    'from_date' => $model['from_date'],
                    'to_date' =>   $model['to_date'],
                ]]);
            }
        ],


    ],
]);

?>

