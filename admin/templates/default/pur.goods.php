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
    <div class="trace">
        <a href="index.php?act=pur&op=add&form=goods" class="btn-add" style="margin-top:5px; float:none;">添加商品</a>
    </div>
    <table class="table tb-type2" id="goods_list">
        <tr>
            <th>商品名</th>
            <th>日文名称</th>
            <th>客服</th>
            <th>库存</th>
            <th>添加时间</th>
            <th>状态</th>
        </tr>
        <?php if($output['list']){ foreach ($output['list'] as $v) { ?>
        <tr>
            <td data-attr="goods_name" data-id="<?php echo $v['id']; ?>"><p><?php echo $v['goods_name']; ?></p></td>
            <td data-attr="jap_name" data-id="<?php echo $v['id']; ?>"><p><?php echo $v['jap_name']; ?></p></td>
            <td><?php echo $v['author']; ?></td>
            <td><?php echo $v['store_num']; ?></td>
            <td>
                <?php echo date('Y-m-d H:i', $v['addtime']); ?>
            </td>
            <td data-attr="goods_status" data-id="<?php echo $v['id']; ?>" data-value="<?php echo $v['status']; ?>">
                <p><?php if($v['status']==1) echo '启用'; else echo '未启用'; ?></p>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="5" ><label class="validation">修改请直接双击</label></td>
        </tr>
        <tr>
            <td colspan="5">
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
            if($(this).attr('data-attr')=='goods_status'){
                var html = '<select name="'+$(this).attr('data-attr')+'"><option value="0" '+($(this).attr('data-attr') === '0' ? 'selected' : '')+'>未启用</option><option value="1" '+($(this).attr('data-attr') === '1' ? 'selected' : '')+'>启用中</option></select>';
            }else{
                var html = '<input type="text" name="'+$(this).attr('data-attr')+'" value="'+val+'"/>';
            }
            $(this).html(html);
            $('input[name="'+$(this).attr('data-attr')+'"]').focus();
            animate = true;
        }
    });
    $('input[name="goods_name"]').live('blur', function(){
        var id  = $(this).parent('td').attr('data-id');
        var html = '<p>'+$(this).val()+'</p>';
        $.post('index.php?act=pur&op=update',{'form':'goods','id':id, 'goods_name': $(this).val()}, function(data){
            if(data.status == 1){
                $('input[name="goods_name"]').parent('td').html(html);
                animate = false;
            }else{
                alert(data.msg);
            }
        },'json');
    });
    $('input[name="jap_name"]').live('blur', function(){
        var id  = $(this).parent('td').attr('data-id');
        var html = '<p>'+$(this).val()+'</p>';
        $.post('index.php?act=pur&op=update',{'form':'goods','id':id, 'jap_name': $(this).val()}, function(data){
            if(data.status == 1){
                $('input[name="jap_name"]').parent('td').html(html);
                animate = false;
            }else{
                alert(data.msg);
            }
            
        },'json');
    });
    $('select[name="goods_status"]').live('change', function(){
        var id  = $(this).parent('td').attr('data-id');
        var html = '<p>'+$(this).find('option:selected').text()+'</p>';
        $.post('index.php?act=pur&op=update',{'form':'goods','id':id, 'status': $(this).val()}, function(data){
            if(data.status == 1){
                $('select[name="goods_status"]').parent('td').html(html);
                animate = false;
            }else{
                alert(data.msg);
            }
        },'json');
    });
    $('select[name="goods_status"]').live('blur', function(){
        var html = '<p>'+$(this).find('option:selected').text()+'</p>';
        $('select[name="goods_status"]').parent('td').html(html);
        animate = false;
    });
});
</script>