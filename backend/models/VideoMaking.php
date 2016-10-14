<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "video_making".
 *
 * @property integer $id
 * @property string $makingname
 * @property integer $subtitle
 * @property string $projectname
 * @property string $school
 * @property string $courcename
 * @property integer $free
 * @property string $teacher
 */
class VideoMaking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video_making';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['id'], 'required'],
            [['id', 'subtitle', 'free'], 'integer'],
            [['makingname', 'projectname', 'teacher', 'school', 'courcename'], 'string', 'max' => 100],
            [['teacher'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'makingname' => '上传人',
            'subtitle' => '字幕',
            'projectname' => '项目名',
            'school' => '学校',
            'courcename' => '课程名',
            'free' => '结算',
            'teacher' => '讲师',
        ];
    }
}
