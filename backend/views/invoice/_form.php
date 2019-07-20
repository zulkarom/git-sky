<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>

   

    <?= $form->field($model, 'invoice_date')->textInput() ?>

    <?= $form->field($model, 'due_date')->textInput() ?>

    

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gst')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'invoice_pic')->textInput() ?>

    <?= $form->field($model, 'quotation_id')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'trash')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
	
	
	
	
	
	
	<?php
if($model->id == null){
	$text = 'New Invoice';
}else{
	$text = 'Update Invoice';
}
?>

<div class="row">
<div class="col-md-9"><h3><?=$text?></h3></div>
<div class="col-md-3">
<h3>
<?php 
if($model->id){
?>
<a href="<?=Config::get('URL')?>invoice/pdf/<?=$model->id?>" class="btn btn-danger btn-sm" target="_blank"><span class="glyphicon glyphicon-download-alt"></span>  PDF</a>
<?php

if($model->quotation_id > 0){
	?><a href="<?=Config::get('URL')?>quotation/update/<?=$model->quotation_id?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-search"></span>  VIEW QUOTATION</a>
	<?php
}

}
?>
</h3>

</div>
</div>


<div class="x_panel tile">

<?php $form = ActiveForm::begin(['id' => 'form-invoice']); ?>


<div class="form-group">
<label class="control-label col-md-2 col-sm-3 col-xs-12">NAME
</label>
<div class="col-md-5 col-sm-5 col-xs-12">

<?=$form->field($model, 'client_id')->hiddenInput(['value' => $model->id])->label(false)?>

<h5>
<?=$model->getProspectOrClient();?>
</h5>
</div>

<label class="control-label col-md-2 col-sm-3 col-xs-12">INVOICE NO.
</label>
<div class="col-md-3 col-sm-3 col-xs-12">
<h5><b><?php 
if($model->id){
	echo "INV" . $model->id ;
}else{
	echo "NEW";
}

?></b></h5>
</div>

</div>

 <?= $form->field($model, 'summary')->textarea(['maxlength' => true]) ?>



<div class="form-group">




 <?=$form->field($model, 'invoice_date')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);


<?php 
//echo $model->due_date;
if($model->id){
	echo Form::input($model, 'due_date', ['date' => true, 'size'=>3,'labelsize'=>2, 'layout' => 'nogroup']);
}else{
	echo Form::select($model, 'due_date', $model->listValidUntil(), ['size'=>3,'labelsize'=>2, 'layout' => 'nogroup']);
}


?>


</div>





<div class="ln_solid"></div>

<div class="row">
<div class="col-md-1"></div>
<div class="col-md-11">


<table class="table table-striped table-hover">
<thead>
<tr>
	<th>#</th>
	<th>Description</th>
	<th width="8%">Quantity</th>
	<th width="12%">Rate</th>
	<th width="14%">Amount (RM)</th>
	<th width="1%"></th>
</tr>
</thead>
<tbody id="table-body">

<?php 
if($model->id){
	$items = $model->invoiceItemExt();
	if($items){
		foreach($items as $item){
			if($item->product_id == 0){
				$unit_measure = $item->unit_cat;
			}else{
				$unit_measure = $item->unit_product;
			}
			echo '<tr><td><span class="glyphicon glyphicon-move handle"></span></td><td><div class="row"><div class="col-md-6">
			<div class="form-group"><select class="form-control scategory" name="category[]"><option></option>';
			foreach($this->product_cat as $cat){
				$sel = $item->product_cat == $cat->id ? "selected" : "";
				echo "<option value='" .$cat->id ."' ".$sel.">".$cat->category_name ."</option>";
			}
			echo '</select></div>
			</div><div class="col-md-6 con-product"><div class="form-group"><select class="form-control sproduct" name="product[]"><option></option>';
			foreach($item->productlist as $p){
				$sel = $item->product_id == $p->id ? "selected" : "";
				echo "<option value='" .$p->id ."' ".$sel.">".$p->product_name ."</option>";
			}
			echo '</select></div></div></div><div class="form-group"><textarea class="form-control" name="item-desc[]">'.$item->description .'</textarea></div>
			
			</td><td><input class="form-control sqty" name="qty[]" value="'.$item->quantity .'"></td><td><input class="form-control sprice" name="price[]" value="'.$item->price .'"><i class="unitmeasure">'.$unit_measure .'<i></td><td><span class="samount">0.00</span></td>
			<td><a href="javascript:void()" class="remove"><span class="glyphicon glyphicon-remove"></span></a></td>
			</tr>';
		}
	}
}

