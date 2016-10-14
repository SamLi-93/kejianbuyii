<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 上午12:48
 */

namespace backend\controllers;

use app\models\VideoShoot;
use Yii;
use app\models\Project;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\grid\GridView;

class ProjectcountController extends Controller
{
    private $pro_projectname = [];
    private $pro_school = [];

    public function init()
    {
        parent::init();
        $search_info = new VideoShoot();
        $pro_info = new Project();
        $this->pro_projectname = $search_info->getProjectName();
        $this->pro_school = $pro_info->getSchoolName();

    }

}