<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 14:34
 */


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectSearch*/
/* @var $form yii\widgets\ActiveForm */
?>

<div class="widget-box widget_tableDiv">
    <div id="filter_show" class="widget-body">
        <div class="widget-main">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'fieldConfig' => [
                    'template' => "<div class='form-group' style='float: left;width:150px;'>{input}</div>",
                    'labelOptions' => ['style' => 'width:60px;'],
                ],
            ]);
            ?>
            <?= $form->field($model, 'projectname')->dropDownList($pro_projectname ,['prompt'=>'选择项目']) ?>
            <?= $form->field($model, 'school')->dropDownList($pro_school ,['prompt'=>'请选择学校']) ?>
            <?= $form->field($model, 'courcename')->dropDownList($course_list ,['prompt'=>'请选择课程名']) ?>
            <?= $form->field($model, 'makingname')->dropDownList($person_list ,['prompt'=>'请选择上传人']) ?>
            <?= $form->field($model, 'free')->dropDownList(['2' => '否', '1' => '是'] ,['prompt'=>'请选择费用结算']) ?>
            <?= $form->field($model, 'subtitle')->dropDownList(['2' => '无', '1' => '有'] ,['prompt'=>'请选择有无字幕']) ?>

            <table style="width: 100%;">
                <tr>
                    <td>
                        <div class="form-group">
                            <?= Html::submitButton("查询", ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a("重置", ['index'], ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a('添加', ['create'], ['class' => 'btn btn-sm btn-success'])?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#videomaking-projectname").chosen({
        width : "150px",
    });
    $("#videomaking-school").chosen({
        width : "150px",
    });
    $("#videomaking-courcename").chosen({
        width : "150px",
    });
    $("#videomaking-makingname").chosen({
        width : "150px",
    });
    $("#videomaking-subtitle").chosen({
        width : "150px",
    });
    $("#videomaking-free").chosen({
        width : "150px",
    });
</script>