?>	
	
</tbody>
<tfoot>
<tr>
	<td colspan="2"><button type="button" id="btn-add-new" class="btn btn-default">
	<span class="glyphicon glyphicon-plus"></span> Add New Product
	</button></td>
	<td colspan="2"><strong>TOTAL</strong></td>
	<td><strong><span id="item-total">0.00</span></strong></td>
	<td></td>
</tr>
<tr>
	<td colspan="2"></td>
	<td colspan="2"><label>DISCOUNT</label></td>
	<td colspan="2"><?=Form::input($model, 'discount', ['layout'=> 'plain'])?></td>
</tr>

<tr>
	<td colspan="2"></td>
	<td colspan="2"><label>GST</label></td>
	<td colspan="2"><?=Form::input($model, 'gst', ['layout'=> 'plain'])?></td>
</tr>


<tr>
	<td colspan="2">
	</td>
	<td colspan="2"><strong>GRAND TOTAL</strong></td>
	<td><strong><span id="grand-total">0.00</span></strong></td>
	<td></td>
</tr>

</tfoot>
</table>


</div>
</div>


<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">
			
			<select id="load-note" class="form-control">
			<option value="0">-=Select Note=-</option>
			<?php 
			if($this->inote){
				foreach($this->inote as $n){
					echo '<option value="'.$n->id .'">'.$n->note_name .'</option>';
				}
			}
			
			?>

</select>
			
			</label>
			
			
			
			<div class="col-md-7 col-sm-7 col-xs-12">
			  <?=Form::textarea($model, 'note', ['layout' => 'plain'])?>
			  
			</div>
	
	
	
  </div>
  
  
<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12">STATUS
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<h5>
<?=$model->getStatus()?>

</h5>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12">PERSON IN CHARGE
</label>
<div class="col-md-6 col-sm-6 col-xs-12">

<h5>
<?=$model->getPic()?>

</h5>
</div>
</div>






<?=Form::submit($model, ['draftsubmit' => true, 'submit' =>false])?>

<?=Form::hidden($model, 'status')?>

<?=Form::end()?>

</div>


<script type="text/javascript">
$(document).ready(function(){
	
expandTextarea();
	
$('#load-note').change(function(){
		var id = $(this).val();
		var url = '<?=Config::get('URL')?>invoiceNote/getNote/' + id;
		var el = $(this);
		$.post(url, function(data){
			//alert(data);
			$('#note').text(data);
			expandTextarea('#note');
		});
});

<?php 
if($model->id == null){
	echo '
	if(nameExist()){
	addRow();
	}
	';
}
?>
	
	$('#btn-draft').click(function(){
		if(nameExist()){
			$('#status').val(1);
			$('#form-invoice').submit();
		}else{
			errorName();
		}
	});
	
	
	$('#btn-submit').click(function(){
		if(nameExist()){
			$('#status').val(12);
			$('#form-invoice').submit();
			
		}else{
			errorName();
		}
	});
	
	$("#btn-add-new").click(function(){
		if(nameExist()){
			addRow();
		}else{
			errorName();
		}
		
	});
	
	$( "#table-body" ).sortable({
		handle: ".handle",
		cursor: "move"
	});
	
	
	loadCategoryProduct();
	reloadRemove();
	loadCalc();
	calc();
	
});

function loadCalc(){
	$('.sqty').keyup(function(){
		calc();
	});
	
	$('.sprice').keyup(function(){
		calc();
	});
	
	$('#discount').keyup(function(){
		calc();
	});
	$('#gst').keyup(function(){
		calc();
	});
}

function get_product(cat){
	var url = '<?=Config::get('URL')?>product/productListByCat/' + cat;
	$.post(url, function(data){
		$('#gogo').html(data);
			return data;
	});
}

