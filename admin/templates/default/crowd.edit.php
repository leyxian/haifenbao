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
                <li><a href="index.php?act=crowd&op=add"><span>添加</span></a></li>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form action="index.php?act=crowd&op=update" name="edit_form" id="edit_form" method="POST">
        <table class="table tb-type2 nobdb">
            <tr>
                <td colspan="2"><label>商品</label></td>
            </tr>
            <tr>
                <td>
                    <img style="float: left; margin-right:5px; " src="<?php echo thumb($output['goods'], 60);?>">
                    <?php echo $output['goods']['goods_name'];?><br/><br/>
                    <?php echo $output['goods']['store_name'];?>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">采购成本</label></td>
            </tr>
            <tr>
                <td>
                    <input name="cost_free" id="cost_free" type="number" min="1" value="<?php echo $output['crowd']['cost_free']; ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">打包费</label></td>
            </tr>
            <tr>
                <td>
                    <input name="pack_free" id="pack_free" type="number" min="1" value="<?php echo $output['crowd']['pack_free']; ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">日本运费</label></td>
            </tr>
            <tr>
                <td>
                    <input name="freight_free" id="freight_free" type="number" min="1" value="<?php echo $output['crowd']['freight_free']; ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">国际物流费</label></td>
            </tr>
            <tr>
                <td>
                    <input name="internation_free" id="internation_free" type="number" min="1" value="<?php echo $output['crowd']['internation_free']; ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">认筹数量</label></td>
            </tr>
            <tr>
                <td>
                    <input name="store_num" id="store_num" type="number" min="1" value="<?php echo $output['crowd']['store_num']; ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">开始日期</label></td>
            </tr>
            <tr>
                <td>
                    <input name="start_time" id="start_time" type="date" min="1" value="<?php if($output['crowd']['start_time']){ echo date('Y-m-d', $output['crowd']['start_time']); }?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">结束日期</label></td>
            </tr>
            <tr>
                <td>
                    <input name="end_time" id="end_time" type="date" min="1" value="<?php if($output['crowd']['end_time']){ echo date('Y-m-d', $output['crowd']['end_time']); }?>"/>
                </td>
            </tr>
            <tr>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>
                <td colspan="2"><a href="javascript:" class="btn" id="edit_submit"><span>提交</span></a></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('input[type="date"]').datepicker({dateFormat: 'yy-mm-dd'});
    $('#edit_submit').click(function(){
        if($("#edit_form").valid()){
            $("#edit_form").submit();
        }
    });
    $('#edit_form').validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            cost_free : {
                required   : true,
            },
            pack_free : {
                required   : true
            },
            freight_free : {
                required : true
            },
            internation_free : {
                required   : true
            },
            store_num : {
                required   : true
            },
            start_time : {
                required   : true
            },
            end_time : {
                required   : true
            },
        },
        messages : {
            cost_free : {
                required   : '采购成本不能为空'
            },
            pack_free : {
                required   : '打包费不能为空'
            },
            freight_free : {
                url : '日本运费不能为空'
            },
            internation_free : {
                required   : '国际物流费不能为空'
            },
            start_time  : {
                number   : '开始日期不能为空'
            },
            end_time  : {
                number   : '结束日期不能为空'
            }
        }
    });
});
</script>