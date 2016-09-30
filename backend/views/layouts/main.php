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
</head>

<script>
    $('.sims_list').click(
        alert('ttt');
        function(){
            index = $(".sims_left dt").index(this);

            if($(".left_cons").eq(index).css("display") == "none"){
                $(".left_cons").slideUp("slow").eq(index).slideDown("slow");
                $(".sims_list_on").removeClass("sims_list_on").addClass("sims_list");
                $(this).removeClass("sims_list").addClass("sims_list_on");

            }
        }
    );
</script>
<body>
<?php $this->beginBody() ?>

<div class="sims_top">
    <span class="sims_top1"></span>
    <span class="sims_top3" style="width:30px;">欢迎 </span>
    <span class="sims_top2"><?php print_r('test');?></span>
    <span class="sims_top3"> 访问课件部！ </span>
    <span class="sims_top4"></span>
    <span class="sims_top5" id="stimer"></span>
</div>
<div class="sims_left" id="sims_left">
    <dt class="sims_list_on">后台管理</dt>
    <dd class="left_cons">
        <a href="#" class="left_con" target="main">项目管理</a>
        <a href="#" class="left_con" target="main">视频拍摄</a>
        <a href="#" class="left_con" target="main">课程管理</a>
        <a href="#" class="left_con" target="main">课件管理-未审核</a>
        <a href="#" class="left_con" target="main">课件管理-一级通过</a>
        <a href="#" class="left_con" target="main">课件管理-二级通过</a>
        <a href="#" class="left_con" target="main">讲师管理</a>
        <a href="#" class="left_con" target="main">项目统计</a>
        <a href="#" class="left_con" target="main">人员统计</a>
        <a href="#" class="left_con" target="main">人员管理</a>
    </dd>
</div>

<?= $content;?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
