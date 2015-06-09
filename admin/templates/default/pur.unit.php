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
                <li><a href="index.php?act=pur&op=add" <?php if($_GET['op']=='add') echo 'class="current"';?>><span>采购申请</span></a></li>
                <li><a href="index.php?act=pur&op=goods" <?php if($_GET['op']=='goods') echo 'class="current"';?>><span>商品管理</span></a></li>
                <li><a href="index.php?act=pur&op=suppliers" <?php if($_GET['op']=='suppliers') echo 'class="current"';?>><span>供货商管理</span></a></li>
                <li><a href="index.php?act=pur&op=spec" <?php if($_GET['op']=='spec') echo 'class="current"';?>><span>规格管理</span></a></li>
            </ul>
        </div>
    </div> 
    <div class="fixed-empty"></div>
    <table class="table tb-type2" id="goods_list">
        <tr>
            <th>单位</th>
            <!-- <th>操作</th> -->
        </tr>
        <?php if($output['list']){ foreach ($output['list'] as $v) { ?>
        <tr>
            <td data-attr="spec_name" data-id="<?php echo $v['id']; ?>"><p><?php echo $v['name']; ?></p></td>
            <!-- <td>
                <a href="">删除</a>
            </td> -->
        </tr>
        <?php } ?>
        <tr>
            <td><label class="validation">修改请直接双击</label></td>
        </tr>
        <tr>
            <td>
                <div class="pagination">
                    <?php echo $output['show_page']; ?>
                </div>
            </td>
        </tr>
        <?php }else { ?>
        <tr>
            <td colspan="14">没有数据</td>
        </tr>
        <?php } ?>
    </table>
</div>
<script type="text/javascript">
$(function(){
    var animate = false;
    $("#goods_list td[data-attr]").dblclick(function(){
        if(!animate){
            var val = $(this).children('p').html();
            var html = '<input type="text" name="'+$(this).attr('data-attr')+'" value="'+val+'"/>';
            $(this).html(html);
            $('input[name="'+$(this).attr('data-attr')+'"]').focus();
            animate = true;
        }
    });
    $('input[name="spec_name"]').live('blur', function(){
        var id  = $(this).parent('td').attr('data-id');
        var html = '<p>'+$(this).val()+'</p>';
        $.post('index.php?act=pur&op=update',{'form':'spec','id':id, 'name': $(this).val()}, function(data){
            if(data.status == 1){
                $('input[name="spec_name"]').parent('td').html(html);
                animate = false;
            }else{
                alert(data.msg);
            }
            
        },'json');
    });
    $('input[name="link_user"]').live('blur', function(){
        var id  = $(this).parent('td').attr('data-id');
        var html = '<p>'+$(this).val()+'</p>';
        $.post('index.php?act=pur&op=update',{'form':'suppliers','id':id, 'link_user': $(this).val()}, function(data){
            if(data.status == 1){
                $('input[name="link_user"]').parent('td').html(html);
                animate = false;
            }else{
                alert(data.msg);
            }
            
        },'json');
    });
    $('input[name="link_tel"]').live('blur', function(){
        var id  = $(this).parent('td').attr('data-id');
        var html = '<p>'+$(this).val()+'</p>';
        $.post('index.php?act=pur&op=update',{'form':'suppliers','id':id, 'link_tel': $(this).val()}, function(data){
            if(data.status == 1){
                $('input[name="link_tel"]').parent('td').html(html);
                animate = false;
            }else{
                alert(data.msg);
            }
            
        },'json');
    });
});
</script>