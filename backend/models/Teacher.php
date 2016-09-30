<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property integer $id
 * @property string $college
 * @property string $teacher
 * @property integer $sex
 * @property string $phone
 * @property string $qq
 * @property string $mail
 * @property string $remarks
 * @property string $uploadname
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex'], 'integer'],
            [['college', 'teacher', 'phone', 'qq', 'mail', 'remarks', 'uploadname'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'college' => 'College',
            'teacher' => 'Teacher',
            'sex' => 'Sex',
            'phone' => 'Phone',
            'qq' => 'Qq',
            'mail' => 'Mail',
            'remarks' => 'Remarks',
            'uploadname' => 'Uploadname',
        ];
    }
}
