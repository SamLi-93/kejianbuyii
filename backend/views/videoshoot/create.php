<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '视频拍摄';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="center subject_name">
    <span>视频拍摄</span>
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
    <span id="coursename"><?= $form->field($model, 'courcename')->dropDownList($course_list,['prompt'=>'选择课程']) ?></span>
    <?= $form->field($model, 'teacher')->dropDownList($teacher_list, ['prompt'=>'选择主讲人']) ?>

<!--    --><?//= $form->field($model, 'recordname',['template' => "{label}\n<div class=\"col-lg-6\"><div class='fleft'>{input}</div></div>",]
//    )->dropDownList($person_list, ['prompt'=>'选择录制人员']) ?>

<!--    --><?//= $form->field($model, 'recordname')->dropDownList($person_list, ['prompt'=>'选择录制人员','id'=> 'videoshoot-recordname1']) ?>

    <?= $form->field($model, 'recordname', ['template' => "{label}\n<div class=\"col-lg-6\">{input}</div>",])->checkboxList($person_list); ?>

    <?= $form->field($model, 'time' /*['template' => "{label}\n<div class=\"col-lg-6\">
<div class='fleft width-200'>{input}</div><div class='fleft mr-l-10 width-200'>{input}</div></div>",]*/)->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => '',],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd HH:ii ' ,
        ]
    ]); ?>

    <?= $form->field($model, 'capture_time')->input('text',['class'=>'input-small']) ?>
    <?= $form->field($model, 'seat')->input('text',['class'=>'input-small']) ?>
    <?= $form->field($model, 'uploadname')->dropDownList($person_list, ['prompt'=>'选择上传人']) ?>

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
            if($.trim($('#videoshoot-projectname').val()) == ''){
                alert('请输入项目名称！');
//                $('#videoshoot-projectname').focusx();
                return false;
            }
            if($.trim($('#videoshoot-school').val()) == ''){
                alert('请输入学校！');
                return false;
            }
            if($.trim($('#videoshoot-courcename').val()) == ''){
                alert('请输入课程名称！');
                return false;
            }
            if($.trim($('#videoshoot-teacher').val()) == ''){
                alert('请输入主讲人！');
//                $('#videoshoot-teacher').focus();
                return false;
            }
            if($.trim($('#videoshoot-time').val()) == ''){
                alert('请输入拍摄时间！');
                return false;
            }
            if($.trim($('#videoshoot-seat').val()) == ''){
                alert('请输入机位！');
                $('#videoshoot-seat').focus();
                return false;
            }
            if($.trim($('#videoshoot-uploadname').val()) == ''){
                alert('请选择上传人！');
                return false;
            }
//            if($.trim($('#time').val()) > $.trim($('#endtime').val())){
//                alert('开始时间不能大于结束时间');
//                $('#school').focus();
//                return false;
//            }
            if(confirm('您确定要提交吗？')){
                return true;
            }else{
                return false;
            }
        });
    });
</script>

<script type="text/javascript">
    $("#videoshoot-projectname").chosen({
        width : "200px",
    });

    $("#videoshoot-courcename").chosen({
        width : "200px",
    });

    $("#videoshoot-uploadname").chosen({
        width : "200px",
    });

    $("#videoshoot-time1").chosen({
        width : "200px",
    });

    $("#videoshoot-school").chosen({
        width : "200px",
    });

    $("#videoshoot-teacher").chosen({
        width : "200px",
    });

    $("#videoshoot-recordname1").chosen({
        width : "200px",
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
            url: "<?= Url::to(['videoshoot/changecheck']);?>",
            success: function(data){
                console.log(data);
                var name = data.coursename;
                var educational = data.educational;
                var condition_info = "<select id=\"videoshoot-courcename\" class=\"dept_select\" name=\"VideoShoot[courcename]\" style=\"width:150px\"><option value=\"\">选择课程名称</option>";
                for(var i = 0; i < name.length; i++){
                    condition_info +="<option value=\""+name[i]+"\">"+name[i]+"</option>";
                }
                condition_info +="</select>";
                $('#coursename .col-lg-3').html(condition_info);

                var condition_info1 = "<select id=\"videoshoot-school\" class=\"dept_select\" name=\"VideoShoot[school]\" style=\"width:150px\"><option value=\"\">选择学校</option>";
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