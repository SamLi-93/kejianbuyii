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
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
?>

<div class="widget-box widget_tableDiv">
    <div id="filter_show" class="widget-body">
        <div class="widget-main">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'fieldConfig' => [
                    'template' => "<div class='form-group' style='float: left;width:220px;'>{input}</div>",
                    'labelOptions' => ['style' => 'width:60px;'],
                ],
            ]);
            ?>
            <?php if (!empty($query['Project'])) {
                $model->from_date = $query['Project']['from_date'];
                $model->to_date = $query['Project']['to_date'];
                $model->is_neibu = $query['Project']['is_neibu'];
            }?>

            <div>
                <div class="fleft from_date">
                    <?= $form->field($model, 'from_date')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => '开始日期',],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'format' => 'yyyy-mm-dd ' ,
                        ]
                    ]); ?>
                </div>
                <div class="fleft to_word" style="height: 34px; line-height: 34px"><span>&nbsp&nbsp到&nbsp&nbsp</span></div>
                <div class="to_date">
                    <?= $form->field($model, 'to_date')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => '结束日期',],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'format' => 'yyyy-mm-dd ' ,
                        ]
                    ]); ?>
                </div>

            </div>
            <?= $form->field($model, 'is_neibu')->widget(Select2::classname(), ['data' => ['2' => '外部', '1' => '内部'],'options' => ['placeholder' => '请选择是否内部课程'],  ]); ?>


            <table style="width: 100%;">
                <tr>
                    <td>
                        <div class="form-group">
                            <?= Html::submitButton("查询", ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a("重置", ['index'], ["class" => "btn btn-primary btn-sm"]) ?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
