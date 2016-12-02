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
            <?php if (!empty($query['VideoShoot'])) {
                $model->projectname = $query['VideoShoot']['projectname'];
                $model->school = $query['VideoShoot']['school'];
                $model->courcename = $query['VideoShoot']['courcename'];
                $model->recordname = $query['VideoShoot']['recordname'];
                $model->uploadname = $query['VideoShoot']['uploadname'];
                $model->time = $query['VideoShoot']['time'];
                $model->test = $query['VideoShoot']['test'];
                $model->status = $query['VideoShoot']['status'];
            }?>
            <?= $form->field($model, 'projectname')->widget(Select2::classname(), ['data' =>$pro_projectname , 'options' => ['placeholder' => '选择项目'], ]); ?>
            <?= $form->field($model, 'school')->widget(Select2::classname(), ['data' => $pro_school, 'options' => ['placeholder' => '请选择学校'], ]); ?>
            <?= $form->field($model, 'courcename')->widget(Select2::classname(), ['data' => $course_list, 'options' => ['placeholder' => '选择课程名称'], ]); ?>
            <?= $form->field($model, 'recordname')->widget(Select2::classname(), ['data' =>$person_list , 'options' => ['placeholder' => '选择录制人'], ]); ?>
            <?= $form->field($model, 'uploadname')->widget(Select2::classname(), ['data' =>$person_list , 'options' => ['placeholder' => '选择上传人'], ]); ?>
            <?= $form->field($model, 'time')->input('text',['class'=>'input-small']) ?>
            <?= $form->field($model, 'test')->widget(Select2::classname(), ['data' =>Yii::$app->params , 'options' => ['placeholder' => '月份'], ]); ?>
            <?= $form->field($model, 'status')->widget(Select2::classname(), ['data' =>['9' => '未审核', '1' => '一级审核中','2' => '一级通过',
                '3' => '一级驳回','4' => '二级通过','5' => '二级驳回','6' => '二级审核中'] , 'options' => ['placeholder' => '请选择审核状态'], ]); ?>

            <table style="width: 100%;">
                <tr>
                    <td>
                        <div class="form-group">
                            <?= Html::submitButton("查询", ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a("重置", ['index'], ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a('添加', ['create'], ['class' => 'btn btn-sm btn-success'])?>
                            <?= Html::a('批量审核', "", ['class' => 'btn btn-primary btn-sm gridviewverified']) ?>
                            <?= Html::a('导出excel', ['export/videoshoot',
                                'projectname' => $model->projectname,
                                'school' => $model->school,
                                'courcename' => $model->courcename,
                                'recordname' => $model->recordname,
                                'uploadname' => $model->uploadname,
                                'time' => $model->time,
                                'test' => $model->test,
                                'status' => $model->status],
                                ['class' => 'btn btn-sm btn-success']) ?>

                        </div>
                    </td>
                </tr>
            </table>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
