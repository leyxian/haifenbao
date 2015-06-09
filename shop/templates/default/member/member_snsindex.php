<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<link type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jcarousel/skins/tango/skin.css" rel="stylesheet" >
<style type="text/css">
.path {
	display: none;
}
.fd-media .goodsinfo dt {
	width: 300px;
}
</style>
<div class="wrap"> 
  <p></p>
  <p>   <?php echo $output['member_info']['member_name']; ?>，欢迎您回来!<BR />   <BR />    
    <dd class="seller-last-login">您的上一次登录时间：<strong><?php echo $_SESSION['member_old_login_time'];?></strong></dd> 
    您的账户 余额:<span class="price ml5 mr5"><?php echo $output['member_info']['available_predeposit'];?></span><?php echo $lang['currency_zh'];?><i></i>  <BR />   
	

  </p>
  <div class="clear"></div>
</div>