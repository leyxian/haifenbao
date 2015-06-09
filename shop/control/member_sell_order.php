<?php
/**
 * 买家 我的销售订单     
 *    
 */ 
defined('ZQ-SHOP') or exit('Access Invalid!');  

class member_sell_orderControl extends BaseMemberControl {  

    public function __construct() { 
        parent::__construct();
        Language::read('member_member_index');   
    } 


    /** 
     * 买家 我的订单，以总订单pay_sn来分组显示 
     * 
     */
    public function indexOp() { 
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
                    array('short_order','wait_send','state_send','state_success','order_shipping','state_cancel'),
                    array(ORDER_STATE_NEW,ORDER_STATE_PAY,ORDER_STATE_SEND,ORDER_STATE_SUCCESS,ORDER_STATE_SUCCESS,ORDER_STATE_CANCEL), $_GET['state_type']);
        }

       // $order_list = $model_order->getOrderList($condition, 10, '*', 'order_id desc','', array('order_common','order_goods','store'));
	   $order_list = $model_order->getOrderList($condition, 10, '*', 'order_id desc','', array('sell_order_common','sell_order_goods','goods','order_goods'));
		// $order_list = $model_order->getOrderList($condition, 10, '*','order_id desc');
		//print_r($order_list);die; 

        //订单列表以支付单pay_sn分组显示
        $order_group_list = array();
        $order_pay_sn_array = array();
        foreach ($order_list as $order_id => $order) {
            //显示取消订单
            $order['if_cancel'] = $model_order->getOrderOperateState('buyer_cancel',$order);

            //显示退款取消订单
            $order['if_refund_cancel'] = $model_order->getOrderOperateState('refund_cancel',$order);

            //显示投诉
          //  $order['if_complain'] = $model_order->getOrderOperateState('complain',$order);

            //显示收货
            $order['if_receive'] = $model_order->getOrderOperateState('receive',$order);

            //显示锁定中
          //  $order['if_lock'] = $model_order->getOrderOperateState('lock',$order);

            //显示物流跟踪
            $order['if_deliver'] = $model_order->getOrderOperateState('deliver',$order);

            //显示评价
           // $order['if_evaluation'] = $model_order->getOrderOperateState('evaluation',$order);

            //显示分享
          //  $order['if_share'] = $model_order->getOrderOperateState('share',$order);

            $order_group_list[$order['pay_sn']]['order_list'][] = $order;

            //如果有在线支付且未付款的订单则显示合并付款链接
            if ($order['order_state'] == ORDER_STATE_NEW) {
                $order_group_list[$order['pay_sn']]['pay_amount'] += $order['buyer_order_amount'];
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
		//$this->get_member_info();
        Tpl::output('order_group_list',$order_group_list);
        Tpl::output('order_pay_list',$order_pay_list);
		Tpl::output('show_page',$model_order->showpage());
		//self::profile_menu('member_order');
		
        switch($_GET['state_type']) {
        case 'short_order':
             Tpl::showpage('member_sell_shortorder');
            break;
        case 'wait_send':
            Tpl::showpage('member_sell_waitsendorder');
            break;
        case 'order_shipping':
            Tpl::showpage('member_sell_shippingorder');
            break;
        case 'state_cancel':
            Tpl::showpage('member_sell_cancelorder');
            break;		
        case 'add_sell_order':
            Tpl::showpage('member_sell_addorder');
            break;		
						
		default:
		 Tpl::showpage('member_sell_order.index');
		 break;	
        }
		
       // Tpl::showpage('member_sell_order.index');
    }
	
	
    /** 
     * 买家 我的微仓 已售完订单
     * 
     */ 
    public function storeOp() { 
        $model_order = Model('sell_order'); 
        //搜索  
        $condition = array();
        $condition['buyer_id'] = $_SESSION['member_id'];
	    $condition['order_state'] ='40';

		   
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

        $order_list = $model_order->getOrderList($condition, 10, '*', 'order_id desc','', array('sell_order_common','sell_order_goods','goods','order_goods'));
																						  
        //完成订单列表显示
        $order_group_list = array();
        $order_pay_sn_array = array();
        foreach ($order_list as $order_id => $order) {

            //显示取消订单
            $order['if_cancel'] = $model_order->getOrderOperateState('buyer_cancel',$order);

            //显示退款取消订单
            $order['if_refund_cancel'] = $model_order->getOrderOperateState('refund_cancel',$order);

            //显示投诉
          //  $order['if_complain'] = $model_order->getOrderOperateState('complain',$order);

            //显示收货
            $order['if_receive'] = $model_order->getOrderOperateState('receive',$order);

            //显示锁定中
          //  $order['if_lock'] = $model_order->getOrderOperateState('lock',$order);

            //显示物流跟踪
            $order['if_deliver'] = $model_order->getOrderOperateState('deliver',$order);

            //显示评价
           // $order['if_evaluation'] = $model_order->getOrderOperateState('evaluation',$order);

            //显示分享
          //  $order['if_share'] = $model_order->getOrderOperateState('share',$order);

            $order_group_list[$order['pay_sn']]['order_list'][] = $order;

            //如果有在线支付且未付款的订单则显示合并付款链接
            if ($order['order_state'] == ORDER_STATE_NEW) {
                $order_group_list[$order['pay_sn']]['pay_amount'] += $order['buyer_order_amount'];
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
		//$this->get_member_info();
		
        Tpl::output('order_group_list',$order_group_list);
        Tpl::output('order_pay_list',$order_pay_list);
		Tpl::output('show_page',$model_order->showpage());
		//self::profile_menu('member_order');
		

		 Tpl::showpage('member_sell_store.index');
		
       // Tpl::showpage('member_sell_order.index');
    }	
	
	

 	/**
	 * 分销商添加订单时：获取商品名称及价格信息操作
	 *
	 */
	public function get_goods_infoOp() {
		  $g_serial=$_POST['g_serial'];
		if($g_serial){	  
				$model_order = Model('goods'); 
				//搜索  
				$condition = array();
				$condition['goods_serial'] = $g_serial;        
				
				//$order_list = $model_order->getOrderList($condition,1, 'goods_name,goods_price');
				$info = $model_order->field('goods_id,goods_name,goods_price')->where($condition)->find();
				//echo $info;
				//print_r( $info);die;
				$goods_id=$info['goods_id'];
				$goods_name=$info['goods_name'];
				$goods_price=$info['goods_price'];
				echo $goods_id.'+'.$goods_name.'+'.$goods_price;
			 }
		  else echo '++'; 
		   exit(0);
	}


	/**
	 * 分销商添加订单操作
	 *
	 */
public function add_goods_orderOp() {

        $model_sell_order = Model('sell_order');
        //存储生成的订单,函数会返回该数组
        $order_list = array();

		//$order_id	= intval($_GET['order_id']);
		$goods_id	= $_POST['g_goods_id'];
		$sell_order_sn	= $_POST['g_order_sn'];
		$buyer_name	= $_POST['g_buy_name'];
		$buyer_card_no	= $_POST['g_card_no'];
		$buyer_phone	= $_POST['g_phone'];
		$area_info	=$_POST['area_info'];
		$buyer_address	= $area_info.$_POST['g_address'];
		$input_address_id	= $_POST['area_id'];
	
		$sell_store_from= $_POST['g_store_from'];
		$sell_store_name= $_POST['g_store_name'];	
		
		$buyer_order_time	= $_POST['g_order_time_y'].' '.$_POST['g_order_time_h'].':'.$_POST['g_order_time_m'];	
		$buyer_order_time	=strtotime($buyer_order_time);
				
		$buyer_pd_amount= $_POST['g_pd_amount'];
		$buyer_order_amount	= $_POST['g_order_amount'];
		$buyer_trans_fee	= $_POST['g_trans_fee'];
		$sell_remark	= $_POST['g_remark'];		
		
		$goods_serial	= $_POST['g_serial'];
		$goods_name	= $_POST['g_goods_name'];
		$sell_goods_name = $_POST['g_goods_name2'];  
		if(empty($goods_name) && !empty($sell_goods_name))$goods_name=$sell_goods_name;	 
		$sell_goods_qty	= $_POST['quantity'];
		$sell_order_price= $_POST['g_price'];
		
    	if(empty($sell_order_sn) || empty($goods_id) || empty($buyer_name) || empty($buyer_card_no) || empty($buyer_phone) || empty($buyer_address) || empty($buyer_pd_amount) || empty($goods_serial) || empty($goods_name) || empty($sell_goods_qty) || empty($sell_order_price)){
    			 showMessage('缺少必要参数,请重新填写后提交！','index.php?act=member_sell_order&state_type=add_sell_order');
    	}
        /**
         * 仓储判断
         */
        if($model_sell_order->getGoodsNum(array('goods_id' => $goods_id)) < $sell_goods_qty){
            showMessage('购买数量大于库存！', 'index.php?act=member_sell_order&state_type=add_sell_order');
        }

		$goods_arr = array();
		$order_common = array();
		$order_goods = array();	
			
        $goods_arr['sell_order_system_sn'] = $this->makePaySn($_SESSION['member_id']);	
		$goods_arr['sell_order_sn']=$sell_order_sn;
		$goods_arr['buyer_name']=$buyer_name;		
		$goods_arr['buyer_card_no']=$buyer_card_no;		
		$goods_arr['buyer_phone']=$buyer_phone;		
		$goods_arr['buyer_address']=$buyer_address;		
		$goods_arr['sell_store_from']=$sell_store_from;		
		$goods_arr['sell_store_name']=$sell_store_name;
		$goods_arr['buyer_order_time']=$buyer_order_time;		
		$goods_arr['buyer_pd_amount']=$buyer_pd_amount;		
		$goods_arr['buyer_order_amount']=$buyer_order_amount;		
		$goods_arr['buyer_trans_fee']=$buyer_trans_fee;
		$goods_arr['sell_remark']=$sell_remark;		
		$goods_arr['goods_serial']=$goods_serial;	
		$goods_arr['goods_id']=$goods_id;				
		$goods_arr['goods_name']=$goods_name;	
		$goods_arr['sell_goods_name']=$sell_goods_name;								
		$goods_arr['sell_goods_qty']=$sell_goods_qty;
		$goods_arr['sell_order_price']=$sell_order_price;
		//---------------
		$goods_arr['buyer_id']=$_SESSION['member_id'];
		$goods_arr['member_name']=$_SESSION['member_name'];
		$goods_arr['order_state']='10';
		$goods_arr['add_time']=TIMESTAMP;		
		//$goods_arr['sell_order_sn']=$sell_order_sn;							


//print_r($goods_arr);die

       // $model_sell_order = Model('sell_order');
        $order_id = $model_sell_order->addOrder($goods_arr);
/*        if(empty($result['error'])) {
             showMessage('销售订单提交成功！','index.php?act=member_sell_order&op=index');
        } else {
            showDialog($result['error'],'','error',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
        }*/
		if (!$order_id) {
			throw new Exception('订单保存失败');
		}

		$order['order_id'] = $order_id;
		$order_list[$order_id] = $goods_arr;

      //收货人信息
        $reciver_info = array();
        $reciver_info['address'] =$buyer_address;	
        $reciver_info['phone'] =$buyer_phone;
        $reciver_info = serialize($reciver_info);	
		
		$order_common['order_id'] = $order_id;
		$order_common['store_id'] = $_SESSION['member_id'];
		$order_common['order_message'] = $sell_remark;		
		$order_common['reciver_info']= $reciver_info;
		$order_common['reciver_name'] = $buyer_name;		
		//发票信息
		//$order_common['invoice_info'] = $this->_createInvoiceData($invoice_info);	
		//取得省ID
		$input_address_info = Model('address')->getAddressInfo(array('address_id'=>$input_address_id));		
        //收货地址城市编号
        $input_city_id = intval($input_address_info['city_id']);					
		require_once(BASE_DATA_PATH.'/area/area.php');
		$order_common['reciver_province_id'] = intval($area_array[$input_city_id]['area_parent_id']);
       // $sell_order_common = Model('sell_order_common');		
		$order_id = $model_sell_order->addOrderCommon($order_common);
		if (!$order_id) {
			throw new Exception('订单保存失败');
		}


        // 获取商品图片:
        $goods_info = Model('goods')->getGoodsInfo(array('goods_id' =>$goods_id),'goods_image');
				
		//生成order_goods订单商品数据
		//$order_goods['order_id'] =  $_SESSION['member_id'];
		$order_goods['order_id'] = $order_id;
		$order_goods['goods_id'] = $goods_id;
		$order_goods['store_id'] = $_SESSION['member_id'];
		$order_goods['goods_name'] = $goods_name;	
		$order_goods['goods_price'] = $buyer_pd_amount;
		$order_goods['goods_num'] = $sell_goods_qty;
		$order_goods['goods_image'] = $goods_info['goods_image'];
		$order_goods['buyer_id'] = $_SESSION['member_id'];
		$order_goods['goods_type'] = 1;
		//$order_goods['promotions_id'] = $goods_info['promotions_id'] ? $goods_info['promotions_id'] : 0;
		//$order_goods['commis_rate'] = floatval($store_gc_id_commis_rate_list[$store_id][$goods_info['gc_id']]);
		//计算商品金额
		//$goods_total = $goods_info['goods_price'] * $goods_info['goods_num'];
		//计算本件商品优惠金额
		//$promotion_value = floor($goods_total*($promotion_rate));
		//$order_goods['goods_pay_price'] = $goods_total - $promotion_value;
		//$promotion_sum += $promotion_value;	
		
        //$sell_order_goods = Model('sell_order_common');
	//print_r($order_goods);die;	
					
		$insert = $model_sell_order->addOrderGoods($order_goods);
		if (!insert) {
			throw new Exception('订单保存3失败');
		}	
								
		if(empty($insert['error'])) {		
                //记录订单日志(已提交订)
                $selldata = array();
                $selldata['order_id'] = $order_id;
                $selldata['log_role'] = 'seller';
                $selldata['log_msg'] = L('order_log_new');
                $selldata['log_orderstate'] = ORDER_STATE_NEW;
                $insertLog = $model_sell_order->addSellOrderLog($selldata);
                if (!$insertLog) {
                    throw new Exception('记录订单日志出现错误');
				}
			 showMessage('销售订单提交成功！','index.php?act=member_sell_order&op=index');
		} else {
			showDialog($result['error'],'','error',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
		}	
		
    }

/*        try {

            //开始事务
            $model_cart->beginTransaction();

            //生成订单
            list($pay_sn,$order_list) = $this->createOrder($input, $member_id, $member_name, $member_email);

            //提交事务
            $model_cart->commit();

        }catch (Exception $e){
            //回滚事务
            $model_cart->rollback();
            return array('error' => $e->getMessage());
        }*/



  /**
     * 生成订单
     * @param array $input
     * @throws Exception
     * @return array array(支付单sn,订单列表)
     */
//    public function createOrder($input, $member_id, $buyer_name, $member_email='') {
//
//        extract($input);
//        $model_order = Model('sell_order');
//        //存储生成的订单,函数会返回该数组
//        $order_list = array();
//
//        //每个店铺订单是货到付款还是线上支付,店铺ID=>付款方式[在线支付/货到付款]
//        //$store_pay_type_list    = $this->_getStorePayTypeList(array_keys($store_cart_list), $if_offpay, $pay_name);
//
///*        $pay_sn = $this->makePaySn($member_id);
//        $order_pay = array();
//        $order_pay['pay_sn'] = $pay_sn;
//        $order_pay['buyer_id'] = $member_id;
//        $order_pay_id = $model_order->addOrderPay($order_pay);
//        if (!$order_pay_id) {
//            throw new Exception('订单保存失败');
//        }*/
//
//        //收货人信息
//        $reciver_info = array();
//        $reciver_info['address'] = $address_info['area_info'].'&nbsp;'.$address_info['g_address'];
//        $reciver_info['phone'] = $address_info['mob_phone'].($address_info['g_phone'] ? ','.$address_info['g_phone'] : null);
//        $reciver_info = serialize($reciver_info);
//        $reciver_name = $address_info['g_buy_name'];
//
//      //  foreach ($store_cart_list as $store_id => $goods_list) {
//
///*            //取得本店优惠额度(后面用来计算每件商品实际支付金额，结算需要)
//            $promotion_total = !empty($store_promotion_total[$store_id]) ? $store_promotion_total[$store_id] : 0; 
//
//            //本店总的优惠比例,保留3位小数
//            $should_goods_total = $store_final_order_total[$store_id]-$store_freight_total[$store_id]+$promotion_total;
//            $promotion_rate = abs($promotion_total/$should_goods_total);
//            if ($promotion_rate <= 1) {
//                $promotion_rate = floatval(substr($promotion_rate,0,5));
//            } else {
//                $promotion_rate = 0;
//            }*/
//
//            //每种商品的优惠金额累加保存入 $promotion_sum
//         //   $promotion_sum = 0;
//
//            $order = array();
//            $order_common = array();
//            $order_goods = array();
//
//            $order['sell_order_system_sn'] = $this->makePaySn($_SESSION['member_id']);
//            //$order['pay_sn'] = $pay_sn;
//            $order['store_id'] = $_SESSION['member_id'];
//            $order['store_name'] = $_SESSION['member_name'];
//            $order['buyer_id'] = $_SESSION['member_id'];
//            $order['buyer_name'] = buyer_name;
//            //$order['buyer_email'] = $member_email;
//            $order['add_time'] = TIMESTAMP;
//            //$order['payment_code'] = $store_pay_type_list[$store_id];
//            $order['order_state'] = 10;
//            
//            
//            $order['order_amount'] = $store_final_order_total[$store_id];
//            $order['shipping_fee'] = $store_freight_total[$store_id];
//            $order['goods_amount'] = $order['order_amount'] - $order['shipping_fee'];
//            $order['order_from'] = 1;
//            $order_id = $model_order->addOrder($order);
//            if (!$order_id) {
//                throw new Exception('订单保存失败');
//            }
//            
//            $order['order_id'] = $order_id;
//            $order_list[$order_id] = $order;
//
//            $order_common['order_id'] = $order_id;
//            $order_common['store_id'] = $store_id;
//            $order_common['order_message'] = $pay_message[$store_id];
//
//            //代金券
//            if (isset($voucher_list[$store_id])){
//                $order_common['voucher_price'] = $voucher_list[$store_id]['voucher_price'];
//                $order_common['voucher_code'] = $voucher_list[$store_id]['voucher_code'];
//            }
//
//            $order_common['reciver_info']= $reciver_info;
//            $order_common['reciver_name'] = $reciver_name;
//
//            //发票信息
//            $order_common['invoice_info'] = $this->_createInvoiceData($invoice_info);
//
//            //保存促销信息
//            if(is_array($store_mansong_rule_list[$store_id])) {
//                $order_common['promotion_info'] = addslashes($store_mansong_rule_list[$store_id]['desc']);
//            }
//
//            //取得省ID
//            require_once(BASE_DATA_PATH.'/area/area.php');
//            $order_common['reciver_province_id'] = intval($area_array[$input_city_id]['area_parent_id']);
//            $order_id = $model_order->addOrderCommon($order_common);
//            if (!$order_id) {
//                throw new Exception('订单保存失败');
//            }
//
//            //生成order_goods订单商品数据
//            $i = 0;
//            foreach ($goods_list as $goods_info) {
//                if (!$goods_info['state'] || !$goods_info['storage_state']) {
//                    throw new Exception('部分商品已经下架或库存不足，请重新选择');
//                }
//                if (!intval($goods_info['bl_id'])) {
//                    //如果不是优惠套装
//                    $order_goods[$i]['order_id'] = $order_id;
//                    $order_goods[$i]['goods_id'] = $goods_info['goods_id'];
//                    $order_goods[$i]['store_id'] = $store_id;
//                    $order_goods[$i]['goods_name'] = $goods_info['goods_name'];
//                    $order_goods[$i]['goods_price'] = $goods_info['goods_price'];
//                    $order_goods[$i]['goods_num'] = $goods_info['goods_num'];
//                    $order_goods[$i]['goods_image'] = $goods_info['goods_image'];
//                    $order_goods[$i]['buyer_id'] = $member_id;
//                    if ($goods_info['ifgroupbuy']) {
//                        $order_goods[$i]['goods_type'] = 2;
//                    }elseif ($goods_info['ifxianshi']) {
//                        $order_goods[$i]['goods_type'] = 3;
//                    }elseif ($goods_info['ifzengpin']) {
//                        $order_goods[$i]['goods_type'] = 5;
//                    }else {
//                        $order_goods[$i]['goods_type'] = 1;
//                    }
//                    $order_goods[$i]['promotions_id'] = $goods_info['promotions_id'] ? $goods_info['promotions_id'] : 0;
//                    $order_goods[$i]['commis_rate'] = floatval($store_gc_id_commis_rate_list[$store_id][$goods_info['gc_id']]);
//                    //计算商品金额
//                    $goods_total = $goods_info['goods_price'] * $goods_info['goods_num'];
//                    //计算本件商品优惠金额
//                    $promotion_value = floor($goods_total*($promotion_rate));
//                    $order_goods[$i]['goods_pay_price'] = $goods_total - $promotion_value;
//                    $promotion_sum += $promotion_value;
//                    $i++;
//
//                } elseif (!empty($goods_info['bl_goods_list']) && is_array($goods_info['bl_goods_list'])) {
//
//                    //优惠套装
//                    foreach ($goods_info['bl_goods_list'] as $bl_goods_info) {
//                        $order_goods[$i]['order_id'] = $order_id;
//                        $order_goods[$i]['goods_id'] = $bl_goods_info['goods_id'];
//                        $order_goods[$i]['store_id'] = $store_id;
//                        $order_goods[$i]['goods_name'] = $bl_goods_info['goods_name'];
//                        $order_goods[$i]['goods_price'] = $bl_goods_info['bl_goods_price'];
//                        $order_goods[$i]['goods_num'] = $goods_info['goods_num'];
//                        $order_goods[$i]['goods_image'] = $bl_goods_info['goods_image'];
//                        $order_goods[$i]['buyer_id'] = $member_id;
//                        $order_goods[$i]['goods_type'] = 4;
//                        $order_goods[$i]['promotions_id'] = $bl_goods_info['bl_id'];
//                        $order_goods[$i]['commis_rate'] = floatval($store_gc_id_commis_rate_list[$store_id][$goods_info['gc_id']]);
//
//                        //计算商品实际支付金额(goods_price减去分摊优惠金额后的值)
//                        $goods_total = $bl_goods_info['bl_goods_price'] * $goods_info['goods_num'];
//                        //计算本件商品优惠金额
//                        $promotion_value = floor($goods_total*($promotion_rate));
//                        $order_goods[$i]['goods_pay_price'] = $goods_total - $promotion_value;
//                        $promotion_sum += $promotion_value;
//                        $i++;
//                    }
//                }
//            }
//
//            //将因舍出小数部分出现的差值补到最后一个商品的实际成交价中(商品goods_price=0时不给补，可能是赠品)
//            if ($promotion_total > $promotion_sum) {
//                $i--;
//                for($i;$i>=0;$i--) {
//                    if (floatval($order_goods[$i]['goods_price']) > 0) {
//                        $order_goods[$i]['goods_pay_price'] -= $promotion_total - $promotion_sum;
//                        break;
//                    }
//                }
//            }
//            $insert = $model_order->addOrderGoods($order_goods);
//            if (!insert) {
//                throw new Exception('订单保存失败');
//            }
//       // }
//        return array($pay_sn,$order_list);
//    }



	/**
	 * 生成支付单编号(两位随机 + 从2000-01-01 00:00:00 到现在的秒数+微秒+会员ID%1000)，该值会传给第三方支付接口
	 * 长度 =2位 + 10位 + 3位 + 3位  = 18位
	 * 1000个会员同一微秒提订单，重复机率为1/100
	 * @return string
	 */
	public function makePaySn($member_id) {
		return mt_rand(10,99)
		      . sprintf('%010d',time() - 946656000)
		      . sprintf('%03d', (float) microtime() * 1000)
		      . sprintf('%03d', (int) $member_id % 1000);
	}
	
	

}
