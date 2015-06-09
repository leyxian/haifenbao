<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<style type="text/css">
    .table img { width: 140px; }
</style>
<div class="page">
    <table class="table tb-type2">
        <tr>
            <th>商品</th>
            <th>客户姓名</th>
            <th>客户号码</th>
            <th>货源价格</th>
            <th>货源链接</th>
            <th>说明信息</th>
            <th>状态</th>
            <th>发布时间</th>
            <th>更新时间</th>
        </tr>
        <?php foreach ($output['list'] as $v) { ?>
        <tr>
            <td>
                <a href=""><?php echo $v['goods']['goods_name']?></a><br/>
                ￥<?php echo $v['goods']['goods_price'];?><br/>
                <img src="<?php echo thumb($v['goods'], 'small')?>">
            </td>
            <td>
                <?php echo $v['member_truename']; ?>
            </td>
            <td>
                <?php echo '';?>
            </td>
            <td>
                ￥<?php echo $v['goods_price'];?>
            </td>
            <td>
                <?php echo $v['goods_url'];?>
            </td>
            <td>
                <?php echo $v['remark'];?>
            </td>
            <td>
                <select id="cstatus" data-id="<?php echo $v['id'];?>" >
                    <option value="0" selected>未联系</option>
                    <option value="1" <?php if($v['status']==1) echo 'selected'; ?>>联系中</option>
                    <option value="2" <?php if($v['status']==2) echo 'selected'; ?>>已联系</option>
                </select>
            </td>
            <td>
                <?php echo $v['cdate'] ? date('Y-m-d H:i', $v['cdate']): '';?>
            </td>
            <td>
                <?php echo $v['udate'] ? date('Y-m-d H:i', $v['udate']): '';?>
            </td>
        </tr>
        <?php }?>
        <tr>
            <td colspan="9">
                <div class="pagination"><?php echo $output['show_page'];?> </div></td>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
$(function(){
    $('#cstatus').change(function(){
        $.post('index.php?act=goods_source&op=update',{'status':$(this).val(),'id':$(this).attr('data-id')}, function(){
            window.location.reload();
        });
    });
});
</script>