function addRow(){
	var cat = "<?php 
	foreach($this->product_cat as $cat){
		echo "<option value='" .$cat->id ."'>".$cat->category_name ."</option>";
	}
	
	?>";
	
	
	var con = '<tr><td><span class="glyphicon glyphicon-move handle"></span></td><td><div class="row"><div class="col-md-6"><div class="form-group"><select class="form-control scategory" name="category[]"><option></option>' + cat + '</select></div></div><div class="col-md-6 con-product"><div class="form-group"><select class="form-control sproduct" name="product[]"><option></option></select></div></div></div><div class="form-group"><textarea class="form-control" name="item-desc[]"></textarea></div></td><td><input class="form-control sqty" name="qty[]"></td><td><input class="form-control sprice" name="price[]"><i class="unitmeasure"><i></td><td><span class="samount">0.00</span></td><td><a href="javascript:void()" class="remove"><span class="glyphicon glyphicon-remove"></span></a></td></tr>';
	$("#table-body").append(con);
	
	loadCategoryProduct();
	
	reloadRemove();
	
	loadCalc();
	
	expandTextarea();
}

function reloadRemove(){
	$(".remove").click(function(){
		$(this).parent().parent().remove();
	});
}

function nameExist(){
	var client = $('#client_id').val();
	//alert(prospect + client)
	if(client == 0){
		return false;
	}else{
		return true;
	}
	
}

function errorName(){
	alert('Please create client first!');
}

function loadCategoryProduct(){
	$('.scategory').change(function(){
		var cat = $(this).val();
		var url = '<?=Config::get('URL')?>product/productListByCat/' + cat;
		var el = $(this);
		$.post(url, function(data){
			//alert(data);
			el.parents().eq(2).find('.sproduct').html(data);
			
		});
		
		url = '<?=Config::get('URL')?>productCategory/getCategory/' + cat;
		$.post(url, function(data){
			//alert(data);
			var obj = JSON.parse(data);
			el.parents().eq(4).find('.sprice').val(obj.price_perunit);
			el.parents().eq(4).find('.unitmeasure').html(obj.unit_measure);
			if(!el.parents().eq(4).find('.sqty').val()){
				el.parents().eq(4).find('.sqty').val(1);
			}
			//el.parents().eq(2).find('.sproduct').html(data);
			calc();
		});
		
		
		//alert(el.parents().eq(4).find('.unitmeasure').html());
	});
	
	
	$('.sproduct').change(function(){	
		var product = $(this).val();
		var url = '<?=Config::get('URL')?>product/getPrice/' + product;
		var el = $(this);
		$.post(url, function(data){
			//alert(data);
			var obj = JSON.parse(data);
			el.parents().eq(4).find('.sprice').val(obj.price_perunit);
			el.parents().eq(4).find('.unitmeasure').html(obj.unit_measure);
			if(!el.parents().eq(4).find('.sqty').val()){
				el.parents().eq(4).find('.sqty').val(1);
			}
			
			calc();
			//el.parents().eq(2).find('.sproduct').html(data);
			
		});
		
		
		//alert(el.parents().eq(4).find('.sprice').val());
	});
}

function calc(){
	var elements = document.getElementsByClassName('sqty');
	var total = 0;
	for (var i=0; i<elements.length; i++) {
		var qty = elements[i].value ? elements[i].value : 0;
		var price = elements[i].parentElement.parentElement.getElementsByClassName('sprice')[0].value;
		price = price ? price : 0 ;
		
		var amount = parseFloat(qty) * parseFloat(price);
		total += amount;
		
		console.log(amount.toFixed(2));
		
		elements[i].parentElement.parentElement.getElementsByClassName('samount')[0].innerText = amount.toFixed(2);
		
		
	}
	
	document.getElementById("item-total").innerText = total.toFixed(2);
	var discount = $('#discount').val();
	var gst = $('#gst').val();
	
	discount = discount ? discount : 0 ;
	gst = gst ? gst : 0 ;
	
	
	var grand_total = total + parseFloat(gst) - parseFloat(discount);
	
	document.getElementById("grand-total").innerText = grand_total.toFixed(2);
	

}

function expandTextarea() {
    $('textarea').each(function(){
		$element = $(this).get(0);
		$element.style.overflow = 'hidden';
		$element.style.height = $element.scrollHeight + 'px';
		
		
		$element.addEventListener('keyup', function() {
			this.style.overflow = 'hidden';
			this.style.height = 0;
			this.style.height = this.scrollHeight + 'px';
		}, false);
});
}

</script>


	
	
	
	
	
	

</div>
</div>
</div>
