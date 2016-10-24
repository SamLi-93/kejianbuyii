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

//        [
//            'header' => '上传路径',
//            'attribute' => 'making_path',
//            'value' => function ($model) {
//                if ($model['making_path'] == null ){
//                    return '';
//                }
//                return $model['making_path'];
//            }
//        ],

        [
            'header' => '审核',
            'attribute' => 'status',
            'value' => function ($model) {
                if ($model['status'] == null ){
                    return '';
                }
                return $model['status'];
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
                    ];
                    $url = Url::to(['videoshoot/edit','id'=>$model['id']]);
                    return Html::a('修改', $url, $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    $url = Url::to(['videoshoot/delete','id'=>$model['id']]);
                    return Html::a('删除', $url, ['onclick'=> 'return check()', 'class' => 'btn btn-success btn-sm', 'id' => 'delete-btn' ]);

                },
                'reject' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    if ($model['status'] == 1 || $model['status'] == 6 ){
                        $url = Url::to(['videomaking/reject','id'=>$model['id']]);
                        return Html::a('驳回', $url, ['onclick'=> 'return reject()', 'class' => 'btn btn-success btn-sm', 'id' => 'reject-btn' ]);
                    }
                },
            ],
        ],

        [
            'label'=>'图片',
            'format'=>'raw',
            'value' => function($model){
                $url = Url::to(['pic/index','id'=>$model['id']]);
                return Html::a('图片', $url, ['title' => '图片']);
            }
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
<script>
    $(".gridviewdelete").on("click", function () {
        if(confirm('您确定要批量审核吗？')){
            var ids = $("#grid").yiiGridView("getSelectedId");
            $.ajax({
                type: "post",
                method: "post",
                dataType: "json",
                data: {"ids": ids},
                url: "<?= Url::to(['videomaking/verified']);?>",
                success: function(data){

                }
            });
        }
    });

    function reject() {
        if(confirm('您确定要驳回吗？')){
            return true;
        }else{
            return false;
        }
    }
</script>


