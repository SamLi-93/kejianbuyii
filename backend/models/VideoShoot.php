<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "video_shoot".
 *
 * @property integer $id
 * @property string $recordname
 * @property string $time
 * @property string $time1
 * @property double $capture_time
 * @property string $uploadname
 * @property integer $seat
 * @property string $projectname
 * @property string $school
 * @property string $courcename
 * @property string $teacher
 * @property string $status
 * @property string $auditor1
 * @property string $auditor2
 * @property integer $cid
 */
class VideoShoot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video_shoot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'time1', 'cid'], 'required'],
            [['id', 'seat', 'cid'], 'integer'],
            [['capture_time'], 'number'],
            [['recordname', 'time', 'time1', 'uploadname', 'projectname', 'school', 'courcename', 'teacher', 'status', 'auditor1', 'auditor2'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recordname' => 'Recordname',
            'time' => 'Time',
            'time1' => 'Time1',
            'capture_time' => 'Capture Time',
            'uploadname' => 'Uploadname',
            'seat' => 'Seat',
            'projectname' => 'Projectname',
            'school' => 'School',
            'courcename' => 'Courcename',
            'teacher' => 'Teacher',
            'status' => 'Status',
            'auditor1' => 'Auditor1',
            'auditor2' => 'Auditor2',
            'cid' => 'Cid',
        ];
    }
}
