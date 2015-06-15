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
                <li><a href="javascript:" class="current"><span>众筹列表</span></a></li>
                <li><a href="index.php?act=crowd&op=add"><span>添加</span></a></li>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <table class="table tab-style2">
        <tr>
            <th colspan="2">
                商品
            </th>
            <th>
                采购成本
            </th>
            <th>
                打包费
            </th>
            <th>
                日本运费
            </th>
            <th>国际物流费</th>
            <th>
                开始时间
            </th>
            <th>结束时间</th>
            <th>数量</th>
            <th>添加人</th>
            <th>添加时间</th>
            <th>更新人</th>
            <th>更新时间</th>
            <th>操作</th>
        </tr>
        <?php if($output['list']) {foreach ($output['list'] as $v) { ?>
        <tr>
            <td class="w60 picture"><div class="size-56x56"><span class="thumb size-56x56"><i></i><img src="<?php echo thumb($v['goods_common'], 60);?>" onload="javascript:DrawImage(this,56,56);"/></span></div></td>
            <td class="goods-name w270"><p><span><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $output['storage_array'][$v['goods_common']['goods_commonid']]['goods_id']));?>" target="_blank"><?php echo $v['goods_name'];?></a></span></p>
            <td><?php echo $v['cost_free']; ?></td>
            <td><?php echo $v['pack_free']; ?></td>
            <td><?php echo $v['freight_free']; ?></td>
            <td><?php echo $v['internation_free']; ?></td>
            <td><?php if($v['start_time']){ echo date('Y-m-d' ,$v['start_time']); } ?></td>
            <td><?php if($v['end_time']){ echo date('Y-m-d' ,$v['end_time']); } ?></td>
            <td><?php echo $v['store_num']; ?></td>
            <td><?php echo $v['add_user']; ?></td>
            <td><?php if($v['addtime']){ echo date('Y-m-d' ,$v['addtime']); } ?></td>
            <td><?php echo $v['update_user']; ?></td>
            <td><?php if($v['update_time']){ echo date('Y-m-d' ,$v['update_time']); } ?></td>
            <td>
                <a href="index.php?act=crowd&op=edit&id=<?php echo $v['id']; ?>">编辑</a>
            </td>
        </tr>
        <?php } ?> 
        <tr>
            <td colspan="14">
            <div class="pagination"> <?php echo $output['page'];?> </div>
            </td>
        </tr>
        <?php }else{ ?>
        <tr>
            <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
    </table>
</div>