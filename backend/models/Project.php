<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $projectname
 * @property string $school
 * @property integer $over
 * @property integer $free
 * @property string $teacher
 * @property integer $time
 * @property integer $endtime
 * @property string $original_path
 * @property string $making_path
 * @property string $uploadname
 */
class Project extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['over', 'free', 'time', 'endtime'], 'integer'],
            [['projectname', 'school'], 'string', 'max' => 100],
            [['teacher', 'uploadname'], 'string', 'max' => 50],
            [['original_path', 'making_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'projectname' => 'Projectname',
            'school' => 'School',
            'over' => 'Over',
            'free' => 'Free',
            'teacher' => 'Teacher',
            'time' => 'Time',
            'endtime' => 'Endtime',
            'original_path' => 'Original Path',
            'making_path' => 'Making Path',
            'uploadname' => 'Uploadname',
        ];
    }

    public function getProjectName()
    {
        $list = self::findBySql('select DISTINCT projectname from project')->all();
        $pro_list = [];
        foreach ($list as $k => $v) {
            array_push($pro_list, $v['projectname']);
        }
        return $pro_list;
    }

    public function getSchoolName()
    {
        $list = self::findBySql('select DISTINCT school from project')->all();
        $school_list = [];
        foreach ($list as $k => $v) {
            array_push($school_list, $v['school']);
        }
        return $school_list;
    }

    public function getTeacherName()
    {
        $list = self::findBySql('select DISTINCT teacher from project')->all();
        $teacher_list = [];
        foreach ($list as $k => $v) {
            array_push($teacher_list, $v['teacher']);
        }
        return $teacher_list;
    }

    public function getOverList()
    {
        $list = self::findBySql('select DISTINCT over from project')->all();
        $over_list = [];
        foreach ($list as $k => $v) {
            array_push($over_list, $v['over']);
        }
        return $over_list;
    }


}
