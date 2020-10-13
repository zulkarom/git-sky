<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\jeb\models\Journal;
use yii\widgets\ActiveForm;

$this->title= 'BASIC ACCOUNTING - EBOOK DOWNLOAD PAGE';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@ebook/views/myasset');
?>


	<div class="courses">
		<div class="container">
		
			<div class="row">
			
			<div class="col-lg-1"></div>
			
			<div class="col-lg-10">
			
			
			<div class="row">
<div class="col-md-7">

<img src="<?=$directoryAsset?>/img/cover-1/ebook.png" />
<h4>Description</h3>
<p style="font-size:16px;">

<b>Name</b>: Basic Accounting <br />
<b>Edition</b>: Third Edition <br />
<b>Type</b>: Ebook <br />
<b>Authors</b>: Ainon & Maslina <br />
<b>Pages</b>: 187 pages <br />
<b>Price</b>: RM 11  <br />
<br />
This book benefits students as guidance to introduction to accounting. Non-accounting students should have knowledge in fundamental accounting to assist in personal life and/or future business. This book simplifies the topics to attract and help non-accounting students to learn Basic Accounting.
</p>
<br />
</div>

<div class="col-md-5">

<div class="site-index">
<h3>Thank you for payment</h3>
    
	<a href="<?=Url::to(['site/download-file', 'transaction' => $transaction])?>" class="btn btn-primary">DOWNLOAD THE BOOK HERE</a>

</div><!-- site-index -->



</div>

</div>
			
			
			
		

			
			<br />
		
			
			</div>
				
				
			
			</div>
<br />
	
	

			
			
		</div>
	</div>
	


	
