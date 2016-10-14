<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/chosen/1.6.2/chosen.jquery.js"></script>
    <script src="//cdn.bootcss.com/chosen/1.6.2/chosen.jquery.min.js"></script>
    <link href="//cdn.bootcss.com/chosen/1.6.2/chosen.css" rel="stylesheet">
</head>
<!--<script>-->
<!--    $(document).ready(function(){-->
<!--        $('.left_con').click(-->
<!--            function(){-->
<!--                $(this).addClass("left_con_on");-->
<!--                $(this).removeClass("left_con");-->
<!--            }-->
<!--        );-->
<!--    });-->
<!--</script>-->

<body>
<?php $this->beginBody() ?>

<div class="sims_top navbar navbar-default">
    <span class="sims_top1"></span>
    <span class="sims_top3" style="width:30px;">欢迎 </span>
    <span class="sims_top2"><?php print_r('test');?></span>
    <span class="sims_top3"> 访问课件部！ </span>
    <span class="sims_top4"></span>
    <span class="sims_top5" id="stimer"></span>
</div>
<div class="main-container" id="main-container">
    <div class="main-container-inner">
        <div class="sims_left sidebar" id="sidebar">
            <dt class="sims_list_on">后台管理</dt>
            <dd class="left_cons">
<!--                --><?// var_dump(Yii::$app->controller->id=='project' ? '1' : '2' );exit; ?>
                <a href="<?= \yii\helpers\Url::to(['project/index']) ?>" class="<?= Yii::$app->controller->id == 'project'? 'left_con_on' : 'left_con'; ?>" target="main">项目管理</a>
                <a href="<?= \yii\helpers\Url::to(['videoshoot/index']) ?>" class="<?= Yii::$app->controller->id == 'videoshoot'? 'left_con_on' : 'left_con'; ?>" target="main">视频拍摄</a>
                <a href="<?= \yii\helpers\Url::to(['videomaking/index']) ?>" class="<?= Yii::$app->controller->id == 'videomaking'? 'left_con_on' : 'left_con'; ?>" target="main">课程管理</a>
                <a href="<?= \yii\helpers\Url::to(['coursewareunverify/index']) ?>" class="<?= Yii::$app->controller->id == 'coursewareunverify'? 'left_con_on' : 'left_con'; ?>" target="main">课件管理-未审核</a>
                <a href="<?= \yii\helpers\Url::to(['coursewareverifyone/index']) ?>" class="<?= Yii::$app->controller->id == 'coursewareverifyone'? 'left_con_on' : 'left_con'; ?>" target="main">课件管理-一级通过</a>
                <a href="<?= \yii\helpers\Url::to(['coursewareverifytwo/index']) ?>" class="<?= Yii::$app->controller->id == 'coursewareverifytwo'? 'left_con_on' : 'left_con'; ?>" target="main">课件管理-二级通过</a>
                <a href="<?= \yii\helpers\Url::to(['teacher/index']) ?>" class="<?= Yii::$app->controller->id == 'teacher'? 'left_con_on' : 'left_con'; ?>" target="main">讲师管理</a>
                <a href="<?= \yii\helpers\Url::to(['projectcount/index']) ?>" class="<?= Yii::$app->controller->id == 'projectcount'? 'left_con_on' : 'left_con'; ?>" target="main">项目统计</a>
                <a href="<?= \yii\helpers\Url::to(['personnelcount/index']) ?>" class="<?= Yii::$app->controller->id == 'personnelcount'? 'left_con_on' : 'left_con'; ?>" target="main">人员统计</a>
                <a href="<?= \yii\helpers\Url::to(['personnel/index']) ?>" class="<?= Yii::$app->controller->id == 'personnel'? 'left_con_on' : 'left_con'; ?>" target="main">人员管理</a>
            </dd>
        </div>
        <div class="main-content">
            <div class="page-content">
<!--                --><?//= $content ?>
            </div>
        </div>
    </div>
</div>


<?= $content;?>

<?php $this->endBody() ?>
</body>
<script>
    $(document).ready(function(){
        $('.left_con').click(
            function(){
                $(this).addClass("left_con_on");
                $(this).removeClass("left_con");
            }
        );
    });
</script>
</html>
<?php $this->endPage() ?>
