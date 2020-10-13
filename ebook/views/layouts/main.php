<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use ebook\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use ebook\models\Stats;

ebook\models\MainAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@ebook/views/myasset');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

	
	
</head>
<body>
<?php $this->beginBody() ?>


<div class="super_container">


	
	
	<?= Alert::widget() ?>
	
	<?=$content?>


	<!-- Footer -->
<br /><br /><br />
	<footer class="footer">
		<div class="footer_body">
			<div class="container">
				<div style="color:#cccccc; font-size:11px" align="center">
				
		
			
			<a href="https://skyhint.com" target="_blank"><img src="<?=$directoryAsset?>/img/logo.png" /></a> <br />
			
				Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made by <a href="https://skyhint.com" target="_blank">Skyhint Design</a>
				</div>
			</div>
		</div>
		
	</footer>
</div>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
