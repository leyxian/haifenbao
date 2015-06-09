<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<style type="text/css">
dl dd span {
	display: inline-block;
}
</style>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <div class="ncu-form-style">
    <form method="post" id="profile_form" action="index.php?act=home&op=member">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="old_member_avatar" value="<?php echo $output['member_info']['member_avatar']; ?>" />
      <dl>
         <span style="padding-left:15px; padding-right:20px;">您的资料信息请尽量填写完整。当您的订单信息有误、出现售后等问题，或者本站有优惠活动时，方便客户人员及时联系到您。您的资料信息保证不被外泄，仅供本站沟通联系使用。</span>
      </dl>
      <dl>	  
	  
      <dl>
        <dt><?php echo $lang['home_member_username'].$lang['nc_colon'];?></dt>
        <dd><span class="w340"><?php echo $output['member_info']['member_name']; ?></span></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['home_member_email'].$lang['nc_colon'];?></dt>
        <dd><span class="w340"><?php echo $output['member_info']['member_email']; ?></span></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['home_member_truename'].$lang['nc_colon'];?></dt>
        <dd><span class="w340">
          <input type="text" class="text" maxlength="20" name="member_truename" value="<?php echo $output['member_info']['member_truename']; ?>" />
          </span></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['home_member_sex'].$lang['nc_colon'];?></dt>
        <dd><span class="w340">
          <label>
            <input type="radio" name="member_sex" value="3" <?php if($output['member_info']['member_sex']==3 or ($output['member_info']['member_sex']!=2 and $output['member_info']['member_sex']!=1)) { ?>checked="checked"<?php } ?> />
            <?php echo $lang['home_member_secret'];?></label>
          &nbsp;&nbsp;
          <label>
            <input type="radio" name="member_sex" value="2" <?php if($output['member_info']['member_sex']==2) { ?>checked="checked"<?php } ?> />
            <?php echo $lang['home_member_female'];?></label>
          &nbsp;&nbsp;
          <label>
            <input type="radio" name="member_sex" value="1" <?php if($output['member_info']['member_sex']==1) { ?>checked="checked"<?php } ?> />
            <?php echo $lang['home_member_male'];?></label>
          </span></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['home_member_birthday'].$lang['nc_colon'];?></dt>
        <dd><span class="w340">
          <input type="text" class="text" name="birthday" maxlength="10" id="birthday" value="<?php echo $output['member_info']['member_birthday']; ?>" />
          </span></dd>
      </dl>
      <dl>
        <dt>QQ<?php echo $lang['nc_colon'];?></dt>
        <dd><span class="w340">
          <input type="text" class="text" maxlength="30" name="member_qq" value="<?php echo $output['member_info']['member_qq']; ?>" />
          </span></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['member_edit_weixin'].$lang['nc_colon'];?></dt>
        <dd><span class="w340">
          <input name="member_ww" type="text" class="text" maxlength="50" id="member_ww" value="<?php echo $output['member_info']['member_ww'];?>" />
          </span></dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['home_member_save_modify'];?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript">
//注册表单验证
$(function(){
	regionInit("region");
	$('#birthday').datepicker({dateFormat: 'yy-mm-dd'});
    $('#profile_form').validate({
    	submitHandler:function(form){
    		if ($('select[class="valid"]').eq(0).val()>0) $('#province_id').val($('select[class="valid"]').eq(0).val());
			if ($('select[class="valid"]').eq(1).val()>0) $('#city_id').val($('select[class="valid"]').eq(1).val());
			ajaxpost('profile_form', '', '', 'onerror')
		},
        rules : {
            member_truename : {
				minlength : 2,
                maxlength : 20
            },
            member_qq : {
				digits  : true,
                minlength : 5,
                maxlength : 12
            }
        },
        messages : {
            member_truename : {
				minlength : '<?php echo $lang['home_member_username_range'];?>',
                maxlength : '<?php echo $lang['home_member_username_range'];?>'
            },
            member_qq  : {
				digits    : '<?php echo $lang['home_member_input_qq'];?>',
                minlength : '<?php echo $lang['home_member_input_qq'];?>',
                maxlength : '<?php echo $lang['home_member_input_qq'];?>'
            }
        }
    });
});
</script> 
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>