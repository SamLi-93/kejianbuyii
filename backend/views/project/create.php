<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Create Menu';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="center subject_name">
    <span>项目管理</span>
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
        <?= Html::submitButton('添加', ['class' => 'btn btn-primary']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
