<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo ($lang['nc_member_path_'.$output['menu_sign']]==''?'':$lang['nc_member_path_'.$output['menu_sign']].'_').$output['html_title'];?></title>
<meta name="keywords" content="<?php echo C('site_keywords'); ?>" />
<meta name="description" content="<?php echo C('site_description'); ?>" />
<meta name="author" content="中擎Mrwang">
<meta name="copyright" content="ZQ-Tech Inc. All Rights Reserved">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/member.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_login.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_header.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />


<!--[if IE 6]><style type="text/css">
body {_behavior: url(<?php echo SHOP_TEMPLATES_URL;?>/css/csshover.htc);}
</style>
<![endif]-->
<script>
var COOKIE_PRE = '<?php echo COOKIE_PRE;?>';var _CHARSET = '<?php echo strtolower(CHARSET);?>';var SITEURL = '<?php echo SHOP_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';
</script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/member.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/nc-sideMenu.js" charset="utf-8"></script>
<!--<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/qtip/jquery.qtip.min.js"></script>-->

<script type="text/javascript">
$(function(){
    $('#formSearch').find('input[type="submit"]').click(function(){
    	if ($('#keyword').val() == '') {
    		return false;
    	}
    	$('#formSearch').submit();
    });
});
</script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/html5shiv.js"></script>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/respond.min.js"></script>
<![endif]-->
<!--[if IE 6]>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/IE6_PNG.js"></script>
<script>
DD_belatedPNG.fix('.pngFix');
</script>
<script> 
// <![CDATA[ 
if((window.navigator.appName.toUpperCase().indexOf("MICROSOFT")>=0)&&(document.execCommand)) 
try{ 
document.execCommand("BackgroundImageCache", false, true); 
   } 
catch(e){} 
// ]]> 
</script> 
<![endif]-->

</head>
<body>
<?php require_once template('layout/layout_top');?>
 <!-- PublicHeadLayout Begin -->

<div class="header-wrap">
  <header class="public-head-layout wrapper">
    <h1 class="site-logo"><a href="<?php echo SHOP_SITE_URL;?>"><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.$GLOBALS['setting_config']['site_logo']; ?>" class="pngFix"></a></h1>
    <div class="head-search-bar">
      <form action="<?php echo SHOP_SITE_URL;?>" method="get" class="search-form">
        <input name="act" id="search_act" value="search" type="hidden">
        <input name="keyword" id="keyword" type="text" class="input-text" value="<?php echo $_GET['keyword'];?>" maxlength="60" x-webkit-speech lang="zh-CN" onwebkitspeechchange="foo()" placeholder="请输入您要搜索的商品关键字" x-webkit-grammar="builtin:search" />
        <input type="submit" id="button" value="<?php echo $lang['nc_common_search'];?>" class="input-submit">
      </form>
      <div class="keyword"><?php echo $lang['hot_search'].$lang['nc_colon'];?>
        <ul>
          <?php if(is_array($output['hot_search']) && !empty($output['hot_search'])) { foreach($output['hot_search'] as $val) { ?>
          <li><a href="<?php echo urlShop('search', 'index', array('keyword' => $val));?>"><?php echo $val; ?></a></li>
          <?php } }?>
        </ul>
      </div>
    </div>
 
  </header>
</div>
<!-- PublicHeadLayout End -->
<!-- publicNavLayout Begin -->
<nav class="public-nav-layout">
  <div class="wrapper">
    <div class="all-category"><!-- 商品分类开始 Begin -->
        <?php require template('layout/home_goods_class');?>
    </div><!-- 商品分类END-->
    <ul class="site-menu"><!-- 首页导行菜单开始 Begin -->
      <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_order">我的采购单</a></li>
	  <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_order&state_type=state_pay">我的微仓</a></li>
	  <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_sell_order&op=index"><?php echo $lang['nc_member_sellOrder_manage']; ?></a></li>	  
	  <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_snsindex">管理中心</a></li>		  
      <li><a href="<?php echo urlShop('brand', 'index');?>" <?php if($output['index_sign'] == 'brand' && $output['index_sign'] != '0') {echo 'class="current"';} ?>> <?php echo $lang['nc_brand'];?></a></li>
	  <li><a href="http://www.transportjp.com" target="_blank">微商城</a></li>
  
    </ul>
	<!-- 首页导行菜单 End-->
  </div>
</nav>
<!-- PublicNavLayout End-->
<div id="container" class="wrapper">
<ul style="padding-top:36px; padding-bottom:6px;">
          <label>当前位置: <a href="index.php?act=index.php&op=index">首页</a>&nbsp; &gt;&nbsp; </label>
          <a href="index.php?act=member_snsindex"><?php echo $lang['nc_user_center'];?></a><span> &nbsp; &gt;&nbsp; </span>
          <?php if($output['menu_sign_url'] != '' and $lang['nc_member_path_'.$output['menu_sign1']] != ''){?>
          <a href="<?php echo $output['menu_sign_url'];?>"/>          
          <?php }?>
          <?php echo $lang['nc_member_path_'.$output['menu_sign']];?>
          <?php if($output['menu_sign_url'] != '' and $lang['nc_member_path_'.$output['menu_sign1']] != ''){?>
          </a><span>&nbsp; &gt;&nbsp;</span><?php echo $lang['nc_member_path_'.$output['menu_sign1']];?>
          <?php }?>
          
        </ul>
  <div class="layout">
    <div class="sidebar"> 

<div class="business-intro">  
        <h3><a href="<?php echo urlShop('home', 'member');?>"><?php echo $lang['nc_member_path_profile'];?></a></h3>
      </div>	
	
      <div class="business-intro">  
        <h3><a href="index.php?act=member_order&state_type"><?php echo $lang['nc_tradeinfo'];?></a></h3>
      </div>
	  
<div class="business-intro">  
     <!--   <h3><a href="<?php //echo urlShop('member_sell_order', 'store');?>"><?php //echo $lang['nc_member_store_manage'];?></a></h3>-->
			  <h3><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_order&state_type=state_pay">我的微仓</a></h3>
      </div>	  

<div class="business-intro">  
        <h3><a href="<?php echo urlShop('member_sell_order', 'index');?>"><?php echo $lang['nc_member_sellOrder_manage'];?></a></h3>       
      </div>	
	  
<div class="business-intro">  
        <h3><a href="index.php?act=member_favorites&op=fglist"><?php echo $lang['nc_favorites'];?></a></h3>
      </div>

<!--<div class="business-intro">  
        <h3><a href="index.php?act=member_favorites&op=fglist"><?php //echo $lang['nc_member_massage_manage'];?></a></h3>
      </div>-->	  
	  	    
<div class="business-intro">  
        <h3><a href="index.php?act=member_shortstock&op=list"><?php echo $lang['nc_member_shortStock_manage'];?></a></h3>
      </div>       
    </div>
    <div class="right-content">
      
      <div class="main">
        <?php
		require_once($tpl_file);
		?>
      </div>
    </div>
  </div>
</div>
<?php require_once template('footer'); ?>
</body>
</html>
