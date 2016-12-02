<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '视频拍摄';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?// var_dump($model['recordname']);exit;?>
<div class="center subject_name">
    <span>视频拍摄</span>
</div>
<div class="col-xs-12">
    <?php $form = ActiveForm::begin([
        'action' => ['courseware/edit/'.$model['id']],
        'method' => 'post',
        'id' => 'my_form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'projectname')->widget(Select2::classname(), ['data' =>$pro_projectname ,
        'options' => ['placeholder' => '选择项目','onchange' => "changecheck(this.options[this.options.selectedIndex].value)" ],
    ]); ?>
    <?= $form->field($model, 'school')->widget(Select2::classname(), [
        'initValueText' => $pro_school, 'options' => ['placeholder' => '选择学校','onchange' => "getteacher(this.options[this.options.selectedIndex].value)"] ]); ?>
    <?= $form->field($model, 'coursename')->widget(Select2::classname(), ['data' =>$course_list , 'options' => ['placeholder' => '选择课程'], ]); ?>
    <?= $form->field($model, 'title')->input('text',['class'=>'input-small']) ?>
    <?= $form->field($model, 'teacher')->widget(Select2::classname(), ['data' =>$teacher_list , 'options' => ['placeholder' => '选择主讲人'], ]); ?>
    <?= $form->field($model, 'time0',['template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>"]
    )->input('text',['class'=>'time-input']) ?>
    <?= $form->field($model, 'time1',['template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>"]
    )->input('text',['class'=>'time-input']) ?>
    <?= $form->field($model, 'time2',['template' => "{label}\n<div class=\"col-lg-1\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>"]
    )->input('text',['class'=>'time-input']) ?>
    <?= $form->field($model, 'makingname')->widget(Select2::classname(), ['data' =>$person_list , 'options' => ['placeholder' => '选择制作人'], ]); ?>

    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => '选择日期',],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd ' ,
        ]
    ]); ?>

    <?= $form->field($model, 'totalday')->input('text',['class'=>'input-small']) ?>
    <?= $form->field($model, 'uploadname')->widget(Select2::classname(), ['data' =>$person_list , 'options' => ['placeholder' => '选择上传人'], ]); ?>
    <?= $form->field($model, 'remark')->input('text',['class'=>'input-small']) ?>

    <div class="form-group-btn">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    $(function(){
        $('#submit-btn').click(function(){
            if($.trim($('#courseware-projectname').val()) == ''){
                alert('请输入项目名称！');
                return false;
            }
            if($.trim($('#courseware-school').val()) == ''){
                alert('请输入学校！');
                return false;
            }
            if($.trim($('#courseware-coursename').val()) == ''){
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
            var date = ($('#courseware-date').val());
            var enddate = ($('#courseware-enddate').val());
            if (enddate < date) {
                alert('结束时间不能小于开始日期!');
                return false
            }
            if(confirm('您确定要提交吗？')){
                return true;
            }else{
                return false;
            }
        });
    });
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

                var course_list = "<select id=\"courseware-coursename\" class=\"form-control select2-hidden-accessible\" name=\"Courseware[coursename]\" ><option value=\"\">选择课程</option><optgroup label'>";
                for(var key in name){
                    course_list +="<option value="+key+" > "+name[key]+" </option>";
                }
                course_list +="</optgroup></select>";
                $('#courseware-coursename').html(course_list);

                var school_list = "<select id=\"courseware-school\" class=\"form-control select2-hidden-accessible\" name=\"Courseware[School]\" ><option value=\"\">选择学校</option>";
                for(var i = 0; i < educational.length; i++){
                    school_list +="<option value="+educational[i]+"> "+educational[i]+" </option>";
                }
                school_list +="</select>";
                $('#courseware-school').html(school_list);
            }
        });
    }

//    function getteacher(value) {
//        $.ajax({
//            type: "post",
//            method: "post",
//            dataType: "json",
//            data: {"value": value},
//            url: "<?//= Url::to(['courseware/getteacher']);?>//",
//            success: function(data){
//                console.log(data);
//                var teacher = data.teacher;
//
//                var teacher_list = "<select id=\"courseware-teacher\" class=\"form-control select2-hidden-accessible\" name=\"Courseware[teacher]\" ><option value=\"\">选择讲师</option>";
//                for(key in teacher){
//                    teacher_list +="<option value="+teacher[key]+"> "+teacher[key]+" </option>";
//                }
//                teacher_list +="</select>";
//                $('#courseware-teacher').html(teacher_list);
//            }
//        });
//    }
</script>