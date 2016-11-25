<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '人员统计';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>人员统计</span>
</div>

<?php echo $this->render('_search', [
    'model' => $model,
    'query' => $query
]); ?>
<!---->
<? //= GridView::widget([
//    'dataProvider' => $dataProvider,
//    'summary' => '',
//    'columns' => [
//        [
//            'header' => '姓名',
//            'headerOptions' => ['width' => '100'],
//            'attribute' => 'name',
//            'value' => function ($model) {
//                return $model['name'];
//            }
//        ],
//
//        [
//            'label' => $test,
//        ],
//
//    ],
//]);
//
//?>

<? //print_r($data);exit;?>

<table class="list_table" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <th>姓名</th>
        <?
        foreach ($project_list as $k => $v) {
            echo "<th>" . $v['projectname'] . "</th>";
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?
    foreach ($person_list as $key => $value) {
        echo "<tr>";
        echo "<td>" . $value['name'] . "</td>";
        foreach ($data as $k => $v) {
            foreach ($project_list as $item => $j) {
                if ($v['makingname'] == $value['name'] && $v['pid'] == $j['pid']) {
                    echo "<td>" . $v['count_num'] . "</td>";
                } elseif ($v['makingname'] == $value['name'] && $v['pid'] != $j['pid']) {
//                    echo "<td>" . 0 . "</td>";
                } else {

                }
            }


        }

        echo "</tr>";
    }

    ?>

    </tbody>
</table>
