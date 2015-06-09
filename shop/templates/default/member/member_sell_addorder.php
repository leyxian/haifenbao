<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo SHOP_SITE_URL;?>/templates/default/css/seller_add_order.css"  />

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/area_array.js" charset="utf-8"></script>


<style type="text/css">
.store-name {
	width: 130px;
	display: inline-block;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
}
</style>

<div class="wrap">

<div class="tabmenu">
	<ul class="tab pngFix">
		<li class="normal"><a  href="index.php?act=member_sell_order"><?php echo $lang['nc_member_path_all_order'] ?></a></li>	
		<li class="normal"><a  href="index.php?act=member_sell_order&state_type=short_order"><?php echo $lang['nc_member_path_short_order'] ?></a></li>
		<li class="normal"><a  href="index.php?act=member_sell_order&state_type=wait_send"><?php echo $lang['nc_member_path_wait_send'] ?></a></li>		
		<li class="normal"><a  href="index.php?act=member_sell_order&state_type=order_shipping"><?php echo $lang['nc_member_path_order_shipping'] ?></a></li>		
		<li class="normal"><a  href="index.php?act=member_sell_order&state_type=state_cancel"><?php echo $lang['nc_member_path_canceled'] ?></a></li>
		<li class="active"><a  href="index.php?act=member_sell_order&state_type=add_sell_order">新建销售订单</a></li>			
		<li style=" float:right;font-weight:bold; font-size:18px;" class="normal"><a  href="index.php?act=member_sell_order&state_type=add_sell_order">添加销售订单</a></li>	
	</ul>
  </div>
  <form method="get" action="index.php" target="_self">
    <table class="search-form">
      <input type="hidden" name="act" value="member_sell_order" />
      <tr>
        <td></td>
        <th><?php//echo $lang['member_order_time'].$lang['nc_colon'];?></th>
        <td class="w180"><!--<input type="text" class="text" name="query_start_date" id="query_start_date" value="<?php//echo $_GET['query_start_date']; ?>"/>
          &#8211;
          <input type="text" class="text" name="query_end_date" id="query_end_date" value="<?php//echo $_GET['query_end_date']; ?>"/>--></td>
        <th><?php echo $lang['member_order_sn'].$lang['nc_colon'];?></th>
        <td class="w160"><input type="text" class="text" name="order_sn" value="<?php echo $_GET['order_sn']; ?>" /></td>
        <th><?php echo $lang['member_order_state'].$lang['nc_colon'];?></th>
        <td class="w100"><select name="state_type">
            <option value="" <?php echo $_GET['state_type']==''?'selected':''; ?>><?php echo $lang['member_order_all'];?></option>
            <option value="short_order" <?php echo $_GET['state_type']=='short_order'?'selected':''; ?>>待采购</option>
            <option value="wait_send" <?php echo $_GET['state_type']=='wait_send'?'selected':''; ?>>待发货</option>
            <option value="order_shipping" <?php echo $_GET['state_type']=='order_shipping'?'selected':''; ?>>待收货</option>
            <option value="state_cancel" <?php echo $_GET['state_type']=='state_cancel'?'selected':''; ?>>已取消</option>
        </select></td>
        <td class="w90 tc"><input name="submit" type="submit" class="submit" value="<?php echo $lang['member_order_search'];?>" /></td>
      </tr>
    </table>
  </form>
