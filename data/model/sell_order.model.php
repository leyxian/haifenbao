<?php
/**
 * 订单管理
 *
 *
 *
 *
 */
defined('ZQ-SHOP') or exit('Access Invalid!');
class sell_orderModel extends Model { 

    /**
     * 取单条订单信息 
     *
     * @param unknown_type $condition
     * @param array $extend 追加返回那些表的信息,如array('order_common','order_goods','store')
     * @return unknown  
     */ 
    public function getOrderInfo($condition = array(), $extend = array(), $fields = '*', $order = '',$group = '') { 
        $order_info = $this->table('sell_order')->field($fields)->where($condition)->group($group)->order($order)->find();
        if (empty($order_info)) {
            return array();
        }
        $order_info['state_desc'] = orderState($order_info);
		
       // $order_info['payment_name'] = orderPaymentName($order_info['payment_code']);

        //追加返回订单扩展表信息
        if (in_array('sell_order_common',$extend)) {
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

        //追加返回商品信息
        if (in_array('sell_order_goods',$extend)) {
            //取商品列表
            $order_goods_list = $this->getOrderGoodsList(array('order_id'=>$order_info['order_id']));
            foreach ($order_goods_list as $value) {
            	$order_info['extend_order_goods'][] = $value;
            }
        }

        return $order_info;
    }

    public function getOrderCommonInfo($condition = array(), $field = '*') {
        return $this->table('sell_order_common')->where($condition)->find();
    }

    public function getOrderPayInfo($condition = array()) {
        return $this->table('order_pay')->where($condition)->find();
    }

    /**
     * 取得支付单列表
     *
     * @param unknown_type $condition
     * @param unknown_type $pagesize
     * @param unknown_type $filed
     * @param unknown_type $order
     * @param string $key 以哪个字段作为下标,这里一般指pay_id
     * @return unknown
     */
    public function getOrderPayList($condition, $pagesize = '', $filed = '*', $order = '', $key = '') {
        return $this->table('order_pay')->field($filed)->where($condition)->order($order)->page($pagesize)->key($key)->select();
    }

    /**
     * 取得订单列表 
     * @param unknown $condition
     * @param string $pagesize
     * @param string $field
     * @param string $order
     * @param string $limit
     * @param unknown $extend 追加返回那些表的信息,如array('order_common','order_goods','store')
     * @return Ambigous <multitype:boolean Ambigous <string, mixed> , unknown>
     */



    public function getOrderList($condition, $pagesize = '', $field = '*', $order = 'order_id desc', $limit = '', $extend = array()){
        $list = $this->table('sell_order')->field($field)->where($condition)->order($order)->select();
        if (empty($list)) return array();
        $order_list = array();
        foreach ($list as $order) {
        	$order['state_desc'] = orderState($order);
        	//$order['payment_name'] = orderPaymentName($order['payment_code']);
        	if (!empty($extend)) $order_list[$order['order_id']] = $order;			 
        }
        if (empty($order_list)) $order_list = $list;
		$orderArr=$order_list[$order['order_id']];
		$order_id=$orderArr['order_id'];

	//print_r($order_list);die;	
       // if (empty($order_list)) $order_list = $list;
		//$order_list[$order_id]['buyer_id'] = $_SESSION['member_id'];	
		//echo $order_list[0]['member_id'].'====<br />';	
		//print_r($order_list);die;
	

       //追加返回订单扩展表信息
        if (in_array('sell_order_common',$extend)) {
            $order_common_list = $this->getOrderCommonList(array('order_id'=>array('in',array_keys($order_list))));
            foreach ($order_common_list as $value) {
                $order_list[$value['order_id']]['extend_order_common'] = $value;
                $order_list[$value['order_id']]['extend_order_common']['reciver_info'] = @unserialize($value['reciver_info']);
               // $order_list[$value['order_id']]['extend_order_common']['invoice_info'] = @unserialize($value['invoice_info']);
            }
        }
 /*			
        //追加返回店铺信息
        if (in_array('store',$extend)) {
            $store_id_array = array();
            foreach ($order_list as $value) {
            	if (!in_array($value['store_id'],$store_id_array)) $store_id_array[] = $value['store_id'];
            }
            $store_list = Model('store')->getStoreList(array('store_id'=>array('in',$store_id_array)));
            $store_new_list = array();
            foreach ($store_list as $store) {
            	$store_new_list[$store['store_id']] = $store;
            }
            foreach ($order_list as $order_id => $order) {
                $order_list[$order_id]['extend_store'] = $store_new_list[$order['store_id']];
            }
        }

        //追加返回买家信息
        if (in_array('member',$extend)) {
            $member_id_array = array();
            foreach ($order_list as $value) {
            	if (!in_array($value['buyer_id'],$member_id_array)) $member_id_array[] = $value['buyer_id'];
            }
            $member_list = Model()->table('member')->where(array('member_id'=>array('in',$member_id_array)))->limit($pagesize)->key('member_id')->select();
            foreach ($order_list as $order_id => $order) {
                $order_list[$order_id]['extend_member'] = $member_list[$order['buyer_id']];
            }
        }*/
		
		
        //追加返回该商品官方库存总数信息
        if (in_array('goods', $extend)) {	
                foreach ($order_list as $k => $v) {
                    $field = 'goods_storage';
                    //$where = array('goods_id'=>array('in',self::array_column($order_list,'goods_id'))); 
                    $where = 'goods_id = '.$v['goods_id'];
                    $goods_storage_array = Model('goods')->getGoodsList($where, $field);
                    $order_list[$v['order_id']]['extend_order_common']['goods_storage'] = $goods_storage_array[0]['goods_storage'];
                }
				//print_r($order_list[$value['order_id']]);	  die;
						
				foreach ($goods_storage_array as $value) {
					$order_list[$order_id]['extend_order_common']['goods_storage'] = $value['goods_storage'];						
				// print_r($order_list);  die;	
				}
        }	
		
        //追加返回分销商库存商品信息
        if (in_array('order_goods',$extend)) {
            //取商品	
				$table_order=$GLOBALS['config']['tablepre'].'order';
				$table_order_goods=$GLOBALS['config']['tablepre'].'order_goods';
                foreach ($order_list as $v) {
                    $field = " SUM({$table_order_goods}.goods_num) as goodsnum ";
                    $wheregoods=" where {$table_order}.order_state='20' and {$table_order}.order_id={$table_order_goods}.order_id and {$table_order_goods}.buyer_id=".$_SESSION['member_id']." and {$table_order_goods}.goods_id={$v['goods_id']}";
                    $sql = 'SELECT '.$field.' FROM '.$table_order.','.$table_order_goods.$wheregoods;
                    $goods_buyer_storage_array=Model()->query($sql);
                    $order_list[$v['order_id']]['extend_order_common']['goods_buyer_storage'] =$goods_buyer_storage_array[0]['goodsnum'];
                }
				//$getGoods_idArr=self::array_column($order_list,'goods_id');
				//$where = array('order_goods.goods_id'=>array('in',self::array_column($order_list,'goods_id')),'order_goods.order_state'=>'20');	
					

				//  print_r($sql);die;
			//	$goods_storage_array = Model('goods')->getGoodsList($where, $field);		
				// foreach ($goods_buyer_storage_array as $value) {
				// 	$order_list[$order_id]['extend_order_common']['goods_buyer_storage'] = $value['goodsnum'];						
				// print_r($order_list);  die;	
				// }
        }		
		
	 // print_r($goods_id);	  die;
	 // print_r(array('goods_id'=>array('in',self::array_column($order_list,'goods_id'))));die;
	
        //追加返回商品信息
        if (in_array('sell_order_goods',$extend)) {
            //取商品列表
            //$order_goods_list = $this->getOrderGoodsList(array('goods_id'=>array('in',array_keys($order_list)));
			//print_r(array('goods_id'=>$order_list[$order['order_id']]['goods_id'],'buyer_id'=>$order_list[$order['order_id']]['buyer_id']));die;
			//$order_goods_list = $this->getOrderGoodsList(array('goods_id'=>array('in',self::array_column($order_list,'goods_id'))));
			 $order_goods_list = $this->getOrderGoodsList(array('order_id'=>array('in',array_keys($order_list))));			
			
            foreach ($order_goods_list as $value) {
                $value['goods_image_url'] = cthumb($value['goods_image'], 240);
            	$order_list[$value['order_id']]['extend_order_goods'][] = $value;
				//$order_list[$value['order_id']]['extend_order_goods'][] = $goods_storage;				
            }
			
        }
// print_r($order_list);  die;
        return $order_list;
    }

    /**
     * 待付款订单数量
     * @param unknown $condition
     */
    public function getOrderStateNewCount($condition = array()) {
        $condition['order_state'] = ORDER_STATE_NEW;
        return $this->getOrderCount($condition);
    }

    /**
     * 待发货订单数量
     * @param unknown $condition
     */
    public function getOrderStatePayCount($condition = array()) {
        $condition['order_state'] = ORDER_STATE_PAY;
        return $this->getOrderCount($condition);
    }

    /**
     * 待收货订单数量
     * @param unknown $condition
     */
    public function getOrderStateSendCount($condition = array()) {
        $condition['order_state'] = ORDER_STATE_SEND;
        return $this->getOrderCount($condition);
    }

    /**
     * 待评价订单数量
     * @param unknown $condition
     */
    public function getOrderStateEvalCount($condition = array()) {
        $condition['order_state'] = ORDER_STATE_SUCCESS;
        $condition['evaluation_state'] = 0;
        $condition['finnshed_time'] = array('gt',TIMESTAMP - ORDER_EVALUATE_TIME);
        return $this->getOrderCount($condition);
    }

    /**
     * 取得订单数量
     * @param unknown $condition
     */
    public function getOrderCount($condition) {
        return $this->table('sell_order')->where($condition)->count();
    }

    /**
     * 取得订单商品表详细信息
     * @param unknown $condition
     * @param string $fields
     * @param string $order
     */
    public function getOrderGoodsInfo($condition = array(), $fields = '*', $order = '') {
        return $this->table('sell-order_goods')->where($condition)->field($fields)->order($order)->find();
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
    public function getOrderGoodsList($condition = array(), $fields = '*', $limit = null, $page = null, $order = 'rec_id desc', $group = null, $key = null) {
        return $this->table('sell_order_goods')->field($fields)->where($condition)->limit($limit)->order($order)->group($group)->key($key)->page($page)->select();
    }

    /**
     * 取得订单扩展表列表
     * @param unknown $condition
     * @param string $fields
     * @param string $limit
     */
    public function getOrderCommonList($condition = array(), $fields = '*', $limit = null) {
        return $this->table('sell_order_common')->field($fields)->where($condition)->limit($limit)->select();
    }
	
	
    /**
     * 插入订单支付表信息
     * @param array $data
     * @return int 返回 insert_id
     */
    public function addOrderPay($data) {
        return $this->table('order_pay')->insert($data);
    }

    /**
     * 插入订单表信息
     * @param array $data
     * @return int 返回 insert_id
     */
    public function addOrder($data) {
        return $this->table('sell_order')->insert($data);
    }
	

    /**
     * 插入订单扩展表信息
     * @param array $data
     * @return int 返回 insert_id
     */
    public function addOrderCommon($data) {
        return $this->table('sell_order_common')->insert($data);
    }

    /**
     * 插入订单扩展表信息
     * @param array $data
     * @return int 返回 insert_id
     */
    public function addOrderGoods($data) {
        //return $this->table('sell_order_goods')->insertAll($data);
		return $this->table('sell_order_goods')->insert($data);
    }

	/**
	 * 添加订单日志
	 */
	public function addSellOrderLog($selldata) {
	    $selldata['log_role'] = str_replace(array('buyer','seller','system'),array('买家','商家','系统'), $selldata['log_role']);
	    $selldata['log_time'] = TIMESTAMP;
	    return $this->table('sell_order_log')->insert($selldata);
	}

	/**
	 * 更改订单信息
	 *
	 * @param unknown_type $data
	 * @param unknown_type $condition
	 */
	public function editOrder($data,$condition) {
		return $this->table('sell_order')->where($condition)->update($data);
	}

	/**
	 * 更改订单信息
	 *
	 * @param unknown_type $data
	 * @param unknown_type $condition
	 */
	public function editOrderCommon($data,$condition) {
	    return $this->table('sell_order_common')->where($condition)->update($data);
	}

	/**
	 * 更改订单支付信息
	 *
	 * @param unknown_type $data
	 * @param unknown_type $condition
	 */
	public function editOrderPay($data,$condition) {
		return $this->table('order_pay')->where($condition)->update($data);
	}

	/**
	 * 订单操作历史列表
	 * @param unknown $order_id
	 * @return Ambigous <multitype:, unknown>
	 */
    public function getOrderLogList($condition) {
        return $this->table('sell_order_log')->where($condition)->select();
    }

    /**
     * 返回是否允许某些操作
     * @param unknown $operate
     * @param unknown $order_info
     */
    public function getOrderOperateState($operate,$order_info){

        if (!is_array($order_info) || empty($order_info)) return false;

        switch ($operate) {

            //买家取消订单
        	case 'buyer_cancel':
        	   $state = ($order_info['order_state'] == ORDER_STATE_NEW) ||
        	       ($order_info['payment_code'] == 'offline' && $order_info['order_state'] == ORDER_STATE_PAY);
        	   break;

    	   //买家取消订单
    	   case 'refund_cancel':
    	       $state = $order_info['refund'] == 1 && !intval($order_info['lock_state']);
    	       break;

    	   //商家取消订单
    	   case 'store_cancel':
    	       $state = ($order_info['order_state'] == ORDER_STATE_NEW) ||
    	       ($order_info['payment_code'] == 'offline' &&
    	       in_array($order_info['order_state'],array(ORDER_STATE_PAY,ORDER_STATE_SEND)));
    	       break;

           //平台取消订单
           case 'system_cancel':
               $state = ($order_info['order_state'] == ORDER_STATE_NEW) ||
               ($order_info['payment_code'] == 'offline' && $order_info['order_state'] == ORDER_STATE_PAY);
               break;

           //平台收款
           case 'system_receive_pay':
               $state = $order_info['order_state'] == ORDER_STATE_NEW && $order_info['payment_code'] == 'online';
               break;

	       //买家投诉
	       case 'complain':
	           $state = in_array($order_info['order_state'],array(ORDER_STATE_PAY,ORDER_STATE_SEND)) ||
	               intval($order_info['finnshed_time']) > (TIMESTAMP - C('complain_time_limit'));
	           break;

            //调整运费
        	case 'modify_price':
        	    $state = ($order_info['order_state'] == ORDER_STATE_NEW) ||
        	       ($order_info['payment_code'] == 'offline' && $order_info['order_state'] == ORDER_STATE_PAY);
        	    $state = floatval($order_info['shipping_fee']) > 0 && $state;
        	   break;

        	//发货
        	case 'send':
        	    $state = !$order_info['lock_state'] && $order_info['order_state'] == ORDER_STATE_PAY;
        	    break;

        	//收货
    	    case 'receive':
    	       // $state = !$order_info['lock_state'] && $order_info['order_state'] == ORDER_STATE_SEND;
			  	 $state = $order_info['order_state'] == ORDER_STATE_SEND;
    	        break;

    	    //评价
    	    case 'evaluation':
    	        $state = !$order_info['lock_state'] && !intval($order_info['evaluation_state']) && $order_info['order_state'] == ORDER_STATE_SUCCESS &&
    	         TIMESTAMP - intval($order_info['finnshed_time']) < ORDER_EVALUATE_TIME;
    	        break;

        	//锁定
        	case 'lock':
        	    $state = intval($order_info['lock_state']) ? true : false;
        	    break;

        	//快递跟踪
        	case 'deliver':
        	   // $state = !empty($order_info['shipping_code']) && in_array($order_info['order_state'],array(ORDER_STATE_SEND,ORDER_STATE_SUCCESS));
			  //  $state = !empty($order_info['shipping_code']) && in_array($order_info['order_state'],array(ORDER_STATE_SEND)); 
				  $state =  in_array($order_info['order_state'],array(ORDER_STATE_SEND)); 
        	    break;

        	//分享
        	case 'share':
        	    $state = $order_info['order_state'] == ORDER_STATE_SUCCESS;
        	    break;

        }
        return $state;

    }
    
    /**
     * 联查订单表订单商品表
     *
     * @param array $condition
     * @param string $field
     * @param number $page
     * @param string $order
     * @return array
     */
    public function getOrderAndOrderGoodsList($condition, $field = '*', $page = 0, $order = 'rec_id desc') {
        return $this->table('order_goods,order')->join('inner')->on('order_goods.order_id=order.order_id')->where($condition)->field($field)->page($page)->order($order)->select();
    }
    
    /**
     * 订单销售记录 订单状态为20、30、40时
     * @param unknown $condition
     * @param string $field
     * @param number $page
     * @param string $order
     */
    public function getOrderAndOrderGoodsSalesRecordList($condition, $field="*", $page = 0, $order = 'rec_id desc') {
        $condition['order_state'] = array('in', array(ORDER_STATE_PAY, ORDER_STATE_SEND, ORDER_STATE_SUCCESS));
        return $this->getOrderAndOrderGoodsList($condition, $field, $page, $order);
    }

	/**
	 * 买家订单状态操作
	 *
	 */
	public function memberChangeState($state_type, $order_info, $member_id, $member_name, $extend_msg) {
		try {

		    $this->beginTransaction();

		    if ($state_type == 'order_cancel') {
		        $this->_memberChangeStateOrderCancel($order_info, $member_id, $member_name, $extend_msg);
		        $message = '成功取消了订单';
		    } elseif ($state_type == 'order_receive') {
		        $this->_memberChangeStateOrderReceive($order_info, $member_id, $member_name, $extend_msg);
		        $message = '订单交易成功,您可以评价本次交易';
		    }

		    $this->commit();
            return array('success' => $message);

		} catch (Exception $e) {
		    $this->rollback();
            return array('error' => $message);
		}

	}

	/**
	 * 取消订单操作
	 * @param unknown $order_info
	 */
	private function _memberChangeStateOrderCancel($order_info, $member_id, $member_name, $extend_msg) {
        $order_id = $order_info['order_id'];
        $if_allow = $this->getOrderOperateState('buyer_cancel',$order_info);
        if (!$if_allow) {
            throw new Exception('非法访问');
        }

        $goods_list = $this->getOrderGoodsList(array('order_id'=>$order_id));
        $model_goods= Model('goods');
        if(is_array($goods_list) && !empty($goods_list)) {
            $data = array();
            foreach ($goods_list as $goods) {
                $data['goods_storage'] = array('exp','goods_storage+'.$goods['goods_num']);
                $data['goods_salenum'] = array('exp','goods_salenum-'.$goods['goods_num']);
                $update = $model_goods->editGoods($data,array('goods_id'=>$goods['goods_id']));
                if (!$update) {
                    throw new Exception('保存失败');
                }
            }
        }
        
        //解冻预存款
        $pd_amount = floatval($order_info['pd_amount']);
        if ($pd_amount > 0) {
            $model_pd = Model('predeposit');
            $data_pd = array();
            $data_pd['member_id'] = $member_id;
            $data_pd['member_name'] = $member_name;
            $data_pd['amount'] = $pd_amount;
            $data_pd['order_sn'] = $order_info['order_sn'];
            $model_pd->changePd('order_cancel',$data_pd);
        }

        //更新订单信息
        $update_order = array('order_state' => ORDER_STATE_CANCEL, 'pd_amount' => 0);
        $update = $this->editOrder($update_order,array('order_id'=>$order_id));
        if (!$update) {
            throw new Exception('保存失败');
        }

        //添加订单日志
        $data = array();
        $data['order_id'] = $order_id;
        $data['log_role'] = 'buyer';
        $data['log_msg'] = '取消了订单';
        if ($extend_msg) {
            $data['log_msg'] .= ' ( '.$extend_msg.' )';
        }
        $data['log_orderstate'] = ORDER_STATE_CANCEL;
        $this->addOrderLog($data);
	}

/**
 * [getGoodsNum 获取微仓库存]
 * @return [type]
 */
public function getGoodsNum($good){
    $num = 0;
    if($_SESSION['member_id'] && $good['goods_id']){
        $model = Model();
        $on = 'order_goods.order_id = order.order_id';
        $num = $model->table('order,order_goods')->join('inner')->on($on)->where('order_goods.goods_id='.$good['goods_id'].' AND order.order_state=\'20\' AND order_goods.buyer_id='.$_SESSION['member_id'])->sum('order_goods.goods_num');
    }
    return $num;
}
/**
 * [minusGoods 减仓]
 * @param  [good]
 * array('goods_id'=>1, 'buyer_id'=>1, 'buyer_num'=>1, ...) or
 * array(array('goods_id'=>1, 'buyer_id'=>1, 'buyer_num'=>1, ...),
 *          array('goods_id'=>1, 'buyer_id'=>1, 'buyer_num'=>1, ...), ...)
 * @return [null]
 */
public function minusGoods($good){
    if(isset($good['goods_id'])){
        $gids = $good['goods_id'];
        $buyer_id = $good['buyer_id'];
        $sell[$good['goods_id']] = $good['buyer_num'];  //绑定数量
    }else
        foreach ($good as $v) {
            $gids .= isset($gids) ? ','.$v['goods_id'] : $v['goods_id'];
            if(!isset($buyer_id)) $buyer_id = $v['buyer_id'];
            $sell[$v['goods_id']] = $v['buyer_num'];
        }
    $modle = Model();
    $on = 'order_goods.order_id = order.order_id';
    $rows = $modle->table('order,order_goods')->field('order_goods.goods_num, order_goods.order_id,order_goods.goods_id')->join('inner')->on($on)->where('order_goods.goods_id in ('.$gids.') AND order.order_state=\'20\' AND order_goods.buyer_id='.$buyer_id.' AND order_goods.goods_num > 0')->order('order_goods.order_id DESC')->select();
    foreach ($rows as $v) {
        if($sell[$v['goods_id']] <= 0) continue;
        $row = array('goods_num' => max(0, $v['goods_num'] - $sell[$v['goods_id']]));
        $table = Model('order_goods');
        $table->where('goods_id='.$v['goods_id'].' AND order_id='.$v['order_id'])->update($row); $sell[$v['goods_id']] -= $v['goods_num'];
    }unset($good, $sell, $modle, $table, $rows);
}

//=========array_column======

//if(function_exists('array_column'))die('exits');
 public function array_column($input, $columnKey, $indexKey = NULL)
  {
    $columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
    $indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
    $indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
    $result = array();
 
    foreach ((array)$input AS $key => $row)
    { 
      if ($columnKeyIsNumber)
      {
        $tmp = array_slice($row, $columnKey, 1);
        $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
      }
      else
      {
        $tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
      }
      if ( ! $indexKeyIsNull)
      {
        if ($indexKeyIsNumber)
        {
          $key = array_slice($row, $indexKey, 1);
          $key = (is_array($key) && ! empty($key)) ? current($key) : NULL;
          $key = is_null($key) ? 0 : $key;
        }
        else
        {
          $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
        }
      }
 
      $result[$key] = $tmp;
    }
 
    return $result;
  }
//=========array_column=====

	/**
	 * 收货操作
	 * @param unknown $order_info
	 */
	private function _memberChangeStateOrderReceive($order_info, $member_id, $member_name, $extend_msg) {
	    $order_id = $order_info['order_id'];

	    //更新订单状态
        $update_order = array();
        $update_order['finnshed_time'] = TIMESTAMP;
	    $update_order['order_state'] = ORDER_STATE_SUCCESS;
	    $update = $this->editOrder($update_order,array('order_id'=>$order_id));
	    if (!$update) {
	        throw new Exception('保存失败');
	    }

	    //添加订单日志
	    $data = array();
	    $data['order_id'] = $order_id;
	    $data['log_role'] = 'buyer';
	    $data['log_msg'] = '签收了货物';
	    if ($extend_msg) {
	        $data['log_msg'] .= ' ( '.$extend_msg.' )';
	    }
	    $data['log_orderstate'] = ORDER_STATE_SUCCESS;
	    $this->addOrderLog($data);

	    //确认收货时添加会员积分
	    if (C('points_isuse') == 1){
	        $points_model = Model('points');
	        $points_model->savePointsLog('sell_order',array('pl_memberid'=>$member_id,'pl_membername'=>$member_name,'orderprice'=>$order_info['order_amount'],'order_sn'=>$order_info['order_sn'],'order_id'=>$order_info['order_id']),true);
	    }
	}
}
