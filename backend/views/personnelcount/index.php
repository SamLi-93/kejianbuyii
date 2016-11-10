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

<?php //echo $this->render('_search', [
//    'model' => $searchModel,
//    'pro_projectname' => $pro_projectname,
//    'pro_school' => $pro_school,
//    'pro_teacher' => $pro_teacher,
//    'pro_over' => $pro_over,
//    'query' => $query
//    ]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],

        [
            'header' => '姓名',
            'attribute' => 'name',
            'value' => function ($model) {
                return $model['name'];
            }
        ],



    ],
]);

?>

