<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '课件管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>课件管理</span>
</div>

<?php echo $this->render('_search', [
    'model' => $searchModel,
    'pro_projectname' => $pro_projectname,
    'course_list' => $course_list,
    'pro_school' => $pro_school,
    'person_list' => $person_list,
    'teacher_list' => $teacher_list,
    'query' => $query,
]); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'id' => "grid",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],

        [
            'class' => 'yii\grid\CheckboxColumn',
            'checkboxOptions' => function ($model, $key, $index, $column) {
                return ['value' => $model['id'], 'id' => $model['id']];
            },
        ],

        [
            'header' => '项目名称',
            'attribute' => 'projectname',
            'value' => function ($model) {
//                var_dump($model);exit;
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
                return $model['courcename'];
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

//        [
//            'header' => '结束日期',
//            'attribute' => 'enddate',
//            'value' => function ($model) {
//                if ($model['enddate'] == null) {
//                    return '';
//                }
//                return date('Y-m-d', $model['enddate']);
//            }
//        ],

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

        ['class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    $options = [
                        'title' => '修改',
                        'class' => 'btn btn-success btn-sm',
                        'id' => 'edit-btn',
                    ];
                    $url = Url::to(['courseware/edit', 'id' => $model['id']]);
                    return Html::a('修改', $url, ['onclick'=> ' return checkedit("' . $model['uploadname'] . '"' . ')', 'class' => 'btn btn-success btn-sm', 'id' => 'delete-btn' ]);

                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    $url = Url::to(['courseware/delete', 'id' => $model['id']]);
//                    return Html::a('删除', $url, ['onclick' => 'return check()','class' => 'btn btn-success btn-sm', 'id' => 'delete-btn']);
                    return Html::a('删除', $url, ['onclick'=> ' return check("' . $model['uploadname'] . '"' . ')', 'class' => 'btn btn-success btn-sm', 'id' => 'delete-btn' ]);

                },
            ],
        ],
    ],
]);

?>
<script>
    function check(makingname) {
        var orgid = <?= Yii::$app->user->identity->orgid?>;
        var current_user = "<?= Yii::$app->user->identity->name?>";
        if (orgid == 2 || current_user == makingname) {
            if (confirm('您确定要删除吗？')) {
                return true;
            } else {
                return false;
            }
        } else {
            alert('只有管理员和本人可以删除!')
            return false
        }
    }

    function checkedit(makingname) {
        var orgid = <?= Yii::$app->user->identity->orgid?>;
        var current_user = "<?= Yii::$app->user->identity->name?>";
        if (orgid == 2 || current_user == makingname) {
            return true
        } else {
            alert('只有管理员和本人可以修改!')
            return false
        }
    }
</script>

<script>
    $(".gridviewdelete").on("click", function () {
        var orgid = <?= Yii::$app->user->identity->orgid?>;
        if (orgid == 0) {
            alert("只有管理员或审核人可以审核！");
            return false
        } else {
            if (confirm('您确定要批量删除吗？')) {
                var ids = $("#grid").yiiGridView("getSelectedId");
                $.ajax({
                    type: "post",
                    method: "post",
                    dataType: "json",
                    data: {"ids": ids},
                    url: "<?= Url::to(['courseware/deleteall']);?>",
                    success: function (data) {

                    }
                });
            } else {
                return false
            }
        }
    });

</script>



