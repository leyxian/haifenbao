<?php
/**
 * 买家 我的订单
 *   
 */
defined('ZQ-SHOP') or exit('Access Invalid!');

class sell_order_detailControl extends BaseMemberControl {   

    public function __construct() {  
        parent::__construct();
        Language::read('member_member_index');
    }

    /** 
     * 买家我的订单，以总订单pay_sn来分组显示
     *
     */
/*    public function indexOp() {   
        $model_order = Model('sell_order');

        //搜索
        $condition = array();
        $condition['buyer_id'] = $_SESSION['member_id'];
        if ($_GET['order_sn'] != '') {
            $condition['order_sn'] = $_GET['order_sn'];
        }
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
        $start_unixtime = $if_start_date ? strtotime($_GET['query_start_date']) : null;
		$end_unixtime = $if_end_date ? strtotime($_GET['query_end_date']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('time',array($start_unixtime,$end_unixtime));
        }
        if ($_GET['state_type'] != '') { 
            $condition['order_state'] = str_replace(
                    array('state_new','state_pay','state_send','state_success','state_noeval','state_cancel'),
                    array(ORDER_STATE_NEW,ORDER_STATE_PAY,ORDER_STATE_SEND,ORDER_STATE_SUCCESS,ORDER_STATE_SUCCESS,ORDER_STATE_CANCEL), $_GET['state_type']);
        }
        if ($_GET['state_type'] == 'state_noeval') {
            $condition['evaluation_state'] = 0;
            $condition['order_state'] = ORDER_STATE_SUCCESS;
            $condition['finnshed_time'] = array('gt',TIMESTAMP - ORDER_EVALUATE_TIME);
        }
        $order_list = $model_order->getOrderList($condition, 20, '*', 'order_id desc','', array('order_common','order_goods','store')); 

        $model_refund_return = Model('refund_return');
        $order_list = $model_refund_return->getGoodsRefundList($order_list);

        //订单列表以支付单pay_sn分组显示
        $order_group_list = array();
        $order_pay_sn_array = array();
        foreach ($order_list as $order_id => $order) {

            //显示取消订单
            $order['if_cancel'] = $model_order->getOrderOperateState('buyer_cancel',$order);

            //显示退款取消订单
            $order['if_refund_cancel'] = $model_order->getOrderOperateState('refund_cancel',$order);

            //显示投诉
            $order['if_complain'] = $model_order->getOrderOperateState('complain',$order);

            //显示收货
            $order['if_receive'] = $model_order->getOrderOperateState('receive',$order);

            //显示锁定中
            $order['if_lock'] = $model_order->getOrderOperateState('lock',$order);

            //显示物流跟踪
            $order['if_deliver'] = $model_order->getOrderOperateState('deliver',$order);

            //显示评价
            $order['if_evaluation'] = $model_order->getOrderOperateState('evaluation',$order);

            //显示分享
            $order['if_share'] = $model_order->getOrderOperateState('share',$order);

            $order_group_list[$order['pay_sn']]['order_list'][] = $order;

            //如果有在线支付且未付款的订单则显示合并付款链接
            if ($order['order_state'] == ORDER_STATE_NEW) {
                $order_group_list[$order['pay_sn']]['pay_amount'] += $order['order_amount'];
            }
            $order_group_list[$order['pay_sn']]['add_time'] = $order['add_time'];  

            //记录一下pay_sn，后面需要查询支付单表
            $order_pay_sn_array[] = $order['pay_sn'];
        }

        //取得这些订单下的支付单列表
        $condition = array('pay_sn'=>array('in',array_unique($order_pay_sn_array)));
        $order_pay_list = $model_order->getOrderPayList($condition,'','*','','pay_sn');
        foreach ($order_group_list as $pay_sn => $pay_info) {
        	$order_group_list[$pay_sn]['pay_info'] = $order_pay_list[$pay_sn];
        }
		$this->get_member_info();
        Tpl::output('order_group_list',$order_group_list);
        Tpl::output('order_pay_list',$order_pay_list);
		Tpl::output('show_page',$model_order->showpage());

		self::profile_menu('member_order');
        Tpl::showpage('member_order.index');
    }
*/
    /**
     * 物流跟踪
     */
/*    public function search_deliverOp(){
        Language::read('member_member_index');
        $lang	= Language::getLangContent();
        $order_id	= intval($_GET['order_id']);
        if ($order_id <= 0) {
            showMessage(Language::get('wrong_argument'),'','html','error');
        }

        $model_order	= Model('order');
        $condition['order_id'] = $order_id;
        $condition['buyer_id'] = $_SESSION['member_id']; 
        $order_info = $model_order->getOrderInfo($condition,array('order_common','order_goods'));
        if (empty($order_info) || !in_array($order_info['order_state'],array(ORDER_STATE_SEND,ORDER_STATE_SUCCESS))) {
            showMessage('未找到信息','','html','error');
        }
        Tpl::output('order_info',$order_info);
        //卖家信息
        $model_store	= Model('store');
        $store_info		= $model_store->getStoreInfoByID($order_info['store_id']);
        Tpl::output('store_info',$store_info);

        //卖家发货信息
        $daddress_info = Model('daddress')->getAddressInfo(array('address_id'=>$order_info['extend_order_common']['daddress_id']));
        Tpl::output('daddress_info',$daddress_info);

		$this->get_member_info();
        //取得配送公司代码
        $express = ($express = H('express'))? $express :H('express',true);
        Tpl::output('e_code',$express[$order_info['extend_order_common']['shipping_express_id']]['e_code']);
        Tpl::output('e_name',$express[$order_info['extend_order_common']['shipping_express_id']]['e_name']);
        Tpl::output('e_url',$express[$order_info['extend_order_common']['shipping_express_id']]['e_url']);
        Tpl::output('shipping_code',$order_info['shipping_code']);
        self::profile_menu('search','search');
        Tpl::output('left_show','order_view');
        Tpl::showpage('member_order_deliver.detail');
    }
*/
    /**
     * 从第三方取快递信息
     *
     */
 /*   public function get_expressOp(){

        $url = 'http://www.kuaidi100.com/query?type='.$_GET['e_code'].'&postid='.$_GET['shipping_code'].'&id=1&valicode=&temp='.random(4).'&sessionid=&tmp='.random(4);
        import('function.ftp');
        $content = dfsockopen($url);
        $content = json_decode($content,true);

        if ($content['status'] != 200) exit(json_encode(false));
        $content['data'] = array_reverse($content['data']);
        $output = '';
        if (is_array($content['data'])){
            foreach ($content['data'] as $k=>$v) {
                if ($v['time'] == '') continue;
                $output .= '<li>'.$v['time'].'&nbsp;&nbsp;'.$v['context'].'</li>';
            }
        }
        if ($output == '') exit(json_encode(false));
        if (strtoupper(CHARSET) == 'GBK'){
            $output = Language::getUTF8($output);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
        }
        echo json_encode($output);
    }
*/
    /**
     * 订单详细
     *
     */
    public function show_orderOp() {
        $order_id = intval($_GET['order_id']);
        if ($order_id <= 0) {
            showMessage(Language::get('member_order_none_exist'),'','html','error');
        }
        $model_order = Model('sell_order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['buyer_id'] = $_SESSION['member_id'];
        //$order_info = $model_order->getOrderInfo($condition,array('order_goods','order_common','store'));
		$order_info = self::getself_OrderInfo($condition,array('sell_order','goods'));
        if (empty($order_info)) {
            showMessage(Language::get('member_order_none_exist'),'','html','error');
        }
        Tpl::output('order_info',$order_info);
       // Tpl::output('left_show','order_view');
		//echo $order_info['sell_order_sn'].'<BR /><BR /><BR />';
        //print_r($order_info);die;
        //卖家发货信息
        if (!empty($order_info['extend_order_common']['daddress_id'])) {
            $daddress_info = Model('daddress')->getAddressInfo(array('address_id'=>$order_info['extend_order_common']['daddress_id']));
            Tpl::output('daddress_info',$daddress_info);
        }

        //订单变更日志
		$log_list	= $model_order->getOrderLogList(array('order_id'=>$order_info['order_id']));
		Tpl::output('order_log',$log_list);

		//退款退货信息
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['order_id'] = $order_info['order_id'];
		$condition['seller_state'] = 2;
		$condition['admin_time'] = array('gt',0);
		$return_list = $model_refund->getReturnList($condition);
		Tpl::output('return_list',$return_list);
       
		//退款信息
		$refund_list = $model_refund->getRefundList($condition);
		Tpl::output('refund_list',$refund_list);
		Tpl::showpage('sell_order_detail.show');
    }

	/**
	 * 买家订单状态操作
	 *
	 */
	public function change_stateOp() {
		$state_type	= $_GET['state_type'];
		$order_id	= intval($_GET['order_id']);

        $model_order = Model('sell_order');

		$condition = array();
		$condition['order_id'] = $order_id;
		$condition['buyer_id'] = $_SESSION['member_id'];
		$order_info	= $model_order->getOrderInfo($condition);

        if (!chksubmit()) {
            Tpl::output('order_info', $order_info);
            if($state_type == 'order_cancel') {
                Tpl::showpage('member_order.cancel','null_layout');exit();
            } elseif ($state_type == 'order_receive') {
                Tpl::showpage('member_order.receive','null_layout');exit();
            }
        }

        $extend_msg = $_POST['state_info1'] != '' ? $_POST['state_info1'] : $_POST['state_info'];

        $result = $model_order->memberChangeState($state_type, $order_info, $_SESSION['member_id'], $_SESSION['member_name'], $extend_msg);

        if(empty($result['error'])) {
            showDialog($result['success'],'reload','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
        } else {
            showDialog($result['error'],'','error',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
        }
    }



   /**
     * 取单条订单信息
     *
     * @param unknown_type $condition
     * @param array $extend 追加返回那些表的信息,如array('order_common','order_goods','store')
     * @return unknown
     */ 
    public function getself_OrderInfo($condition = array(), $extend = array(), $fields = '*', $order = '',$group = '') { 
		 $model_order = Model('sell_order');
        $order_info = $model_order->table('sell_order')->field($fields)->where($condition)->group($group)->order($order)->find();
        if (empty($order_info)) {
            return array();
        }
		//print_r($order_info);die;
        $order_info['state_desc'] = orderState($order_info);
		
       // $order_info['payment_name'] = orderPaymentName($order_info['payment_code']);
/*
        //追加返回订单扩展表信息
        if (in_array('order_common',$extend)) {
            $order_info['extend_order_common'] = $this->getOrderCommonInfo(array('order_id'=>$order_info['order_id']));
            $order_info['extend_order_common']['reciver_info'] = unserialize($order_info['extend_order_common']['reciver_info']);
            $order_info['extend_order_common']['invoice_info'] = unserialize($order_info['extend_order_common']['invoice_info']);
        }

        //追加返回店铺信息
        if (in_array('store',$extend)) {
            $order_info['extend_store'] = Model('store')->getStoreInfo(array('store_id'=>$order_info['store_id']));
        }

        //返回买家信息
        if (in_array('member',$extend)) {
            $order_info['extend_member'] = Model('member')->getMemberInfo(array('member_id'=>$order_info['buyer_id']));
        }
*/
        //追加返回商品信息
        if (in_array('goods',$extend)) {
            //取商品列表
            $order_goods_list = $this->getOrderGoodsList(array('goods_id'=>$order_info['goods_id']));
            foreach ($order_goods_list as $value) {
            	$order_info['extend_order_goods'][] = $value;
            }
        }

        return $order_info;
    }


    /**
     * 取得订单商品表列表
     * @param unknown $condition
     * @param string $fields
     * @param string $limit
     * @param string $page
     * @param string $order
     * @param string $group
     * @param string $key
     */
    public function getOrderGoodsList($condition = array(), $fields = '*', $limit = null, $page = null, $order = 'goods_id desc', $group = null, $key = null) {
		 $model_goods = Model('goods');
        return $model_goods->table('goods')->field($fields)->where($condition)->limit($limit)->order($order)->group($group)->key($key)->page($page)->select();
    }



    /**
     * 用户中心右边，小导航
     *
     * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
/*	private function profile_menu($menu_key='') {
	    Language::read('member_layout');
	    $menu_array = array(
	            1=>array('menu_key'=>'member_order','menu_name'=>Language::get('nc_member_path_all_order'),	    'menu_url'=>'index.php?act=member_order'),
	            2=>array('menu_key'=>'member_order','menu_name'=>Language::get('nc_member_path_wait_pay'),	    'menu_url'=>'index.php?act=member_order&state_type=state_new'),
	            3=>array('menu_key'=>'member_order','menu_name'=>Language::get('nc_member_path_wait_valuate'),	'menu_url'=>'index.php?act=member_order&state_type=state_noeval'),				
	            4=>array('menu_key'=>'member_order','menu_name'=>Language::get('nc_member_path_canceled'),	    'menu_url'=>'index.php?act=member_order&state_type=state_cancel'),										
	            5=>array('menu_key'=>'buyer_refund','menu_name'=>Language::get('nc_member_path_buyer_refund'),	'menu_url'=>'index.php?act=member_refund'),
	            6=>array('menu_key'=>'buyer_return','menu_name'=>Language::get('nc_member_path_buyer_return'),	'menu_url'=>'index.php?act=member_return')
	    );
	    Tpl::output('member_menu',$menu_array);
	    Tpl::output('menu_key',$menu_key);
	}*/
}
