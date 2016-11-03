<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
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
        'action' => ['videoshoot/edit/'.$model['id']],
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
        'initValueText' => $pro_school,'options' => ['placeholder' => '选择学校','onchange' => "getteacher(this.options[this.options.selectedIndex].value)"], ]); ?>
    <?= $form->field($model, 'courcename')->widget(Select2::classname(), ['data' =>$course_list , 'options' => ['placeholder' => '选择课程'], ]); ?>
    <?= $form->field($model, 'teacher')->widget(Select2::classname(), ['data' =>$teacher_list , 'options' => ['placeholder' => '选择主讲人'], ]); ?>
    <?= $form->field($model, 'recordname', ['template' => "{label}\n<div class=\"col-lg-6\">{input}</div>",]
            )->checkboxList($person_list, [ 'itemOptions' => ['checked' => '1'] ]) ;?>

    <?= $form->field($model, 'time')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => '',],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd hh:ii ' ,
        ]
    ]); ?>

    <?
    if (count($model['imageFiles'])>1) {
        foreach ($model['imageFiles'] as $k => $v) { ?>
            <div class="image_div" >
                <!--                <div class="fleft">--><?//= Html::a($v['path'], \yii\helpers\Url::to(['pic/index','id'=>$model['id']]), ['title' => '图片']);?><!--</div>-->
                <div class="fleft"><?= Html::a($v['path'], \yii\helpers\Url::to(['pic/shootsingle','path'=>$v['path']]), ['title' => '图片']);?></div>
                <div class="image_delete"><?= Html::a('删除', '', ['onclick'=> 'return check('.$v['id'].')', 'class' => 'btn-sm', 'id' => 'delete-iamge' ]);?></div>
            </div>
        <?}
    } elseif (count($model['imageFiles'])==1) { ?>
        <div class="image_div" >
            <div class="fleft"><?= Html::a($model['imageFiles'][0]['path'], \yii\helpers\Url::to(['pic/shootpic','id'=>$model['id']]), ['title' => '图片']);?></div>
            <div class="image_delete"><?= Html::a('删除', '', ['onclick'=> 'return check('.$model['imageFiles'][0]['id'].')', 'class' => 'btn-sm', 'id' => 'delete-iamge' ]);?></div>
        </div>
    <?}
    ?>

    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    <?= $form->field($model, 'capture_time')->input('text',['class'=>'input-small']) ?>
    <?= $form->field($model, 'seat')->input('text',['class'=>'input-small']) ?>
<!--    --><?//= $form->field($model, 'uploadname')->dropDownList($person_list, ['prompt'=>'选择上传人']) ?>
    <?= $form->field($model, 'uploadname')->widget(Select2::classname(), ['data' =>$person_list , 'options' => ['placeholder' => '选择上传人'], ]); ?>

    <div class="form-group-btn">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    $(function(){
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

<script>
    function check(id) {
        if(confirm('您确定要删除吗？')){
            $.ajax({
                type: "post",
                method: "post",
                dataType: "json",
                data: {"id": id},
                url: "<?= \yii\helpers\Url::to(['videoshoot/picdelete']);?>",
                success: function(data){

                }
            });
        } else {
            return false;
        }
    }
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

                var course_list = "<select id=\"videoshoot-courcename\" class=\"form-control select2-hidden-accessible\" name=\"VideoShoot[courcename]\" ><option value=\"\">选择学校</option><optgroup label'>";
                for(var key in name){
                    course_list +="<option value="+key+" > "+name[key]+" </option>";
                }
                course_list +="</optgroup></select>";
                $('#videoshoot-courcename').html(course_list);

                var school_list = "<select id=\"videoshoot-school\" class=\"form-control select2-hidden-accessible\" name=\"VideoShoot[School]\" ><option value=\"\">选择课程名</option>";
                for(var i = 0; i < educational.length; i++){
                    school_list +="<option value="+educational[i]+"> "+educational[i]+" </option>";
                }
                school_list +="</select>";
                $('#videoshoot-school').html(school_list);
            }
        });
    }

    function getteacher(value) {
        $.ajax({
            type: "post",
            method: "post",
            dataType: "json",
            data: {"value": value},
            url: "<?= Url::to(['videoshoot/getteacher']);?>",
            success: function(data){
                console.log(data);
                var teacher = data.teacher;

                var teacher_list = "<select id=\"videoshoot-teacher\" class=\"form-control select2-hidden-accessible\" name=\"VideoShoot[teacher]\" ><option value=\"\">选择讲师</option>";
                for(key in teacher){
                    teacher_list +="<option value="+teacher[key]+"> "+teacher[key]+" </option>";
                }
                teacher_list +="</select>";
                $('#videoshoot-teacher').html(teacher_list);
            }
        });
    }
</script>