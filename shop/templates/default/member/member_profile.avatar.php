<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.Jcrop/jquery.Jcrop.js"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.Jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" id="cssfile2" />
<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <?php if ($output['newfile'] == ''){?>
  
  <?php }else{?>
  
  <form action="index.php?act=home&op=cut" id="form_cut" method="post">
  
  </form>
  <?php }?>
</div>
