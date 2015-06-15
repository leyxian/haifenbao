<?php
defined('ZQ-SHOP') or exit('Access Invalid!');

/**
 * 众筹模块
 */
class CrowdControl extends SystemControl {

    public function __construct(){
        parent::__construct();
    }

    public function indexOp(){
        $crowdModel = Model('crowd');
        $model_goods = Model ( 'goods' );
        $rows = $crowdModel->select();
        while(list($k, $v) = each($rows)){
            $row = $model_goods->getGoodeCommonInfo(array('gc_id'=>$v['goods_id']));
            $rows[$k]['goods_common'] = $row;
            $goods_list[] = $row;
        }
        Tpl::output('page', $crowdModel->showpage(2));
        TPL::output('list', $rows);
        $storage_array = $model_goods->calculateStorage($goods_list);
        Tpl::output('storage_array', $storage_array);
        TPL::showpage('crowd.index');
    }

    public function addOp(){
        $model_goods = Model ( 'goods' );
        $where = array();
        if ($_GET['search_goods_name'] != '') {
            $where['goods_name'] = array('like', '%' . trim($_GET['search_goods_name']) . '%');
        }
        if (intval($_GET['search_brand_id']) > 0) {
            $where['brand_id'] = intval($_GET['search_brand_id']);
        }
        if (intval($_GET['cate_id']) > 0) {
            $where['gc_id'] = intval($_GET['cate_id']);
        }
        $goods_list = $model_goods->getGoodsCommonList($where);
        Language::read('goods');
        Tpl::output('search', $_GET);
        Tpl::output('goods_list', $goods_list);
        Tpl::output('page', $model_goods->showpage(2));
        $goods_class = Model('goods_class')->getTreeClassList ( 1 );
        Tpl::output('goods_class', $goods_class);
        $brand_list = Model('brand')->getBrandList ( $condition );
        Tpl::output('brand_list', $brand_list);
        $storage_array = $model_goods->calculateStorage($goods_list);
        Tpl::output('storage_array', $storage_array);
        TPL::showpage('crowd.add');
    }

    public function editOp(){
        $id = intval($_GET['id']);
        $crowdModel = Model('crowd');
        $row = $crowdModel->find($id);
        if($row){
            $goodsModel = Model('goods');
            $goods = $goodsModel->getGoodeCommonInfo(array('gc_id'=>$row['goods_id']));
            TPL::output('goods', $goods);
            TPL::output('crowd', $row);
            TPL::showpage('crowd.edit');
        }else{
            showMessage('数据不存在', 'index.php?act=crowd');
        }
    }

    public function storeOp(){
        $ids = $_POST['id'];
        if($ids && is_array($ids)){
            $goodsModel = Model('goods');
            $crowdModel = Model('crowd');
            $admininfo = $this->getAdminInfo();
            foreach ($ids as $v) {
                $num = 0;
                if($v)
                    $goods = $goodsModel->getGoodeCommonInfo(array('goods_commonid'=>intval($v)));
                if($goods){
                    $row = $crowdModel->where('goods_id='.$goods['gc_id'].' AND end_time > '.$_SERVER['REQUEST_TIME'])->find();
                    if($row){
                        $data['status'] = 0;
                        $data['msg'] = '商品正在认筹中,'.$num.'个成功';
                    }else{
                        if($_POST['cost_'.$v] && $_POST['pack_'.$v] && $_POST['freight_'.$v] && $_POST['internation_'.$v] && $_POST['start_'.$v] && $_POST['end_'.$v] && $_POST['num_'.$v]){
                            $row['goods_id'] = $goods['gc_id'];
                            $row['goods_name'] = $goods['goods_name'];
                            $row['goods_img'] = $goods['goods_image'];
                            $row['store_num'] = intval($_POST['num_'.$v]);
                            $row['cost_free'] = round($_POST['cost_'.$v], 2);
                            $row['pack_free'] = round($_POST['pack_'.$v], 2);
                            $row['freight_free'] = round($_POST['freight_'.$v], 2);
                            $row['internation_free'] = round($_POST['internation_'.$v], 2);
                            $row['start_time'] = strtotime($_POST['start_'.$v]);
                            $row['end_time'] = strtotime($_POST['end_'.$v]);
                            $row['add_user'] = $admininfo['name'];
                            $row['addtime'] = $_SERVER['REQUEST_TIME'];
                            $crowdModel->insert($row);unset($row);
                            $data['status'] = 1;
                            $num++;
                        }else{
                            $data['status'] = 0;
                            $data['msg'] = '提交数据不全,'.$num.'个成功';
                        }
                    }
                }else{
                    $data['status'] = 0;
                    $data['msg'] = '商品不存在,'.$num.'个成功';
                    break;
                }
            }
        }else{
            $data['status'] = 0;
            $data['msg'] = '请勾选商品';
        }
        die(json_encode($data));
    }

    public function updateOp(){
        if(isset($_POST['cost_free']))
            $udate['cost_free'] = $_POST['cost_free'];
        if(isset($_POST['pack_free']))
            $udate['pack_free'] = $_POST['pack_free'];
        if(isset($_POST['freight_free']))
            $udate['freight_free'] = $_POST['freight_free'];
        if(isset($_POST['pack_free']))
            $udate['internation_free'] = $_POST['internation_free'];
        if(isset($_POST['store_num']))
            $udate['store_num'] = $_POST['store_num'];
        if(isset($_POST['start_time']))
            $udate['start_time'] = $_POST['start_time'] ? strtotime($_POST['start_time']) : 0;
        if(isset($_POST['end_time']))
            $udate['end_time'] = $_POST['end_time'] ? strtotime($_POST['end_time']) : 0;
        if(isset($_POST['pack_free']))
            $udate['pack_free'] = $_POST['pack_free'];
        $id = intval($_POST['id']);
        if($udate && $id){
            $admininfo = $this->getAdminInfo();
            $udate['id'] = $id;
            $udate['update_user'] = $admininfo['name'];
            $udate['update_time'] = $_SERVER['REQUEST_TIME'];
            $crowdModel = Model('crowd');
            $crowdModel->update($udate);
            showMessage('修改成功', 'index.php?act=crowd');
        }else{
            showMessage('提交错误', 'index.php?act=crowd');
        }
    }
}