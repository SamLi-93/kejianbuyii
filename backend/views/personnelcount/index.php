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

<?// print_r($data);exit;?>

<table border="1" class="list_table" width="80%" cellpadding="0" cellspacing="0" <!--style="margin-top: 120px;margin-left: 240px"-->>
    <thead>
    <tr>
        <th>姓名</th>
        <?
        foreach ($project_list as $k => $v) {
            echo "<th >" . $v['projectname'] . "</th>";
        }
        ?>
        <th>个人总计</th>
    </tr>
    </thead>
    <tbody>
    <?

    foreach ($person_list as $key => $value) {
        echo "<tr><td>" . $value['name'] . "</td>";
        $test = 0;
        foreach ($project_list as $k => $v) {
            if ( isset($data[$value['name']])) {
                if ( isset($data[$value['name']][$v['pid']])  ) {
                    echo "<td>" . $data[$value['name']][$v['pid']] . "</td>";
                    $test += $data[$value['name']][$v['pid']];
                } else {
                    echo "<td>" . 0 . "</td>";
                }
            } else {
                echo "<td>" . 0 . "</td>";
            }
//            echo "<td>总计</td> <td></td>";
        }
        echo "<td>" . $test . "</td>";
//        echo "<td>总计</td>";
        echo '</tr>';
    }
    echo "<tr><td>总计</td>";
    foreach ($person_count_total as $k => $v) {
        echo "<td>" . $v['count_num'] . "</td>";
    }
    echo "<td>" . $total_count . "</td>";
    echo "</tr>";


    ?>

    </tbody>
</table>

<div style="height: 100px" ></div>
