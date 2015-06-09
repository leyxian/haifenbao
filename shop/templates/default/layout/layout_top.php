<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="public-top-layout w">
  <div class="topbar wrapper">  
    <div class="user-entry">
    <?php if($_SESSION['is_login'] == '1'){?>
	 <span> <a href="<?php echo SHOP_SITE_URL;?>"  title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>">海分宝供应链首页</a></span>
     <span> <?php echo $lang['nc_hello'];?>:&nbsp;<a href="<?php echo urlShop('member_snsindex');?>"><?php echo $_SESSION['member_name'];?></a></span>
     <span>[<a href="<?php echo urlShop('login','logout');?>"><?php echo $lang['nc_logout'];?></a>]</span>
    <?php }else{?>
     	<span> <a href="<?php echo SHOP_SITE_URL;?>" title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>">海分宝供应链首页</a></span>
        <span><a href="<?php echo urlShop('login');?>"><?php echo $lang['nc_login'];?></a></span>
        <span><a href="<?php echo urlShop('login','register');?>"><?php echo $lang['nc_register'];?></a></span>
    <?php }?>
	

	<span><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_snsindex" class="arrow">管理中心</a></span>	
	<span><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_sell_order&op=index">销售发货</a> </span>  
   
	<span> <a href="<?php echo SHOP_SITE_URL;?>/index.php?act=cart" title="购物车"><i class="ico"></i>购物车 
		<?php if (($output['cart_goods_num'] > 0)|| intval(cookie('cart_goods_num') >=0)){
		  		if($output['cart_goods_num'] > 0)$cart_goods_num=$output['cart_goods_num'];
				else $cart_goods_num=cookie('cart_goods_num');
		 ?>
       	 <label class="c-brand"><?php echo $cart_goods_num;?></label>
        <?php }else{ ?>	
	<label class="c-brand">0</label></a></span>	
	  <?php } ?>	
	
	<span><a href="<?php echo SHOP_SITE_URL;?>/index.php">手机版</a> </span>
	<span><a href="<?php echo urlShop('article', 'article', array('ac_id' => 2));?>">帮助中心</a></span>
		
    </div>
  
  </div>
</div>
<script type="text/javascript">
$(function(){
	$(".quick-menu dl").hover(function() {
		$(this).addClass("hover");
	},
	function() {
		$(this).removeClass("hover");
	});

});
</script>
