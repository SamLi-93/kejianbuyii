<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '课件管理';
$this->params['breadcrumbs'][] = ['label' => 'Project', 'url' =>  ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => $model->projectname, 'url' => ['view', 'id' => $model->id]];
?>
<div class="center subject_name">
    <span>课程管理</span>
<!--    --><?// var_dump($model);exit;?>
</div>
<div class="col-xs-12">

    <?php $form = ActiveForm::begin([
        'action' => ['videomaking/edit/'.$model['id']],
        'method' => 'post',
        'id' => 'my_form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>


    <?= $form->field($model, 'projectname')->dropDownList($pro_projectname ,['prompt'=>'选择项目']) ?>
    <?= $form->field($model, 'school')->dropDownList($pro_school ,['prompt'=>'请选择学校']) ?>
<!--    --><?//= $form->field($model, 'school')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'courcename')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'teacher')->dropDownList($teacher_list, ['prompt'=>'选择讲师']) ?>
    <?= $form->field($model, 'subtitle')->dropDownList(['0' => '否', '1' => '是'],['prompt'=>'选择有无字幕']) ?>
    <?= $form->field($model, 'free')->dropDownList(['0' => '否', '1' => '是'],['prompt'=>'选择是否结算']) ?>
    <?
        if (count($model['imageFiles'])>1) {
            foreach ($model['imageFiles'] as $k => $v) { ?>
            <div class="image_div" >
<!--                <div class="fleft">--><?//= Html::a($v['path'], \yii\helpers\Url::to(['pic/index','id'=>$model['id']]), ['title' => '图片']);?><!--</div>-->
                <div class="fleft"><?= Html::a($v['path'], \yii\helpers\Url::to(['pic/single','path'=>$v['path']]), ['title' => '图片']);?></div>
                <div class="image_delete"><?= Html::a('删除', '', ['onclick'=> 'return check('.$v['id'].')', 'class' => 'btn-sm', 'id' => 'delete-iamge' ]);?></div>
            </div>
            <?}
        } elseif (count($model['imageFiles'])==1) { ?>
            <div class="image_div" >
                <div class="fleft"><?= Html::a($model['imageFiles'][0]['path'], \yii\helpers\Url::to(['pic/index','id'=>$model['id']]), ['title' => '图片']);?></div>
                <div class="image_delete"><?= Html::a('删除', '', ['onclick'=> 'return check('.$model['imageFiles'][0]['id'].')', 'class' => 'btn-sm', 'id' => 'delete-iamge' ]);?></div>
            </div>
        <?}
    ?>
    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    <?= $form->field($model, 'makingname', ['template' => "{label}\n<div class=\"col-lg-6\">{input}</div>",])->checkboxList($person_list,[
        'itemOptions' => ['checked' => '1']
    ]); ?>

    <div class="form-group-btn">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary', 'id'=> 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    $(function(){
        $('#submit-btn').click(function(){
            if($.trim($('#videomaking-projectname').val()) == ''){
                alert('请选择项目名称！');
                return false;
            }
            if($.trim($('#videomaking-school').val()) == ''){
                alert('请选择学校名称！');
                return false;
            }
            if($.trim($('#videomaking-courcename').val()) == ''){
                alert('请输入课程名称！');
                $('#projectname').focus();
                return false;
            }
            if($.trim($('#videomaking-teacher').val()) == ''){
                alert('请选择讲师名称！');
                return false;
            }
            if($.trim($('#videomaking-subtitle').val()) == ''){
                alert('请选择字幕名称！');
                return false;
            }
            if($.trim($('#videomaking-free').val()) == ''){
                alert('请选择结算！');
                return false;
            }
            if(confirm('您确定要提交吗？')){
                return true;
            }else{
                return false;
            }
        });
    });
    $("#videomaking-projectname").chosen({
        width : "200px",
    });
    $("#videomaking-school").chosen({
        width : "200px",
    });
    $("#videomaking-teacher").chosen({
        width : "120px",
    });
    $("#videomaking-subtitle").chosen({
        width : "120px",
    });
    $("#videomaking-free").chosen({
        width : "120px",
    });
</script>
<script>
    function check(id) {
        if(confirm('您确定要删除吗？')){
            $.ajax({
                type: "post",
                method: "post",
                dataType: "json",
                data: {"id": id},
                url: "<?= \yii\helpers\Url::to(['videomaking/picdelete']);?>",
                success: function(data){

                }
            });
        } else {
            return false;
        }
    }

</script>