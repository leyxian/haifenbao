<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>仓库</h3>
            <ul class="tab-base">
                <li><a href="index.php?act=pur" <?php if($_GET['op']=='' || $_GET['op']=='index') echo 'class="current"';?>><span>采购列表</span></a></li>
                <li><a href="index.php?act=pur&op=instore" <?php if($_GET['op']=='instore') echo 'class="current"';?>><span>入库列表</span></a></li>
                <li><a href="index.php?act=pur&op=outstore" <?php if($_GET['op']=='outstore') echo 'class="current"';?>><span>出库列表</span></a></li>
                <li><a href="index.php?act=pur&op=add" <?php if($_GET['op']=='add' && !$_GET['form']) echo 'class="current"';?>><span>采购申请</span></a></li>
                <li><a href="index.php?act=pur&op=goods" <?php if($_GET['op']=='goods') echo 'class="current"';?>><span>商品管理</span></a></li>
                <li><a href="index.php?act=pur&op=suppliers" <?php if($_GET['op']=='suppliers') echo 'class="current"';?>><span>供货商管理</span></a></li>
                <li><a href="index.php?act=pur&op=spec" <?php if($_GET['op']=='spec') echo 'class="current"';?>><span>规格管理</span></a></li>
            </ul>
        </div>
    </div> 
    <div class="fixed-empty"></div>
    <form action="index.php?act=pur&op=store" method="post" name="goods_form">
        <table class="table tb-type2">
            <tr>
                <td colspan="2">
                    <label class="validation">商品名称</label>
                </td>
            </tr>
            <tr>
                <td class="vatop">
                    <input type="text" name="goods_name" value=""/>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="validation">日文名称</label>
                </td>
            </tr>
            <tr>
                <td class="vatop">
                    <input type="text" name="jap_name" value=""/>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">
                    <input type="hidden" name="form" value="goods"/>
                    <input type="button" id="goods_submit" value="提交" />
                </td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
$(function(){
    //商品提交
    $('#goods_submit').click(function(){
        if(!$('input[name="goods_name"]').val()){
            alert('请输入商品名称');
            $('input[name="goods_name"]').focus();
            return false;
        }
        $.post('index.php?act=pur&op=store',$('form[name="goods_form"]').serialize(),function(data){
            if(data.status==1){
                alert('提交成功');
                window.location.href = 'index.php?act=pur&op=goods';
            }else{
                alert(data.msg);
            }
        },'json');
    });
});
</script>