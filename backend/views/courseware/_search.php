<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 14:34
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectSearch */
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
            <?php if (!empty($query['Courseware'])) {
                $model->projectname = $query['Courseware']['projectname'];
                $model->school = $query['Courseware']['school'];
                $model->coursename = $query['Courseware']['coursename'];
                $model->teacher = $query['Courseware']['teacher'];
                $model->time = $query['Courseware']['time'];
                $model->enddate = $query['Courseware']['enddate'];
            } ?>
            <?= $form->field($model, 'projectname')->widget(Select2::classname(), ['data' => $pro_projectname, 'options' => ['placeholder' => '选择项目'],]); ?>
            <?= $form->field($model, 'school')->widget(Select2::classname(), ['data' => $pro_school, 'options' => ['placeholder' => '请选择学校'],]); ?>
            <?= $form->field($model, 'coursename')->widget(Select2::classname(), ['data' => $course_list, 'options' => ['placeholder' => '选择课程名称'],]); ?>
            <?= $form->field($model, 'teacher')->widget(Select2::classname(), ['data' => $teacher_list, 'options' => ['placeholder' => '选择讲师'],]); ?>
            <?= $form->field($model, 'time')->input('text', ['class' => 'input-small']) ?>
            <?= $form->field($model, 'enddate')->dropDownList(Yii::$app->params) ?>
            <!--just in use of enddate, not actually enddate attribute-->

            <table style="width: 100%;">
                <tr>
                    <td>
                        <div class="form-group">
                            <?= Html::submitButton("查询", ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a("重置", ['index'], ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a('添加', ['create'], ['class' => 'btn btn-sm btn-success']) ?>
                            <?= Html::a('导出excel', ['export/couseware',
                                'projectname' => $model->projectname,
                                'school' => $model->school,
                                'coursename' => $model->coursename,
                                'teacher' => $model->teacher,
                                'uploadname' => $model->uploadname,
                                'time' => $model->time,
                                'enddate' => $model->enddate,],
                                ['class' => 'btn btn-sm btn-success']) ?>
                            <?= Html::a('导入', ['import'], ['class' => 'btn btn-sm btn-success']) ?>
                            <?= Html::a('批量删除', "", ['class' => 'btn btn-primary btn-sm gridviewdelete']) ?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    function changecheck(value) {
        $.ajax({
            type: "post",
            method: "post",
            dataType: "json",
            data: {"value": value},
            url: "<?= \yii\helpers\Url::to(['courseware/changecheck']);?>",
            success: function (data) {
                console.log(data);
                var name = data.coursename;
                var educational = data.educational;
                var condition_info = "<select id=\"courseware-courcename\" class=\"dept_select\" name=\"Courseware[courcename]\" style=\"width:150px\"><option value=\"\">选择课程名称</option>";
                for (var i = 0; i < name.length; i++) {
                    condition_info += "<option value=\"" + name[i] + "\">" + name[i] + "</option>";
                }
                condition_info += "</select>";
                $('#courseware_coursename_chosen').html(condition_info);
            }
        });
    }
</script>