<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT_PATH;?>/shop/templates/default/css/seller_center.css"  />

<div class="page">
 <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_transport_manage'];?></h3>
      <?php //echo $output['top_link'];?>
      <ul class="tab-base">
<!--        <li><a href="JavaScript:void(0);" class="current"><span><?php ///echo $lang['nc_tran_manage'];?></span></a></li>-->
		<li><a href="<?php echo urlShop('store_order', 'index');?>"><span><?php echo $lang['nc_tran_manage'];?></span></a></li>
		<li><a href="<?php echo urlShop('store_deliver', 'index');?>"><span><?php echo $lang['nc_member_path_deliver'];?></span></a></li>		
        <li><a href="<?php echo urlShop('store_deliver_set', 'daddress_list');?>" ><span><?php echo $lang['nc_member_path_daddress'];?></span></a></li>
      </ul>	  
	  
    </div>
  </div> 
    <div class="fixed-empty"></div>  

  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['order_help1'];?></li>
            <li><?php echo $lang['order_help2'];?></li>
            <li><?php echo $lang['order_help3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
<BR />


  
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
    $('#query_end_date').datepicker({dateFormat: 'yy-mm-dd'});
    $('.checkall_s').click(function(){
        var if_check = $(this).attr('checked');
        $('.checkitem').each(function(){
            if(!this.disabled)
            {
                $(this).attr('checked', if_check);
            }
        });
        $('.checkall_s').attr('checked', if_check);
    });
});
</script>
