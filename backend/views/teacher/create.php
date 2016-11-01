<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Teacher*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '添加讲师';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="center subject_name">
    <span>讲师管理</span>
</div>
<div class="col-xs-12">

    <?php $form = ActiveForm::begin([
        'action' => ['create'],
        'method' => 'post',
        'id' => 'my_form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'teacher')->textInput(['maxlength' => true]) ?>
<!--        --><?//= $form->field($model, 'sex')->dropDownList(['1' => '男', '2' => '女'], ['prompt'=>'选择性别']) ?>
<!--        --><?//= $form->field($model, 'college')->dropDownList($pro_school,['prompt'=>'选择院校']) ?>
        <?= $form->field($model, 'sex')->widget(Select2::classname(), ['data' => ['1' => '男', '2' => '女'], 'options' => ['placeholder' => '请选择性别'], ]); ?>
        <?= $form->field($model, 'college')->widget(Select2::classname(), ['data' => $pro_school, 'options' => ['placeholder' => '请选择学校'], ]); ?>
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <div class="form-group-btn">
        <?= Html::submitButton('添加', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        $('#submit-btn').click(function(){
            if($.trim($('#teacher-teacher').val()) == ''){
                alert('请输入讲师姓名！');
                $('#teacher-teacher').focus();
                return false;
            }
            if($.trim($('#teacher-sex').val()) == ''){
                alert('请选择性别！');
                return false;
            }
            if($.trim($('#teacher-college').val()) == ''){
                alert('请选择学校1！');
                return false;
            }
//            if($.trim($('#teacher-phone').val()) == ''){
//                alert('请输入讲师电话！');
//                $('#teacher-phone').focus();
//                return false;
//            }
//            if($.trim($('#teacher-qq').val()) == ''){
//                alert('请输入qq或邮箱！');
//                $('#teacher-qq').focus();
//                return false;
//            }
            if(confirm('您确定要提交吗？')){
                return true;
            }else{
                return false;
            }
        });
    });

//    $("#teacher-sex").chosen({
//        width : "100px",
//    });
//
//    $("#teacher-college").chosen({
//        width : "200px",
//    });
</script>
