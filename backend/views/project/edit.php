<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '修改';
$this->params['breadcrumbs'][] = ['label' => 'Project', 'url' =>  ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => $model->projectname, 'url' => ['view', 'id' => $model->id]];
?>
<div class="center subject_name">
    <span>项目管理1</span>
</div>
<div class="col-xs-12">

    <?php $form = ActiveForm::begin([
        'action' => ['project/edit/'.$model['id']],
        'method' => 'post',
        'id' => 'my_form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'projectname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'school')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'over')->dropDownList(['0' => '否', '1' => '是']) ?>
    <?= $form->field($model, 'free')->dropDownList(['0' => '否', '1' => '是']) ?>
    <?= $form->field($model, 'teacher')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'time')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]); ?>
    <?= $form->field($model, 'endtime')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]); ?>

    <?= $form->field($model, 'original_path')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'making_path')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'uploadname')->dropDownList($uploadname_list) ?>

    <div class="form-group-btn">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary', 'id'=> 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    $(function(){
        $('#submit-btn').click(function(){
            if($.trim($('#project-projectname').val()) == ''){
                alert('请输入项目名称！');
                $('#projectname').focus();
                return false;
            }
            if($.trim($('#project-school').val()) == ''){
                alert('请输入学校！');
                $('#school').focus();
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