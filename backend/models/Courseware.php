<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "courseware".
 *
 * @property integer $id
 * @property string $title
 * @property string $teacher
 * @property integer $time
 * @property string $makingname
 * @property string $uploadname
 * @property integer $state
 * @property string $projectname
 * @property string $school
 * @property string $coursename
 * @property integer $date
 * @property integer $enddate
 * @property integer $totalday
 * @property string $status
 * @property string $auditor1
 * @property string $auditor2
 * @property string $remark
 * @property integer $cid
 */
class Courseware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courseware';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'state', 'date', 'enddate', 'totalday', 'cid'], 'integer'],
            [['remark', 'cid'], 'required'],
            [['title', 'teacher', 'makingname', 'uploadname', 'projectname', 'school', 'coursename', 'status', 'auditor1', 'auditor2', 'remark'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'teacher' => 'Teacher',
            'time' => 'Time',
            'makingname' => 'Makingname',
            'uploadname' => 'Uploadname',
            'state' => 'State',
            'projectname' => 'Projectname',
            'school' => 'School',
            'coursename' => 'Coursename',
            'date' => 'Date',
            'enddate' => 'Enddate',
            'totalday' => 'Totalday',
            'status' => 'Status',
            'auditor1' => 'Auditor1',
            'auditor2' => 'Auditor2',
            'remark' => 'Remark',
            'cid' => 'Cid',
        ];
    }
}
