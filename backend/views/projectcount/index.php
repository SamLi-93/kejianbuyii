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
    'teacher_list' => $teacher_list,
    'pro_school' => $pro_school,
    ]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
//    'id' => "waitforcheck",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
//        'id',
//        'school',

        [
            'header' => '院校',
            'attribute' => 'college',
            'value' => function ($model) {
                if ($model['college'] == null ){
                    return '';
                }
                return $model['college'];
            }
        ],

        [
            'header' => '讲师姓名',
            'attribute' => 'teacher',
            'value' => function ($model) {
                if ($model['teacher'] == null ){
                    return '';
                }
                return $model['teacher'];
            }
        ],

        [
            'header' => '性别',
            'attribute' => 'sex',
            'value' => function ($model) {
                if ($model['sex'] == null ){
                    return '';
                }
                return $model['sex'];
            }
        ],

        [
            'header' => '联系电话',
            'attribute' => 'phone',
            'value' => function ($model) {
                if ($model['phone'] == null ){
                    return '';
                }
                return $model['phone'];
            }
        ],

        [
            'header' => 'qq或邮箱',
            'attribute' => 'qq',
            'value' => function ($model) {
                if ($model['qq'] == null ){
                    return '';
                }
                return $model['qq'];
            }
        ],

        [
            'header' => '备注',
            'attribute' => 'remarks',
            'value' => function ($model) {
                if ($model['remarks'] == null ){
                    return '';
                }
                return $model['remarks'];
            }
        ],


        ['class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    $options = [
                        'title' => '修改',
                        'class' =>'btn btn-success btn-sm',
                        'id' => 'edit-btn',
                    ];
                    $url = Url::to(['teacher/edit','id'=>$model['id']]);
                    return Html::a('修改', $url, $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    $url = Url::to(['teacher/delete','id'=>$model['id']]);
                    return Html::a('删除', $url, ['onclick'=> 'check()', 'class' => 'btn btn-success btn-sm', 'id' => 'delete-btn' ]);

                },
            ],
        ],
    ],
]);

?>
<script>
    function check() {
        if(confirm('您确定要删除吗？')){
            return true;
        }else{
            return false;
        }
    }
</script>



