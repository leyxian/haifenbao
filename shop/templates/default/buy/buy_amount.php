<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<div class="ncc-bottom"> <a href="javascript:void(0)" id='submitOrder' class="ncc-btn ncc-btn-acidblue fr"><?php echo $lang['cart_index_submit_order'];?></a> </div>
<script>
function submitNext(){
	if($('input[name="receive"]:checked').val() == '10'){
	    if ($('#address_id').val() == ''){
			showDialog('<?php echo $lang['cart_step1_please_set_address'];?>', 'error','','','','','','','','',2);
			return;	
		}
		if ($('#buy_city_id').val() == '') {
			showDialog('正在计算运费,请稍后', 'error','','','','','','','','',2);
			return;
		}
	}
	if ($('input[name="pd_pay"]').attr('checked') && $('#password_callback').val() != '1') {
		showDialog('使用预存款支付，需输入登录密码并使用  ', 'error','','','','','','','','',2);
		return;
	}
	var allTotal = number_format($('#orderTotal').html(), 2);

	var goodsTotal = 0;
	$('em[nc_type="eachStoreTotal"]').each(function(){
		store_id = $(this).attr('store_id');
		var eachTotal = 0;
		if ($('#eachStoreGoodsTotal_'+store_id).length > 0) {
        	eachTotal += parseFloat($('#eachStoreGoodsTotal_'+store_id).html());
	    }
	    goodsTotal += eachTotal;
	});
	var is_check = true;
	if($('input[name="receive"]:checked').val() == '10'){
		is_check = false;
		if(goodsTotal >= 500){
			alert('订单金额不能大于等于500元');
			return false;
		}		
		$.post('index.php',{'act':'buy', 'op': 'order_total', 'num': goodsTotal, 'address_id': $("#address_id").val()}, function(data){
			if(data=='true') is_check = true;
			else{ alert('每个用户每天不得下单超过1000元'); is_check= false; return is_check; }
		});
		if(is_check){
			$.post('index.php',{'act':'buy', 'op': 'order_total', 'num': goodsTotal, 'address_id': $("#address_id").val(),'type': '1'}, function(data){
				if(data=='true') is_check = true;
				else{ alert('每个用户每周不得下单超过3单'); is_check= false; return is_check;}
			});
		}
	}
	if(is_check) {
		$('#order_form').submit();
	}
}
$(function(){
	$('#submitOrder').on('click',function(){submitNext()});
	calcOrder();
});
</script>