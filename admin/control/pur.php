<?php
defined('ZQ-SHOP') or exit('Access Invalid!');
/**
 * 仓库管理
 */
class purControl extends SystemControl {

    public function __construct(){
        parent::__construct();
    }
    /**
     * [indexOp description]
     * @return [type] [description]
     */
    public function indexOp(){
        $table = Model('pur_order');
        $goods_table = Model('pur_goods');
        $table2 = Model('pur_suppliers');
        $where = '';
        if($_GET['id'])
            $where .= 'id='.$_GET['id'];
        $rows = $table->page(10)->where($where)->order('id DESC')->select();
        while(list($k, $v) = each($rows)){
            $vender = $table2->find($v['vender_id']); 
            $rows[$k]['goods'] = $goods_table->find($v['goods_id']);
            $rows[$k]['vender'] = $vender;
        }
        TPL::output('show_page', $table->showpage(2));
        TPL::output('list', $rows);
        TPL::showpage('pur.index');
    }

    public function instoreOp(){
        $table = Model('pur_instore');
        $goods_table = Model('pur_goods');
        $order_table = Model('pur_order');
        $suppliers_table = Model('pur_suppliers');
        $where = '';
        if($_GET['id'])
            $where .= 'id='.$_GET['id'];
        if($_GET['order_id'])
            $where .= ($where ? ' AND ' : '').'order_id='.$_GET['order_id'];
        $rows = $table->page(10)->where($where)->order('id DESC')->select();
        while(list($k, $v) = each($rows)){
            $rows[$k]['goods'] = $goods_table->find($v['goods_id']);
            $rows[$k]['order'] = $order_table->find($v['order_id']);
            $rows[$k]['vender'] = $suppliers_table->find($rows[$k]['vender_id']);
        }
        TPL::output('show_page', $table->showpage(2));
        TPL::output('list', $rows);
        TPL::showpage('pur.instore');
    }

    public function outstoreOp(){
        $table = Model('pur_outstore');
        $suppliers_table = Model('pur_suppliers');
        $goods_table = Model('pur_goods');
        $order_table = Model('pur_order');
        $where = '';
        if($_GET['instore_id'])
            $where .= 'instore_id='.$_GET['instore_id'];
        $rows = $table->page(10)->where($where)->order('id DESC')->select();
        while(list($k, $v) = each($rows)){
            $rows[$k]['goods'] = $goods_table->find($v['goods_id']);
            $rows[$k]['order'] = $order_table->find($v['order_id']);
            $rows[$k]['vender'] = $suppliers_table->find($rows[$k]['vender_id']);
        }
        TPL::output('show_page', $table->showpage(2));
        TPL::output('list', $rows);
        TPL::showpage('pur.outstore');
    }

    public function goodsOp(){
        $goods_table = Model('pur_goods');
        $rows = $goods_table->page(10)->order('id DESC')->select();
        TPL::output('show_page', $goods_table->showpage(2));
        TPL::output('list', $rows);
        TPL::showpage('pur.goods');
    }

    public function suppliersOp(){
        $goods_table = Model('pur_suppliers');
        $rows = $goods_table->page(10)->order('id DESC')->select();
        TPL::output('show_page', $goods_table->showpage(2));
        TPL::output('list', $rows);
        TPL::showpage('pur.suppliers');
    }

    public function specOp(){
        $goods_table = Model('pur_unit');
        $rows = $goods_table->page(10)->order('id DESC')->select();
        TPL::output('show_page', $goods_table->showpage(2));
        TPL::output('list', $rows);
        TPL::showpage('pur.unit');
    }

    public function addOp(){
        $form = $_GET['form'];
        switch ($form) {
            case 'goods':

                TPL::showpage('pur.add.goods');
                break;
            
            default:
                $goods = Model('pur_goods')->select();
                $specs = Model('pur_unit')->select();
                $venders = Model('pur_suppliers')->select();
                TPL::output('goods', $goods);
                TPL::output('specs', $specs);
                TPL::output('venders', $venders);
                TPL::showpage('pur.add');
                break;
        }
    }

