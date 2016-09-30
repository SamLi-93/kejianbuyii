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

<?php echo $this->render('_search', [
    'model' => $searchModel,
    'pro_projectname' => $pro_projectname,
    'pro_school' => $pro_school,
    'pro_teacher' => $pro_teacher,
    'pro_over' => $pro_over,
    ]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
//        'id',
//        'projectname',
//        'school',

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
            'header' => '是否结束',
            'attribute' => 'over',
            'format' => 'raw',
            'value' => function ($model) {
                    return Html::dropDownList('over', $model['over'], ['0'=>'否', '1'=>'是']);
                }
        ],

        [
            'header' => '费用结算',
            'attribute' => 'free',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::dropDownList('free', $model['free'], ['0'=>'否', '1'=>'是']);
            }
        ],

        [
            'header' => '项目联系人',
            'attribute' => 'teacher',
            'value' => function ($model) {
                if ($model['teacher'] == null ){
                    return '';
                }
                return $model['teacher'];
            }
        ],

        [
            'header' => '开始日期	',
            'attribute' => 'time',
            'value' => function ($model) {
                return date('Y-m-d', $model['time']);
            }
        ],

        [
            'header' => '结束时间',
            'attribute' => 'endtime',
            'value' => function ($model) {
                return date('Y-m-d', $model['endtime']);
            }
        ],

        [
            'header' => '上传路径',
            'attribute' => 'making_path',
            'value' => function ($model) {
                if ($model['making_path'] == null ){
                    return '';
                }
                return $model['making_path'];
            }
        ],

    ],

]);

?>




