<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<div class="page">
    <table class="table tb-type2">
        <tr>
            <th>
                日期
            </th>
            <th>
                汇率
            </th>
            <th>
                更新客服
            </th>
            <th>
                更新时间
            </th>
        </tr>
        <tr>
            <td>
                <?php echo date('Y-m-d');?>
            </td>
            <td colspan="3" style="color:red;">
                <?php echo $output['rate'];?>
            </td>
        </tr>
        <tr>
            <td><?php echo date('Y-m-d');?></td>
            <td id="edit_td" data-id="<?php echo $output['today_rate']['id'];?>" title="双击进入编辑"><?php echo $output['today_rate']['rate'];?></td>
            <td><?php echo $output['today_rate']['editor_name'];?></td>
            <td><?php if($output['today_rate']['updatetime']) echo date('Y-m-d H:i', $output['today_rate']['updatetime']);?></td>
        </tr>
        <?php foreach ($output['data'] as $v) { ?>
        <tr>
            <td>
                <?php echo date('Y-m-d', $v['addtime']);?>
            </td>
            <td>
                <?php echo $v['rate'];?>
            </td>
            <td>
                <?php echo $v['editor_name'];?>
            </td>
            <td>
                <?php if($v['updatetime']) echo date('Y-m-d H:i', $v['updatetime']);?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="4"><button id="getstore">提取今日汇率</button></td>
        </tr>        
    </table>
</div>
<script type="text/javascript">
$(function(){
    $("#getstore").click(function(){
        $.get('index.php?act=exchange_rate&op=store', function(str){ 
            alert(str);
            window.location.reload();
        })
    });
    $("#edit_td").dblclick(function(){
        $(this).html('<input type="text" id="today_rate" value="'+$(this).html()+'"/>');
    });
    $("#today_rate").live('blur', function(){
        $.post('index.php?act=exchange_rate&op=update',{'id':$(this).parent('td').attr('data-id'),'rate': $(this).val()}, function(str){
            alert(str);
            window.location.reload();
        });
    });
});
</script>