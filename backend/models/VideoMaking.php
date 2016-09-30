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
            [['id', 'teacher'], 'required'],
            [['id', 'subtitle', 'free'], 'integer'],
            [['makingname', 'projectname', 'school', 'courcename'], 'string', 'max' => 100],
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
            'makingname' => 'Makingname',
            'subtitle' => 'Subtitle',
            'projectname' => 'Projectname',
            'school' => 'School',
            'courcename' => 'Courcename',
            'free' => 'Free',
            'teacher' => 'Teacher',
        ];
    }
}
