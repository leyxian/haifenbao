<?php
/**
 * 交易管理 
 *  
 */   
defined('ZQ-SHOP') or exit('Access Invalid!');  
class tran_orderControl extends SystemControl{  
/*	private $links = array(
		array('url'=>'act=tran_order&op=tran_order',	'lang'=>'nc_tran_manage'),
		array('url'=>'act=tran_order&op=store_order&state_type=state_new','lang'=>'order_state_new'),
		array('url'=>'act=tran_order&op=store_order&state_type=state_pay','lang'=>'order_state_pay'),
		array('url'=>'act=tran_order&op=store_order&state_type=state_send','lang'=>'order_state_send'),		
		array('url'=>'act=tran_order&op=store_order&state_type=state_success','lang'=>'order_state_success'),		
		array('url'=>'act=tran_order&op=store_order&state_type=state_cancel','lang'=>'order_state_cancel'),		
	);*/
	
    /**
     * 每次导出订单数量
     * @var int
     */
	const EXPORT_SIZE = 1000;

	public function __construct(){
		parent::__construct();
		Language::read('tran_order'); 		
	}

	public function tran_orderOp(){
	
//	   echo urlShop('store_order', 'index');
//	    $model_order = Model('order');
//        $condition	= array();
//        if($_GET['order_sn']) {
//        	$condition['order_sn'] = $_GET['order_sn'];
//        }
// //       if($_GET['store_name']) {
// //           $condition['store_name'] = $_GET['store_name'];
////        }
//
//        if ($_GET['buyer_name'] != '') {
//            $condition['buyer_name'] = $_GET['buyer_name']; 
//        }
////        if($_GET['buyer_name']) {
////            $condition['buyer_name'] = $_GET['buyer_name'];
////        }
//
//
//		$allow_state_array = array('state_new','state_pay','state_send','state_success','state_cancel');
//		if (in_array($_GET['state_type'],$allow_state_array)) {
//			$condition['order_state'] = str_replace($allow_state_array,
//					array(ORDER_STATE_NEW,ORDER_STATE_PAY,ORDER_STATE_SEND,ORDER_STATE_SUCCESS,ORDER_STATE_CANCEL), $_GET['state_type']);
//		} else {
//			$_GET['state_type'] = 'tran_order';
//		}
//
///*        if(in_array($_GET['order_state'],array('0','10','20','30','40','50'))){
//        	$condition['order_state'] = $_GET['order_state'];
//        }
//        if($_GET['payment_code']) {
//            $condition['payment_code'] = $_GET['payment_code'];
//        }*/
//        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
//        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
//        $start_unixtime = $if_start_date ? strtotime($_GET['query_start_date']) : null;
//        $end_unixtime = $if_end_date ? strtotime($_GET['query_end_date']): null;		
//        if ($start_unixtime || $end_unixtime) {
//            $condition['add_time'] = array('time',array($start_unixtime,$end_unixtime));
//        }
//        $order_list = $model_order->getOrderList($condition, 20, '*', 'order_id desc','', array('order_goods','order_common','member'));		
//       // $order_list	= $model_order->getOrderList($condition,30);		
//
//
//        //页面中显示那些操作
//        foreach ($order_list as $key => $order_info) {
//
//        	//显示取消订单
//        	$order_list[$key]['if_cancel'] = $model_order->getOrderOperateState('store_cancel',$order_info);
//
//        	//显示调整费用
//        	$order_list[$key]['if_modify_price'] = $model_order->getOrderOperateState('modify_price',$order_info);
//        	
//        	//显示发货
//        	$order_list[$key]['if_send'] = $model_order->getOrderOperateState('send',$order_info);
//        	
//        	//显示锁定中
//        	$order_list[$key]['if_lock'] = $model_order->getOrderOperateState('lock',$order_info);
//
//        	//显示物流跟踪
//        	$order_list[$key]['if_deliver'] = $model_order->getOrderOperateState('deliver',$order_info);
//
//        }
//
//
///*        foreach ($order_list as $order_id => $order_info) {
//            //显示取消订单
//            $order_list[$order_id]['if_cancel'] = $model_order->getOrderOperateState('system_cancel',$order_info);
//            //显示收到货款
//            $order_list[$order_id]['if_system_receive_pay'] = $model_order->getOrderOperateState('system_receive_pay',$order_info);            
//        }*/
//		
//		
//		
//		
//        //显示支付接口列表(搜索)
//        $payment_list = Model('payment')->getPaymentOpenList();
//        Tpl::output('payment_list',$payment_list);
//
//
//  //      Tpl::output('order_list',$order_list);
// //       Tpl::output('show_page',$model_order->showpage());
// //       self::profile_menu('list',$_GET['state_type']);
//
////        Tpl::showpage('store_order.index');
//
//
//        Tpl::output('order_list',$order_list);
//        Tpl::output('show_page',$model_order->showpage());
//		//Tpl::output('top_link',$this->sublink($this->links,'tran_order'));
        Tpl::showpage('tran_order.index');
	}

}