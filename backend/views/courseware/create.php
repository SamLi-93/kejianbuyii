<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Courseware*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '课件管理';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="center subject_name">
    <span>课件管理</span>
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

    <?= $form->field($model, 'projectname')->dropDownList($pro_projectname,['prompt'=>'选择项目', 'onchange' => "changecheck(this.options[this.options.selectedIndex].value)" ] ) ?>
    <span id="school"><?= $form->field($model, 'school')->dropDownList($pro_school,['prompt'=>'选择学校']) ?></span>
    <span id="coursename"><?= $form->field($model, 'coursename')->dropDownList($course_list,['prompt'=>'选择课程']) ?></span>
    <?= $form->field($model, 'title')->input('text',['class'=>'input-small']) ?>
    <?= $form->field($model, 'teacher')->dropDownList($teacher_list, ['prompt'=>'选择主讲人']) ?>

    <?= $form->field($model, 'time0',['template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>"]
        )->input('text',['class'=>'time-input']) ?>
    <?= $form->field($model, 'time1',['template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>"]
    )->input('text',['class'=>'time-input']) ?>
    <?= $form->field($model, 'time2',['template' => "{label}\n<div class=\"col-lg-1\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>"]
    )->input('text',['class'=>'time-input']) ?>

    <?= $form->field($model, 'makingname')->dropDownList($person_list, ['prompt'=>'选择主讲人']) ?>
    <?= $form->field($model, 'date')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => '选择日期',],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd ' ,
        ]
    ]); ?>

    <?= $form->field($model, 'enddate')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => '选择日期',],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd ' ,
        ]
    ]); ?>
    <?= $form->field($model, 'uploadname')->dropDownList($person_list, ['prompt'=>'选择上传人']) ?>
    <?= $form->field($model, 'remark')->input('text',['class'=>'input-small']) ?>
    <div class="form-group-btn">
        <?= Html::submitButton('添加', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    $(function(){
//        var a = $(":checkbox");
//        if(a.length > 4)
//            alert("录制人员最多选4个");
//        alert($('#name').val())
        $('#submit-btn').click(function(){
            if($.trim($('#courseware-projectname').val()) == ''){
                alert('请输入项目名称！');
                return false;
            }
            if($.trim($('#courseware-school').val()) == ''){
                alert('请输入学校！');
                return false;
            }
            if($.trim($('#courseware-courcename').val()) == ''){
                alert('请输入课程名称！');
                return false;
            }
            if($.trim($('#courseware-title').val()) == ''){
                alert('请输入视频标题！');
                return false;
            }
            if($.trim($('#courseware-teacher').val()) == ''){
                alert('请输入主讲人！');
                return false;
            }
            if($.trim($('#courseware-time0').val()) == ''){
                alert('请输入拍摄时间！');
                return false;
            }
            if($.trim($('#courseware-time1').val()) == ''){
                alert('请输入拍摄时间！');
                return false;
            }
            if($.trim($('#courseware-time2').val()) == ''){
                alert('请输入拍摄时间！');
                return false;
            }
            if($.trim($('#courseware-makingname').val()) == ''){
                alert('请输入制作人！');
                return false;
            }
            if($.trim($('#courseware-uploadname').val()) == ''){
                alert('请选择上传人！');
                return false;
            }
            if(confirm('您确定要提交吗？')){
                return true;
            }else{
                return false;
            }
        });
    });
</script>

<script type="text/javascript">
    $("#courseware-projectname").chosen({
        width : "200px",
    });
    $("#courseware-school").chosen({
        width : "200px",
    });
    $("#courseware-coursename").chosen({
        width : "200px",
    });
    $("#courseware-teacher").chosen({
        width : "120px",
    });
    $("#courseware-makingname").chosen({
        width : "120px",
    });
    $("#courseware-uploadname").chosen({
        width : "120px",
    });
    $('.dept_select').chosen();
</script>

<script>
    function changecheck(value) {
        $.ajax({
            type: "post",
            method: "post",
            dataType: "json",
            data: {"value": value},
            url: "<?= Url::to(['courseware/changecheck']);?>",
            success: function(data){
                console.log(data);
                var name = data.coursename;
                var educational = data.educational;
                var condition_info = "<select id=\"courseware-courcename\" class=\"dept_select\" name=\"Courseware[courcename]\" style=\"width:150px\"><option value=\"\">选择课程名称</option>";
                for(var i = 0; i < name.length; i++){
                    condition_info +="<option value=\""+name[i]+"\">"+name[i]+"</option>";
                }
                condition_info +="</select>";
                $('#coursename .col-lg-3').html(condition_info);

                var condition_info1 = "<select id=\"courseware-school\" class=\"dept_select\" name=\"Courseware[school]\" style=\"width:150px\"><option value=\"\">选择学校</option>";
                for(var i = 0; i < educational.length; i++){
                    condition_info1 +="<option value=\""+educational[i]+"\">"+educational[i]+"</option>";
                }
                condition_info1 +="</select>";
                $('#school .col-lg-3').html(condition_info1);
                $('.dept_select').chosen();
            }
        });
    }
</script>