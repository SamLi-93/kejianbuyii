<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '课程管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>课程管理</span>
</div>

<?php echo $this->render('_search', [
    'model' => $searchModel,
    'pro_projectname' => $pro_projectname,
    'pro_school' => $pro_school,
    'course_list' => $course_list,
    'person_list' => $person_list,
    ]); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,

    'summary' => '',
//    'id' => "waitforcheck",
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
            'header' => '课程名称',
            'attribute' => 'courcename',
            'value' => function ($model) {
                if ($model['courcename'] == null ){
                    return '';
                }
                return $model['courcename'];
            }
        ],

        [
            'header' => '有无字幕',
            'attribute' => 'subtitle',
            'value' => function ($model) {
                if ($model['subtitle'] == 0 ){
                    return '无';
                } elseif ($model['subtitle'] == 1) {
                    return '有';
                }
                return $model['subtitle'];
            }
        ],

        [
            'header' => '费用结算',
            'attribute' => 'free',
            'value' => function ($model) {
                if ($model['free'] == 0 ){
                    return '否';
                } elseif ($model['free'] == 1) {
                    return '是';
                } elseif ($model['free'] == '') {
                    return '';
                }
                return $model['subtitle'];
            }
        ],

        [
            'header' => '进度',
            'attribute' => 'state',
            'value' => function ($model) {
                if ($model['state'] == 0 ){
                    return '制作中';
                } elseif ($model['state'] == 1) {
                    return '修改中';
                } elseif ($model['state'] == '2') {
                    return '已完成';
                }
                return $model['subtitle'];
            }
        ],

        [
            'header' => '上传人',
            'attribute' => 'state',
            'value' => function ($model) {
                if ($model['makingname'] == '' ){
                    return '';
                }
                return $model['makingname'];
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
                    $url = Url::to(['videomaking/edit','id'=>$model['id']]);
                    return Html::a('修改', $url, $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    $url = Url::to(['videomaking/delete','id'=>$model['id']]);
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



