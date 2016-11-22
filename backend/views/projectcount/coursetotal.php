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


<?php echo $this->render('_search', [
    'model' => $model,
    'pro_projectname' => $pro_projectname,
    'pro_school' => $pro_school,
    'pro_teacher' => $pro_teacher,
    'pro_over' => $pro_over,
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
            'header' => '课时总数',
            'attribute' => 'total_num',
            'value' => function ($model) {
                return $model['total_num'];
            }
        ],

        [
            'header' => '视频总时长',
            'attribute' => 'video_total',
            'value' => function ($model) {
                $h = intval($model['video_total'] / 3600);
                $min = intval($model['video_total'] % 3600 / 60);
                $sec = $model['video_total'] % 60;
                return $h.':' .$min. ':'.$sec;
            }
        ],
    ],
]);

?>

