<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "sms_admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property integer $gender
 * @property integer $level
 * @property integer $orgid
 * @property string $orgname
 * @property string $power
 * @property integer $update_id
 * @property integer $update_date
 * @property integer $isdelete
 * @property integer $valid
 * @property string $perms_bysj
 * @property integer $groupid
 * @property string $mclassids
 * @property integer $fpower
 * @property integer $is_audit
 * @property integer $upload
 * @property integer $audit
 * @property integer $copen
 * @property integer $empower
 * @property integer $status
 * @property string $password_hash
 * @property string $auth_key
 */
class SmsAdmin extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $status;
    public $authKey;
    public $accessToken;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender', 'level', 'orgid', 'update_id', 'update_date', 'isdelete', 'valid', 'groupid', 'fpower', 'is_audit', 'upload', 'audit', 'copen', 'empower', 'status'], 'integer'],
            [['perms_bysj'], 'string'],
            [['status', 'password_hash', 'auth_key'], 'required'],
            [['username', 'name'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 32],
            [['orgname'], 'string', 'max' => 255],
            [['power'], 'string', 'max' => 11],
            [['mclassids'], 'string', 'max' => 100],
            [['password_hash', 'auth_key'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'gender' => 'Gender',
            'level' => 'Level',
            'orgid' => 'Orgid',
            'orgname' => 'Orgname',
            'power' => 'Power',
            'update_id' => 'Update ID',
            'update_date' => 'Update Date',
            'isdelete' => 'Isdelete',
            'valid' => 'Valid',
            'perms_bysj' => 'Perms Bysj',
            'groupid' => 'Groupid',
            'mclassids' => 'Mclassids',
            'fpower' => 'Fpower',
            'is_audit' => 'Is Audit',
            'upload' => 'Upload',
            'audit' => 'Audit',
            'copen' => 'Copen',
            'empower' => 'Empower',
            'status' => 'Status',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
        ];
    }

    public static function findByUsername($username) {
        $user = SmsAdmin::find()->where(['username' => $username])->one();
        if ($user) {
            return new static($user);
        }
        return null;
    }

    public function validatePassword($password){
        if(($password) === $this -> password){
            return true;
        }
        return false;
    }

    public static function findIdentity($id) {
        $user = self::findById($id);
        if ($user) {
            return new static($user);
        }
        return null;
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        $user = SmsAdmin::find()->where(array('accessToken' => $token))->one();
        if ($user) {
            return new static($user);
        }
        return null;
    }

    public static function findById($id) {
        $user = SmsAdmin::find()->where(array('id' => $id))->asArray()->one();
        if ($user) {
            return new static($user);
        }
        return null;
    }

    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->authKey;
    }


    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    public function getGenderName(){
        $gender = Yii::$app->params['gender'];
        $name = array_key_exists($this->gender,$gender)?$gender[$this->gender]:'';
        return $name;
    }

    public function getPersonList()
    {
        $list = self::findBySql('select DISTINCT name from sms_admin')->all();
        $person_list = [];
        foreach ($list as $k => $v) {
            $key = $v['name'];
            $person_list[$key] = $v['name'] ;
        }
        return $person_list;
    }



}
