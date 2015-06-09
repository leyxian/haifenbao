<div class="eject_con">
<div id="warning"></div>
<?php if ($output['goods_info']) {?>

  <form id="changeform" method="post" action="index.php?act=goods&op=add_goods_shortStock">
    <input type="hidden" name="form_submit" value="ok" />
	<input type="hidden" name="goodsid" id="goodsid" value="<?php echo $output['goods_info']['goods_id']; ?>" />
	<input type="hidden" name="goodsname" id="goodsname" value="<?php echo $output['goods_info']['goods_name']; ?>" />
    <dl>
      <dt><?php //echo $lang['store_order_buyer_with'].$lang['nc_colon'];?>商品名称：</dt>
      <dd><?php echo $output['goods_info']['goods_name']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo '订购数量'.$lang['nc_colon'];?></dt>
      <dd>
        <input name="goodquantity" type="text" class="text" id="goodquantity" value="10"/>
      </dd>
    </dl>
	
    <dl>
      <dt><?php echo '订购说明'.$lang['nc_colon'];?></dt>
      <dd>
        <input name="gcontent" type="text" class="text" id="gcontent" value="test" />
      </dd>
    </dl>
		
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" id="confirm_button" value="确定" />
      </dd>
    </dl>
  </form>
<?php } else { ?>
<p style="line-height:80px;text-align:center">该商品不存在，请检查参数是否正确!</p>
<?php } ?>
</div>
<script type="text/javascript">
$(function(){
    $('#changeform').validate({
    	errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors){ $('#warning').show();}else{ $('#warning').hide(); }
        },    
	    rules : {
        	goodquantity : {
	            required : true,
	            number : true
	        }
	    },
	    messages : {
	    	goodquantity : {
	    		required : '商品数量不能为空且必须为数字',
            	number : '商品数量不能为空且必须为数字'
	        }
	    }
	});
});
</script>