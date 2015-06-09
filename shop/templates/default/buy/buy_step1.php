<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/area_array.js"></script> 
<div class="ncc-main">
  <div class="ncc-title">
    <h3><?php echo $lang['cart_index_ensure_info'];?></h3>
    <h5>请仔细核对填写收货、发票等信息，以确保物流快递及时准确投递。</h5>
  </div>
  <div class="ncc-receipt-info">
        <div class="ncc-receipt-info-title"><h3/>收获方<h3/></div>
        <div><label><input type="radio" name="receive" checked value="20"/>放入微仓</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="receive" value="10"/>直接发货</label></div>
  </div>
    <?php include template('buy/buy_address');?>
    <?php include template('buy/buy_payment');?>
    <?php include template('buy/buy_invoice');?>
    <form method="post" id="order_form" name="order_form" action="index.php">  
    <?php include template('buy/buy_goods_list');?>
    <?php include template('buy/buy_amount');?>
    <input value="buy" type="hidden" name="act">
    <input value="buy_step2" type="hidden" name="op">
    <!-- 来源于购物车标志 -->
    <input value="<?php echo $output['ifcart'];?>" type="hidden" name="ifcart">

    <!-- offline/online -->
    <input value="online" name="pay_name" id="pay_name" type="hidden">

    <!-- 是否保存增值税发票判断标志 -->
    <input value="<?php echo $output['vat_hash'];?>" name="vat_hash" type="hidden">

    <!-- 收货地址ID -->
    <input value="<?php echo $output['address_info']['address_id'];?>" name="address_id" id="address_id" type="hidden">

    <input value="20" type="hidden" name="recever_type" id="recever_type"/>

    <!-- 城市ID(运费) -->
    <input value="" name="buy_city_id" id="buy_city_id" type="hidden">

    <!-- 记录所选地区是否支持货到付款 第一个前端JS判断 第二个后端PHP判断 -->
    <input value="" id="allow_offpay" name="allow_offpay" type="hidden">
    <input value="" id="offpay_hash" name="offpay_hash" type="hidden">

    <!-- 默认使用的发票 -->
    <input value="<?php echo $output['inv_info']['inv_id'];?>" name="invoice_id" id="invoice_id" type="hidden">

    <input value="<?php echo getReferer();?>" name="ref_url" type="hidden">
    </form>
</div>
<script type="text/javascript">
$('input[name="receive"]').change(function(){
    if($(this).val()=='10'){    //直接发货
        $('#edit_reciver').parent('div').parent('div').show();
        $(".pd-account").parent('tr').hide();
        $("input[name='pd_pay']").attr('checked', false);
        $("#password_callback").val(0);
        $('#recever_type').val('10');
        $('dl.freight').show();
        $('dl.operation').show();
        $('#edit_reciver').click();
        calcOrder();
    }else{
        $('#edit_reciver').parent('div').parent('div').hide();
        $(".pd-account").parent('tr').show();
        //showShippingPrice(0 ,0);
        hideAddrList('', '', '', '');
        $('#recever_type').val('20');
        $('dl.operation').hide();
        $('dl.freight').hide();
        //yunfei
        $("#buy_city_id").val('');
        $('#allow_offpay').val(0);
        $('#offpay_hash').val('');
        calcOrder();
    }
});
//计算部运费和每个店铺小计
function calcOrder() {
    var allTotal = 0;
    $('em[nc_type="eachStoreTotal"]').each(function(){
        store_id = $(this).attr('store_id');
        var eachTotal = 0;
        if ($('#eachStoreFreight_'+store_id).length > 0 && $('#eachStoreFreight_'+store_id).parent().parent().css('display')!='none') {
        	eachTotal += parseFloat($('#eachStoreFreight_'+store_id).html());
	    }
        if ($('#eachStoreGoodsTotal_'+store_id).length > 0) {
        	eachTotal += parseFloat($('#eachStoreGoodsTotal_'+store_id).html());
	    }
        if($('#eachStoreOperation_'+store_id).length > 0 && $('#eachStoreOperation_'+store_id).parent().parent().css('display')!='none') {
            eachTotal += parseFloat($('#eachStoreOperation_'+store_id).html());
        }
        if ($('#eachStoreManSong_'+store_id).length > 0) {
        	eachTotal += parseFloat($('#eachStoreManSong_'+store_id).html());
	    }
        if ($('#eachStoreVoucher_'+store_id).length > 0) {
        	eachTotal += parseFloat($('#eachStoreVoucher_'+store_id).html());
        }
        $(this).html(number_format(eachTotal,2));
        allTotal += eachTotal;
    });
    $('#orderTotal').html(number_format(allTotal,2));
}
$(function(){
    $.ajaxSetup({
        async : false
    });
    $('select[nctype="voucher"]').on('change',function(){
        if ($(this).val() == '') {
        	$('#eachStoreVoucher_'+items[1]).html('-0.00');
        } else {
            var items = $(this).val().split('|');
            $('#eachStoreVoucher_'+items[1]).html('-'+number_format(items[2],2));
        }
        calcOrder();
    });
    <?php if (!empty($output['available_pd_amount'])) { ?>
    $('input[name="pd_pay"]').on('change',function(){
        if ($(this).attr('checked')) {
        	$('#password').val('');
        	$('#password_callback').val('');
            $('#pd_password').show();
        } else {
        	$('#pd_password').hide();
        }
    });
    $('#pd_pay_submit').on('click',function(){
        if ($('#password').val() == '') {
        	showDialog('请输入登录密码', 'error','','','','','','','','',2);return false;
        }
        $('#password_callback').val('');
		$.get("index.php?act=buy&op=check_pd_pwd", {'password':$('#password').val()}, function(data){
            if (data == '1') {
            	$('#password_callback').val('1');
            	$('#pd_password').hide();
            } else {
            	$('#password').val('');
            	showDialog('密码错误', 'error','','','','','','','','',2);
            }
        });
    });
    <?php } ?>
});
function disableOtherEdit(showText){
	$('a[nc_type="buy_edit"]').each(function(){
	    if ($(this).css('display') != 'none'){
			$(this).after('<font color="#B0B0B0">' + showText + '</font>');
		    $(this).hide();		    
	    }
	});
	disableSubmitOrder();
}
function ableOtherEdit(){
	$('a[nc_type="buy_edit"]').show().next('font').remove();
	ableSubmitOrder();
	
}
function ableSubmitOrder(){
	$('#submitOrder').on('click',function(){submitNext()}).css('cursor','').addClass('ncc-btn-acidblue');
}
function disableSubmitOrder(){
	$('#submitOrder').unbind('click').css('cursor','not-allowed').removeClass('ncc-btn-acidblue');
}
</script>