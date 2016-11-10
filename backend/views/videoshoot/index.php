<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '视频拍摄';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>视频拍摄</span>
</div>

<?php echo $this->render('_search', [
    'model' => $searchModel,
    'pro_projectname' => $pro_projectname,
    'course_list' => $course_list,
    'person_list' => $person_list,
    'pro_school' => $pro_school,
    'query' => $query,
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
            'class' => 'yii\grid\CheckboxColumn',
//            'name'=>'id',
            'checkboxOptions' => function ($model, $key, $index, $column) {
                return ['value' => $model['id'],'id' => $model['id']];
            },
        ],

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
            'format' => 'raw',
            'value' => function ($model) {
                return $model['courcename'];
            }
        ],

        [
            'header' => '录制人员',
            'attribute' => 'recordname',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['recordname'] == null ){
                    return '';
                }
                return $model['recordname'];
            }
        ],

        [
            'header' => '主讲人',
            'attribute' => 'teacher',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['teacher'] == null ){
                    return '';
                }
                return $model['teacher'];
            }
        ],

        [
            'header' => '拍摄时间',
            'attribute' => 'time',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['time'] == null ){
                    return '';
                }
                return $model['time'];
            }
        ],

        [
            'header' => '拍摄时长(时)',
            'attribute' => 'capture_time',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['capture_time'] == null ){
                    return '';
                }
                return $model['capture_time'];
            }
        ],

        [
            'header' => '机位',
            'attribute' => 'seat',
            'value' => function ($model) {
                if ($model['seat'] == null ){
                    return '';
                }
                return $model['seat'];
            }
        ],

        [
            'header' => '上传人',
            'attribute' => 'uploadname',
            'value' => function ($model) {
                if ($model['uploadname'] == null ){
                    return '';
                }
                return $model['uploadname'];
            }
        ],

        [
            'header' => '备注',
            'attribute' => 'remark',
            'value' => function ($model) {
                if ($model['remark'] == null ){
                    return '';
                }
                return $model['remark'];
            }
        ],

        [
            'header' => '审核',
            'attribute' => 'status',
            'value' => function ($model) {
                if ($model['status'] == 0) {
                    return '未审核';
                } elseif ($model['status'] == 1) {
                    return '一级审核中';
                } elseif ($model['status'] == 2) {
                    return '一级通过';
                } elseif ($model['status'] == 3) {
                    return '一级驳回';
                } elseif ($model['status'] == 4) {
                    return '二级通过';
                } elseif ($model['status'] == 5) {
                    return '二级驳回';
                } elseif ($model['status'] == 6) {
                    return '二级审核中';
                }
                return '';
            }
        ],

        ['class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{edit} {delete} {reject}',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    $options = [
                        'title' => '修改',
                        'class' =>'btn btn-success btn-sm',
                        'id' => 'edit-btn',
                        'onclick' => 'return checkedit(' . $model['status'] . ',"' . $model['uploadname'] . '"' . ')',
                    ];
                    $url = Url::to(['videoshoot/edit','id'=>$model['id']]);
                    return Html::a('修改', $url, $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    $url = Url::to(['videoshoot/delete','id'=>$model['id']]);
                    return Html::a('删除', $url, ['onclick'=> ' return check(' . $model['status'] . ',"' . $model['uploadname'] . '"' . ')', 'class' => 'btn btn-success btn-sm', 'id' => 'delete-btn' ]);

                },
                'reject' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    if ($model['status'] == 1 || $model['status'] == 6 ){
                        $url = Url::to(['videoshoot/reject','id'=>$model['id']]);
                        return Html::a('驳回', $url, ['onclick'=> 'return reject(' . $model['status'] . ')', 'class' => 'btn btn-success btn-sm', 'id' => 'reject-btn' ]);
                    }
                },
            ],
        ],

        [
            'label'=>'图片',
            'format'=>'raw',
            'value' => function($model){
                $url = Url::to(['pic/shootpic','id'=>$model['id']]);
                return Html::a('图片', $url, ['title' => '图片', 'target'=>'_blank']);
            }
        ],
    ],
]);
?>

<script>
    function check(status, makingname) {
        var orgid = <?= Yii::$app->user->identity->orgid?>;
        var current_user = "<?= Yii::$app->user->identity->name?>";
        var is_oneself;
        if (makingname.indexOf(current_user) >= 0) {
            is_oneself = 1;
        } else {
            is_oneself = 0;
        }
        if (status == 4 || status == 2) {
            alert('一级、二级通过不能删除!')
            return false
        }
        if (status == 0 || status == 3) {
            if (orgid == 2 || is_oneself == 1) {
                return confirm('确定删除吗？');
            } else {
                alert('只有管理员和本人可以修改!')
                return false
            }
        }
        if (status == 1 || status == 5 || status == 6) {
            if (orgid == 2) {
                return confirm('确定删除吗？');
            } else {
                alert("该记录一级审核中，不允许删除");
                return false;
            }
        }
    }

    function checkedit(status, makingname) {
        var orgid = <?= Yii::$app->user->identity->orgid?>;
        var current_user = "<?= Yii::$app->user->identity->name?>";
        var is_oneself;
        if (makingname.indexOf(current_user) >= 0) {
            is_oneself = 1;
        } else {
            is_oneself = 0;
        }
        if (status == 4) {
            alert('二级通过不能修改!')
            return false
        }
        if (status == 0 || status == 3 || status == 5 || status == 2) {
            if (orgid == 2 || is_oneself == 1) {
                return true
            } else {
                alert('只有本人和管理员可以修改!')
                return false
            }
        }
        if (status == 1 || status == 6) {
            alert('审核中不能修改!')
            return false
        }
    }
</script>
<script>
    $(".gridviewverified").on("click", function () {
        var orgid = <?= Yii::$app->user->identity->orgid?>;
        if (orgid == 0) {
            alert("只有管理员或审核人可以审核！");
            return false
        } else {
            if (confirm('您确定要批量审核吗？')) {
                var ids = $("#w2").yiiGridView("getSelectedId");
                $.ajax({
                    type: "post",
                    method: "post",
                    dataType: "json",
                    data: {"ids": ids},
                    url: "<?= Url::to(['videoshoot/verified']);?>",
                    success: function (data) {

                    }
                });
            } else {
                return false
            }
        }
    });

    function reject(status) {
        var orgid = <?= Yii::$app->user->identity->orgid?>;
        if (status == 1 && orgid == 1 || orgid == 2) {
            if (confirm('您确定要驳回吗？')) {
                return true;
            } else {
                return false;
            }
        } else if (status == 1 && orgid == 0) {
            alert('只有管理员和审核人有权限驳回');
            return false
        } else if (status == 6 && orgid == 2) {
            if (confirm('您确定要驳回吗？')) {
                return true;
            } else {
                return false;
            }
        } else {
            alert('只有管理员可以驳回');
            return false
        }
    }
</script>


