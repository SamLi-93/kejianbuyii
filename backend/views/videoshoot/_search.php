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
            <?= $form->field($model, 'courcename')->dropDownList($course_list ,['prompt'=>'选择课程名称']) ?>
            <?= $form->field($model, 'recordname')->dropDownList($person_list ,['prompt'=>'选择录制人']) ?>
            <?= $form->field($model, 'uploadname')->dropDownList($person_list ,['prompt'=>'选择上传人']) ?>
            <?= $form->field($model, 'time')->input('text',['class'=>'input-small']) ?>
            <?= $form->field($model, 'time1')->dropDownList(Yii::$app->params ) ?>

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
    $("#videoshoot-projectname").chosen({
        width : "150px",
    });

    $("#videoshoot-courcename").chosen({
        width : "150px",
    });

    $("#videoshoot-recordname").chosen({
        width : "150px",
    });

    $("#videoshoot-uploadname").chosen({
        width : "150px",
    });

    $("#videoshoot-time1").chosen({
        width : "150px",
    });

</script>