<div class="item-publish">
  <form method="post" id="goods_form" name="goods_form" action="<?php  echo urlShop('member_sell_order', 'add_goods_order');?>">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="ref_url" value="<?php echo $_GET['ref_url'] ? $_GET['ref_url'] : getReferer();?>" />
    <div class="ncsc-form-goods">
      <dl>
        <dt class="required"><i class="required">*</i>订单编号：</dt>
        <dd>
          <input name="g_order_sn" type="text" class="text w200" id="g_order_sn" value="<?php echo $output['sell_order']['sell_order_sn']; ?>" maxlength="30" />
          &nbsp; &nbsp; <span class="hint">请输入分销商的订单编号</span>

        </dd>
      </dl>
      <dl>
        <dt class="required"><i class="required">*</i>收货人姓名：</dt>
        <dd>
          <input name="g_buy_name" type="text" class="text w200" id="g_buy_name" value="<?php echo $output['sell_order']['buyer_name']; ?>" maxlength="25" />
          &nbsp; &nbsp; <span class="hint">请输入收货人姓名</span>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i>身份证号码：</dt>
        <dd>
          <input name="g_card_no" type="text" class="text w200" id="g_card_no" value="<?php echo $output['sell_order']['buyer_card_no']; ?>" maxlength="18" />
          &nbsp; &nbsp; <span class="hint">请输入收货人身份证号码</span>
        </dd>
      </dl>	  
      <dl>
        <dt nc_type="no_spec"><i class="required">*</i>手机号码：</dt>
        <dd nc_type="no_spec">
          <input name="g_phone" type="text"  class="text w200" id="g_phone" value="<?php echo $output['sell_order']['buyer_phone']; ?>" maxlength="11" /> 
          &nbsp; &nbsp; <i class="icon-mobile-phone"></i><span class="hint">请输入收货人手机号码</span>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i>收货地址：</dt>
 		<dd>
		<span id="region">
          <select class="w110">
          </select>
          <input type="hidden" value="" name="city_id" id="city_id">
          <input type="hidden" name="area_id" id="area_id" class="area_ids"/>
          <input type="hidden" name="area_info" id="area_info" class="area_names"/>
		  <!--$str = '你 好'; echo str_replace(' ','',$str);  要去除area_info地名中间的空格 area_info特殊空格去不了 以后再优化了-->
        </span>				
          <input name="g_address" id="g_address" value="<?php echo $output['sell_order']['buyer_address']; ?>" type="text" class="text w300" /><span class="hint"><i class="required">*</i>请输入收货人详细地址</span>
        </dd>
      </dl>

      <dl>
        <dt><i class="required">*</i>店铺名称：</dt>
        <dd>
          <select class="orderselect pordersec selected-site_type" name="g_store_from" id="g_store_from">                    
												<option value="微店">微店</option>
												<option value="淘宝">淘宝</option>
												<option value="天猫">天猫</option>
												<option value="天猫国际">天猫国际</option>
												<option value="宝宝树">宝宝树</option>
												<option value="金鹰商贸">金鹰商贸</option>
												<option value="金箍棒">金箍棒</option>
												<option value="海豹村">海豹村</option>
												<option value="贝贝网">贝贝网</option>
												<option value="亚马逊">亚马逊</option>
												<option value="京东">京东</option>
												<option value="苏宁易购">苏宁易购</option>
												<option value="一号店">一号店</option>
												<option value="阿里巴巴">阿里巴巴</option>
												<option value="洋码头">洋码头</option>
												<option value="万国优品">万国优品</option>
												<option value="拍拍">拍拍</option>
												<option value="线下" selected="selected">线下</option>
												<option>其他</option>
			</select>&nbsp; &nbsp; 
			     <input  type="text" class="text w200"  name="g_store_name" id="g_store_name" value="<?php echo $output['sell_order']['sell_store_name']; ?>" >					
					&nbsp; &nbsp; <span class="hint">请输入分销商店铺名称</span>
        </dd>
      </dl>