    public function editOp(){
        $goods_table = Model('pur_goods');
        $goods = $goods_table->select();
        $specs = Model('pur_unit')->select();
        $venders = Model('pur_suppliers')->select();
        $order = Model('pur_order')->find($_GET['id']);
        TPL::output('goods', $goods);
        TPL::output('specs', $specs);
        TPL::output('venders', $venders);
        TPL::output('order', $order);
        TPL::showpage('pur.edit');
    }

    /**
     * [storeOp description]
     * @return [type] [description]
     */
    public function storeOp(){
        $form = $_POST['form'];
        $admininfo = $this->getAdminInfo();
        switch ($form) {
            case 'goods':   //商品
                $table = Model('pur_goods');
                $goods_name = $_POST['goods_name'];
                $jap_name = $_POST['jap_name'];
                if($goods_name){
                    if($table->where('goods_name=\''.$goods_name.'\'')->find()){
                        $data['status'] = 0;
                        $data['msg'] = '商品已存在';
                    }else{
                        $table->insert(
                            array(
                                'goods_name' => $goods_name,
                                'jap_name' => $jap_name,
                                'author' => $admininfo['name'],
                                'addtime' => $_SERVER['REQUEST_TIME'],
                                'status' => 1
                            )
                        );
                        $data['status'] = 1;
                        $data['data']['id'] = $table->getLastID();
                        $data['msg'] = '成功';
                    }
                }else{
                    $data['status'] = 0;
                    $data['msg'] = '商品名称不能为空';
                }
                die(json_encode($data));
                break;
            case 'spec':    //商品规格
                $name = $_POST['name'];
                if($name){
                    $table = Model('pur_unit');
                    if($table->where('name=\''.$name.'\'')->find()){
                        $data['status'] = 0;
                        $data['msg'] = '已存在';
                    }else{
                        $table->insert(array('name'=>$name));
                        $data['status'] = 1;
                        $data['msg'] = '成功';
                    }
                }else{
                    $data['status'] = 0;
                    $data['msg'] = '单位不能为空';
                }
                die(json_encode($data));
                break;
            case 'vender':  //供货商
                $name = $_POST['name'];
                $user = $_POST['user'];
                $tel = $_POST['tel'];
                if($name && $user && $tel){
                    $table = Model('pur_suppliers');
                    if($table->where('name=\''.$name.'\' AND link_user=\''.$user.'\' AND link_tel=\''.$tel.'\'')->find()){
                        $data['status'] = 0;
                        $data['msg'] = '已存在';
                    }else{
                        $table->insert(array('name'=>$name, 'link_user'=>$user, 'link_tel'=>$tel));
                        $data['data'] = array('id'=>$table->getLastID());
                        $data['status'] = 1;
                        $data['msg'] = '成功';
                    }
                }else{
                    $data['status'] = 0;
                    $data['msg'] = '请检查提交的值';
                }
                die(json_encode($data));
                break;
            case 'ruku':
                $id = $_POST['id'];
                $date = $_POST['date'];
                $time = $_POST['time'];
                $num = $_POST['num'];
                $location = $_POST['location'];
                if($id && $location && $date && $num > 0){
                    $row = Model('pur_order')->where('id='.$id)->find();
                    if($row){
                        if($row['store_num'] >= $row['in_num'] + $num){
                            Model('pur_instore')->insert(
                                array(
                                    'order_id' => $id,
                                    'goods_id' => $row['goods_id'],
                                    'pay_time' => strtotime($date.' '.$time),
                                    'store_num' => $num,
                                    'author' => $admininfo['name'],
                                    'location' => $location,
                                    'addtime' => $_SERVER['REQUEST_TIME']
                                )
                            );
                            Model('pur_order')->update(
                                array(
                                    'id' => $id,
                                    'in_num' => $row['in_num'] + $num
                                )
                            );
                            $pur_goods = Model('pur_goods');
                            $row = $pur_goods->field('id,store_num')->find($row['goods_id']);
                            $pur_goods->update(
                                array(
                                    'id' => $row['id'],
                                    'store_num' => $row['store_num'] + $num
                                )
                            );
                            $data['status'] = 1;
                            $data['msg'] = '成功';
                        }else{
                            $data['status'] = 0;
                            $data['msg'] = '入库数量大于总采购量';
                        }
                    }else{
                        $data['status'] = 0;
                        $data['msg'] = '入库失败，请检查';
                    }
                }else{
                    $data['status'] = 0;
                    $data['msg'] = '提交错误';
                }
                die(json_encode($data));
                break;
            case 'chuku':    //出库
                $instore_id = $_POST['id'];
                $num = $_POST['num'];
                if($instore_id && $num){
                    $row = Model('pur_instore')->where('id='.$instore_id)->find();
                    if($row){
                        if($row['store_num'] >= $row['out_num'] + $num){
                            Model('pur_outstore')->insert(
                                array(
                                    'instore_id' => $instore_id,
                                    'order_id' => $row['order_id'],
                                    'goods_id' => $row['goods_id'],
                                    'author' => $admininfo['name'],
                                    'store_num' => $num,
                                    'addtime' => $_SERVER['REQUEST_TIME']
                                )
                            );
                            Model('pur_instore')->update(
                                array(
                                    'id' => $instore_id,
                                    'out_num' => $row['out_num'] + $num
                                )
                            );
                            $goods_table = Model('pur_goods');
                            $row = $goods_table->find($row['goods_id']);
                            $goods_table->update(
                                array(
                                    'id' => $row['id'],
                                    'store_num' => $row['store_num'] - $num
                                )
                            );
                            $data['status'] = 1;
                            $data['msg'] = '成功';
                        }else{
                            $data['status'] = 0;
                            $data['msg'] = '出库数量大于库存量';
                        }
                    }else{
                        $data['status'] = 0;
                        $data['msg'] = '错误的库存';
                    }
                }else{
                    $data['status'] = 0;
                    $data['msg'] = '提交错误';
                }   
                die(json_encode($data));
                break;
            default:    //采购申请
                $goods_id = $_POST['goods_id'];
                $marque = $_POST['marque'];
                $specifications = $_POST['specifications'];
                $vender = $_POST['vender'];
                $weight = $_POST['weight'];
                $volume = $_POST['volume'];
                $jap_price = $_POST['jap_price'];
                $good_date = $_POST['good_date'];
                $good_time = $_POST['good_time'];
                $store_num = $_POST['store_num'];
                $location = $_POST['location'];
                if($_POST['pay_date']){
                    $pay_date = $_POST['pay_date'];
                    $pay_time = $_POST['pay_time'];
                }
                if($goods_id && $vender && $jap_price && $store_num){
                    Model('pur_order')->insert(
                        array(
                            'goods_id' => $goods_id,
                            'marque' => $marque,
                            'specifications' => $specifications,
                            'weight' => $weight,
                            'volume' => $volume,
                            'jap_price' => $jap_price,
                            'vender_id' => $vender,
                            'good_date' => strtotime($good_date),
                            'good_time' => strtotime($good_time),
                            'store_num' => $store_num,
                            'addtime' => $_SERVER['REQUEST_TIME'],
                            'author' => $admininfo['name'],
                            'pay_time' => $_POST['pay_date'] ? strtotime($pay_date.' '.$pay_time) : '0'
                        )
                    );
                    showMessage('提交成功', 'index.php?act=pur');
                }else{
                    showMessage('提交错误', 'index.php?act=pur&op=add');
                }
                break;
        }
    }

