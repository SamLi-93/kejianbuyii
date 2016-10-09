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
            <?= $form->field($model, 'projectname')->dropDownList($pro_projectname ,['prompt'=>'请选择']) ?>
            <?= $form->field($model, 'school')->dropDownList($pro_school ,['prompt'=>'请选择']) ?>
            <?= $form->field($model, 'teacher')->dropDownList($pro_teacher ,['prompt'=>'请选择']) ?>
            <?= $form->field($model, 'over')->dropDownList(['0' => '否', '1' => '是'] ,['prompt'=>'请选择']) ?>
<!--            --><?//= $form->field($model, 'over')->input('text',['class'=>'input-small']) ?>

            <table style="width: 100%;">
                <tr>
                    <td>
                        <div class="form-group">
                            <?= Html::submitButton("查询", ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a("重置", ['index'], ["class" => "btn btn-primary btn-sm"]) ?>
                            <?php
                            echo Html::a('添加', ['create'], ['class' => 'btn btn-sm btn-success']);
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#projectsearch-projectname").chosen({
        width : "150px",
    });

    $("#projectsearch-school").chosen({
        width : "150px",
    });

    $("#projectsearch-teacher").chosen({
        width : "150px",
    });

    $("#projectsearch-over").chosen({
        width : "150px",
    });
</script>