<dl>
        <dt>顾客购买时间：</dt>
        <dd>
          <ul class="ncsc-form-radio-list">
		  <input type="text" class="w180 text" name="g_order_time_y"  style="background:#FFFFF none;" id="starttime" value="<?php echo date('Y-m-d');?>" />&nbsp;
		  <select name="g_order_time_h">
		  <?php for ($i=0;$i<24;$i++){
				if($i<10)$str='0'.$i;
				else $str=$i;
				echo "<option value='",$str,"'>$str</option>";		  
			  }	  
		  ?>
		  </select>时&nbsp;
		  <select name="g_order_time_m">
		  <?php for ($i=0;$i<60;$i++){
				if($i<10)$str='0'.$i;
				else $str=$i;
				echo "<option value='",$str,"'>$str</option>";		  
			  }	  
		  ?>
		  </select>	分	  
		  
 			 &nbsp; &nbsp;&nbsp; <span class="hint">时间格式:2015-05-28 19:36</span>
  
            </ul>
        </dd>
      </dl>

      <dl>
        <dt nc_type="no_spec"><i class="required">*</i>支付总额：</dt>
        <dd nc_type="no_spec">
          <input name="g_pd_amount" id="g_pd_amount" value="<?php echo $output['sell_order']['buyer_pd_amount']; ?>" type="text"  class="text w200" /> &nbsp; &nbsp; <span class="hint">请输入收货人支付总额</span>
        </dd>
      </dl>



      <dl>
        <dt nc_type="no_spec">订单总额：</dt>
        <dd nc_type="no_spec">
          <input name="g_order_amount" id="g_order_amount" value="<?php echo $output['sell_order']['buyer_order_amount']; ?>" type="text"  class="text w200" /> &nbsp; &nbsp; <i class="required"></i><span class="hint">请输入收货人订单总额</span>
        </dd>
      </dl>
	  
      <dl>
        <dt nc_type="no_spec">物流费用：</dt>
        <dd nc_type="no_spec">
          <input name="g_trans_fee" id="g_trans_fee" value="<?php echo $output['sell_order']['buyer_trans_fee']; ?>" type="text"  class="text w200" /> &nbsp; &nbsp; <span class="hint">请输入收货人物流费用</span>
        </dd>
      </dl>
	  	  
      <dl>
        <dt nc_type="no_spec">备注：</dt>
        <dd nc_type="no_spec">
          <textarea name="g_remark" maxlength="140"  class="text w400" id="g_remark"><?php echo $output['sell_order']['sell_remark']; ?></textarea> 
          &nbsp; &nbsp; <span class="hint">填写订单相关信息</span>
        </dd>
      </dl>
	  
            

      <!--transport info begin-->
		<h3>官方商品信息：</h3>
        <dl>
        <dt class="required"><i class="required">*</i>商品编号：</dt>
        <dd>
          <input onblur="getGoodsinfo()" name="g_serial" id="g_serial" type="text" class="text w200" value="<?php echo $output['sell_order']['goods_serial']; ?>" />&nbsp; &nbsp; <span class="hint">请输入正确的商品编号,在我的微仓和商品详细页面中都有此编号</span>
        </dd>
      </dl>    

      <dl>
        <dt><i class="required">*</i>产品名称(系统)：</dt>
        <dd><input name="g_goods_name" id="g_goods_name" readonly="yes" value="<?php echo $output['sell_order']['goods_name']; ?>" type="text"  class="text w200" />&nbsp; &nbsp; <input name="g_goods_name2" id="g_goods_name2"  value="<?php echo $output['sell_order']['sell_goods_name']; ?>" type="text"  class="text w200" /> 
        </dd>
      </dl>
	  
		<dl>
          <dt><i class="required">*</i>购买数量：</dt>
          <dd class="ncs-figure-input">
            <input type="text" name="quantity" id="quantity"  value="<?php 
			if(empty($output['sell_order']['sell_goods_qty']) || $output['sell_order']['sell_goods_qty']<1) echo '1';
			else echo $output['sell_order']['sell_goods_qty'];?>" onKeyUp="this.value=this.value.replace(/\D/g,&#39;&#39;)" size="3" maxlength="6" class="text w40">
            <a href="javascript:void(0)" class="increase">+</a><a href="javascript:void(0)" class="decrease">-</a> </dd>
        </dl>	  
	  
       <dl>
        <dt><i class="required">*</i>价格：</dt>
        <dd><input name="g_price"  id="g_price" value="<?php echo $output['sell_order']['sell_order_price']; ?>" type="text"  class="text w60" /> &nbsp; &nbsp; <span class="hint">请输入商品价格</span>        
        </dd> <input type="hidden" name="g_goods_id" id="g_goods_id" value="<?php echo $output['sell_order']['goods_id']; ?>"/>
      </dl>
	       
      </div>
    <div class="bottom tc hr32">
      <label class="submit-border">
        <input type="submit" class="submit" id="addOrderButton" name="addOrderButton" value="提交" />
      </label>
    </div>
  </form>
</div>  
</div>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" ></script>
<script type="text/javascript">

$(function(){
   // $('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
   // $('#query_end_date').datepicker({dateFormat: 'yy-mm-dd'});	
	  regionInit("region");
	
    // 发布时间
    $('#starttime').datepicker({dateFormat: 'yy-mm-dd'});	


//当分销售商输入商品编号时自动获取商品名、商品ID、价格：	
	   $("#g_serial").blur(function(){
	    var g_serial= $("#g_serial").val();
	
		$.ajax({     
			url:"<?php echo urlShop('member_sell_order', 'get_goods_info');?>",     
			type:'post',     
			data:'g_serial='+g_serial,     
			async : false, //默认为true 异步     
			error:function(){     
			   alert('error');     
			},     
			success:function(data){
				//alert(data);		
					strs=data.split('+'); 
					$("#g_goods_id").val(strs[0]); 					   
					$("#g_goods_name").val(strs[1]); 
					$("#g_goods_name2").val(strs[1]);
					$("#g_price").val(strs[2]);
				
			}  
		}); 	

    });
	
});

		
		/* 商品购买数量增减js */
		// 增加
		$('.increase').click(function(){
			num = parseInt($('#quantity').val());
				if(isNaN(num) || num < 1 || num=='NaN')num=1;
				$('#quantity').val(num+1);
		});
		//减少
		$('.decrease').click(function(){
			num = parseInt($('#quantity').val());
			if(num > 1){
				$('#quantity').val(num-1);
			}
		});
	
    function checkStr(str, tag){
        var res = false;
        switch(tag){
            case 'sms': //身份证
                if(/(^\d{15}$)|(^\d{17}([0-9]|X)$)/.test(str))
                    res = true;
                break;
            default:
                if(/^1[3,5,8]\d{9}$/.test(str))
                    res = true;
                break;
        }
        return res;
    }
//提交表单前验证：
	$("#addOrderButton").click(function(){
	
		  	var g_order_sn=$("#g_order_sn").val();
		  	var g_buy_name=$("#g_buy_name").val();
		  	var g_card_no=$("#g_card_no").val();
		  	var g_phone=$("#g_phone").val();
		  	var g_address=$("#g_address").val();
		  	var g_area_id=$("#area_id").val();			
		  //	var g_store_from=$("#g_store_from").val();
		  	var g_store_name=$("#g_store_name").val();	
		  	//var g_order_time_y=$("#g_order_time_y").val();
		  	//var g_order_time_h=$("#g_order_time_h").val();
		  	//var g_order_time_m=$("#g_order_time_m").val();
		  	//var g_order_time_m=$("#g_order_time_m").val();
		  	var g_pd_amount=$("#g_pd_amount").val();
		  	//var g_order_amount=$("#g_order_amount").val();
		  	//var g_trans_fee=$("#g_trans_fee").val();			
		  	//var g_remark=$("#g_remark").val();
		  	var g_serial=$("#g_serial").val(); 
		  	//var g_goods_name=$("#g_goods_name").val();
		  	var quantity=$("#quantity").val();
		  	var g_price=$("#g_price").val();
			
		  	if(!g_order_sn){ //平台订单号为空时:
		  		alert("请输入平台订单号!");
				$("#g_order_sn").focus();
		  		return false;
			 }	
			 //导出判断:收货人姓名		  		  			
		  	if(!g_buy_name){
		  		alert("请输入收货人姓名!");
				$("#g_buy_name").focus();
		  		return false;
			 }		 	
			//当身份证号码为空时:	
			if(!g_card_no){
				alert("请输入身份证号码");
				$("#g_card_no").focus();
                return false;
			}
            if(!checkStr(g_card_no, 'sms')){
                alert("身份证号码格式不正确");
                $("#g_card_no").focus();
                return false;
            }
			//当手机号码为空时:
			if(!g_phone){
				alert("请输入手机号码");
				$("#g_phone").focus();
				return false;
			}
            if(!checkStr(g_phone)){
                alert("手机号码格式不正确");
                $("#g_phone").focus();
                return false;
            }
			//当未选择地区时:	
			if(!g_area_id){
				alert("请选择您所在的地区");
				$("#g_area_id").focus();
				return false;
			}						
			//当收货地址为空时:	
			if(!g_address){
				alert("请输入收货地址");
				$("#g_address").focus();
				return false;
			}	
			
					
/*			//当店铺名称为空时:
			if(!g_store_name){
				alert("请输入店铺名称");
				$("#g_store_name").focus();
				return false;
			}*/			
			//当支付总额为空时:	
			if(!g_pd_amount){
				alert("请输支付总额");
				$("#g_pd_amount").focus();
				return false;
			}			
			//当官方商品编号为空时:	
			if(!g_serial){
				alert("请输入官方商品编号");
				$("#g_serial").focus();
				return false;
			}	
			//当商品数量为空时:	
			if(!quantity){
				alert("请输入商品数量");
				$("#quantity").focus();
				return false;
			}				
			//当商品价格为空时:	
			if(!g_price){
				alert("请输入商品价格");
				$("#g_price").focus();
				return false;
			}			
			
	});	







</script>

<!--<script type="text/javascript">
$(document).ready(function(){
alert('region');
	regionInit("region");
    $('#goods_form').validate({
        rules : {
            true_name : {
                required : true
            },
            area_id : {
                required : true,
                min   : 1,
                checkarea:true
            },
            address : {
                required : true
            },
            mob_phone : {
                required : checkPhone,
                minlength : 11,
				maxlength : 11,
                digits : true
            },
            tel_phone : {
                required : checkPhone,
                minlength : 6,
				maxlength : 20
            }
        },
        messages : {
            true_name : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_input_receiver'];?>'
            },
            area_id : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_choose_area'];?>',
                min  : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_choose_area'];?>',
                checkarea : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_choose_area'];?>'
            },
            address : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_input_address'];?>'
            },
            mob_phone : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_telphoneormobile'];?>',
                minlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_mobile_num_error'];?>',
				maxlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_mobile_num_error'];?>',
                digits : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_mobile_num_error'];?>'
            },
            tel_phone : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_telphoneormobile'];?>',
                minlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['member_address_phone_rule'];?>',
				maxlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['member_address_phone_rule'];?>'
            }
        },
        groups : {
            phone:'mob_phone tel_phone'
        }
    });
});
function checkPhone(){
    return ($('input[name="mob_phone"]').val() == '' && $('input[name="tel_phone"]').val() == '');
}
function submitAddAddr(){
    if ($('#addr_form').valid()){
        $('#buy_city_id').val($('#region').find('select').eq(1).val());
        $('#city_id').val($('#region').find('select').eq(1).val());
        var datas=$('#addr_form').serialize();
        $.post('index.php',datas,function(data){
            if (data.state){
                var true_name = $.trim($("#true_name").val());
                var tel_phone = $.trim($("#tel_phone").val());
                var mob_phone = $.trim($("#mob_phone").val());
            	var area_info = $.trim($("#area_info").val());
            	var address = $.trim($("#address").val());
            	showShippingPrice($('#city_id').val(),$('#area_id').val());
            	hideAddrList(data.addr_id,true_name,area_info+'&nbsp;&nbsp;'+address,(mob_phone != '' ? mob_phone : tel_phone));
            }else{
                alert(data.msg);
            }
        },'json');
    }else{
        return false;
    }
}
</script>-->
