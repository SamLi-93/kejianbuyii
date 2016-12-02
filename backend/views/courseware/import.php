<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Courseware*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '导入';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="center subject_name">
    <span>课件管理</span>
</div>
<div class="col-xs-12">
        <?php $form = ActiveForm::begin([
        'action' => ['import'],
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
    <?= $form->field($model, 'school')->widget(Select2::classname(), ['data' =>$pro_school , 'options' => ['placeholder' => '选择学校'], ]); ?>
    <?= $form->field($model, 'coursename')->widget(Select2::classname(), ['data' =>$course_list , 'options' => ['placeholder' => '选择课程'], ]); ?>
    <?= $form->field($model, 'uploadname')->widget(Select2::classname(), ['data' =>$person_list , 'options' => ['placeholder' => '选择上传人'], ]); ?>
    <?= $form->field($model, 'excelFile')->fileInput(['accept' => '' ]) ?>

    <div class="form-group-btn">
        <?= Html::submitButton('导入', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
        <?= Html::a('模板', ['./kjdrmb.xls'], ['class' => 'btn btn-primary']) ?>
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
</script>