    public function updateOp(){
        $form = $_POST['form'];
        $id = $_POST['id'];
        $data = array();
        $admininfo = $this->getAdminInfo();
        switch ($form) {
            case 'goods':
                if($_POST['goods_name'])
                    $udata['goods_name'] = $_POST['goods_name'];
                if($_POST['jap_name'])
                    $udata['jap_name'] = $_POST['jap_name'];
                if($_POST['status'])
                    $udata['status'] = $_POST['status'];
                if($udata){
                    if($id){
                        $udata['id'] = $id;
                        Model('pur_goods')->update($udata);
                        $data['status'] = 1;
                        $data['msg'] = '成功';
                    }else{
                        $data['status'] = 0;
                        $data['msg'] = '未指定要更新的数据';
                    }
                }else{
                    $data['status'] = 0;
                    $data['msg'] = '提交错误';
                }
                break;
            
            case 'suppliers':
                if($_POST['name'])
                    $udata['name'] = $_POST['name'];
                if($_POST['link_user'])
                    $udata['link_user'] = $_POST['link_user'];
                if($_POST['link_tel'])
                    $udata['link_tel'] = $_POST['link_tel'];
                if($udata){
                    if($id){
                        $udata['id'] = $id;
                        Model('pur_suppliers')->update($udata);
                        $data['status'] = 1;
                        $data['msg'] = '成功';
                    }else{
                        $data['status'] = 0;
                        $data['msg'] = '未指定要更新的数据';
                    }
                }else{
                    $data['status'] = 0;
                    $data['msg'] = '提交错误';
                }
                break;
            case 'spec':
                if($_POST['name'])
                    $udata['name'] = $_POST['name'];
                if($udata){
                    if($id){
                        $udata['id'] = $id;
                        Model('pur_unit')->update($udata);
                        $data['status'] = 1;
                        $data['msg'] = '成功';
                    }else{
                        $data['status'] = 0;
                        $data['msg'] = '未指定要更新的数据';
                    }
                }else{
                    $data['status'] = 0;
                    $data['msg'] = '提交错误';
                }
                break;
            default:
                if($_POST['goods_id'])
                    $udata['goods_id'] = $_POST['goods_id'];
                if($_POST['marque'])
                    $udata['marque'] = $_POST['marque'];
                if($_POST['specifications'])
                    $udata['specifications'] = $_POST['specifications'];
                if($_POST['vender'])
                    $udata['vender_id'] = $_POST['vender'];
                if($_POST['weight'])
                    $udata['weight'] = $_POST['weight'];
                if($_POST['volume'])
                    $udata['volume'] = $_POST['volume'];
                if($_POST['jap_price'])
                    $udata['jap_price'] = $_POST['jap_price'];
                if($_POST['good_date'])
                    $udata['good_date'] = strtotime($_POST['good_date']);
                if($_POST['good_time'])
                    $udata['good_time'] = strtotime($_POST['good_time']);
                if($_POST['store_num'])
                    $udata['store_num'] = $_POST['store_num'];
                if($_POST['pay_date'])
                    $udata['pay_time'] = strtotime($_POST['pay_date'].' '.$_POST['pay_time']);
                if($udata){
                    if($id){
                        $udata['edit_author'] = $admininfo['name'];
                        $udata['id'] = $id;
                        $udata['updatetime'] = $_SERVER['REQUEST_TIME'];
                        Model('pur_order')->update($udata);
                        $data['status'] = 1;
                        $data['msg'] = '成功';
                    }else{
                        $data['status'] = 0;
                        $data['msg'] = '未指定要更新的数据';
                    }
                }else{
                    $data['status'] = 0;
                    $data['msg'] = '提交错误';
                }
                break;
        }
        die(json_encode($data));
    }

    function destroyOp(){
        $form = $_POST['form'];
        $id = $_POST['id'];
        switch ($form) {
            case 'value':
                # code...
                break;
            
            default:
                if($id){
                    Model('pur_order')->where(array('id'=>$id))->delete();
                    $data['status'] = 1;
                    $data['msg'] = '成功';
                }else{
                    $data['status'] = 0;
                    $data['msg'] = '提交错误';
                }
                break;
        }
    }
}