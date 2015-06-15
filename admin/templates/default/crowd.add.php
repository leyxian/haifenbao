<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>众筹</h3>
            <ul class="tab-base">
                <li><a href="index.php?act=crowd"><span>众筹列表</span></a></li>
                <li><a href="javascrip:" class="current"><span>添加</span></a></li>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="crowd">
    <input type="hidden" name="op" value="add">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_goods_name"> <?php echo $lang['goods_index_name'];?></label></th>
          <td><input type="text" value="<?php echo $output['search']['search_goods_name'];?>" name="search_goods_name" id="search_goods_name" class="txt"></td>          
          <th>&nbsp;&nbsp;<label><?php echo $lang['goods_index_class_name'];?></label></th>
          <td id="gcategory" colspan="8"><input type="hidden" id="cate_id" name="cate_id" value="" class="mls_id" />
            <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
            <select class="querySelect">
              <option>请选择...</option>
              <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])){ ?>
              <?php foreach($output['goods_class'] as $val) { ?>
              <option value="<?php echo $val['gc_id']; ?>" <?php if($output['search']['cate_id'] == $val['gc_id']){?>selected<?php }?>><?php echo $val['gc_name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <th>&nbsp;&nbsp;<label><?php echo $lang['goods_index_brand'];?></label></th>
          <td><select name="search_brand_id">
              <option value="">请选择...</option>
              <?php if(!empty($output['brand_list']) && is_array($output['brand_list'])){ ?>
              <?php foreach($output['brand_list'] as $k => $v){ ?>
              <option value="<?php echo $v['brand_id'];?>" <?php if($output['search']['search_brand_id'] == $v['brand_id']){?>selected<?php }?>><?php echo $v['brand_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
             <td ><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
          <td class="w120">&nbsp;</td>         
        </tr>
        <tr>
        <!--   <th><label for="search_store_name"><?php //echo $lang['goods_index_store_name'];?></label></th>
          <td><input type="text" value="<?php //echo $output['search']['search_store_name'];?>" name="search_store_name" id="search_store_name" class="txt"></td>--> 
        </tr>
      </tbody>
    </table>
  </form>
    <form action="index.php?act=crowd&op=store" method="post" id="store_form" name="store_form">
        <table class="table tb-type2">
            <tr>
                <th colspan="3">商品</th>
                <th>库存</th>
                <th>采购成本</th>
                <th>打包费</th>
                <th>日本运费</th>
                <th>国际物流费</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>数量</th>
            </tr>
            <?php if (!empty($output['goods_list']) && is_array($output['goods_list'])) { ?>
            <?php foreach ($output['goods_list'] as $k => $v) {?>
            <tr>
            <td><input type="checkbox" name="id[]" value="<?php echo $v['goods_commonid'];?>" class="checkitem"></td>
            <td class="w60 picture"><div class="size-56x56"><span class="thumb size-56x56"><i></i><img src="<?php echo thumb($v, 60);?>" onload="javascript:DrawImage(this,56,56);"/></span></div></td>
            <td class="goods-name w270"><p><span><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $output['storage_array'][$v['goods_commonid']]['goods_id']));?>" target="_blank"><?php echo $v['goods_name'];?></a></span></p>
            <p class="store"><?php echo $lang['goods_index_store_name'];?>:<?php echo $v['store_name'];?></p></td>
            <td><?php echo $output['storage_array'][$v['goods_commonid']]['sum']?></td>
            <td>
                <input class="w60" type="number" name="cost_<?php echo $v['goods_commonid'];?>" min="1" value="" />
            </td>
            <td>
                <input class="w60" type="number" name="pack_<?php echo $v['goods_commonid'];?>" min="1" value=""/>
            </td>
            <td>
                <input class="w60" type="number" name="freight_<?php echo $v['goods_commonid'];?>" min="1" value=""/>
            </td>
            <td>
                <input class="w60" type="number" name="internation_<?php echo $v['goods_commonid'];?>" min="1" value=""/>
            </td>
            <td>
                <input class="w120" type="date" name="start_<?php echo $v['goods_commonid'];?>" value=""/>
            </td>
            <td>
                <input class="w120" type="date" name="end_<?php echo $v['goods_commonid'];?>" value=""/>
            </td>
            <td>
                <input class="w60" type="number" name="num_<?php echo $v['goods_commonid'];?>" min="1" value=""/>
            </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr class="no_data">
              <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
            </tr>
            <?php } ?>
            <tr>
                <td><label><input type="checkbox" class="checkall" id="checkallBottom">全选</label></td>
                <td colspan="10"><div class="pagination"> <?php echo $output['page'];?> </div></td>
            </tr>
        </table>
    </form>
    <a class="btn" style="position: fixed; right:5px; top:15%;" href="javascript:" id="store_submit"><span>提交</span></a></div>
    
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
    $('input[type="date"]').datepicker({dateFormat: 'yy-mm-dd'});
    gcategoryInit("gcategory");
    $('#ncsubmit').click(function(){
        $('#formSearch').submit();
    });
    $('#store_submit').click(function(){
        $.post('index.php?act=crowd&op=store', $('#store_form').serialize(), function(data){
            if(data.status == 1){
                alert('添加成功');
                window.location.reload();
            }else{
                alert(data.msg);
            }
        }, 'json');
    });
});
</script>