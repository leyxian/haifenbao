<?php
defined('ZQ-SHOP') or exit('Access Invalid!');

class shipping_feeControl extends SystemControl{

    const EXPORT_SIZE = 1000;

    public function __construct(){
        parent::__construct();
    }

    /**
     * [indexOp 物流查询]
     * @return [type] [description]
     */
    public function indexOp(){
        $orderModel = Model('order');
        $where = 'order_state in (\'30\', \'40\')';
        if($_GET['type']==1)
            $where .= ' AND shipping_fee > 0';
        elseif($_GET['type']==2)
            $where .= ' AND shipping_fee = 0';
        if($_GET['order_sn'])
            $where .= ' AND order_sn like \'%'.$_GET['order_sn'].'%\'';
        $rows = $orderModel->table('order')->page(10)->where($where)->order('order_id DESC')->select();
        TPL::output('page', $orderModel->showpage(2));
        TPL::output('list', $rows);
        TPL::showpage('shipping_fee.index');
    }

    /**
     * [export_indexOp 导出]
     * @return [type] [description]
     */
    public function export_indexOp(){
        $lang   = Language::getLangContent();
        $model_order = Model('order');
        $where = 'order_state in (\'30\', \'40\')';
        if($_GET['type']==1)
            $where .= ' AND shipping_fee > 0';
        elseif($_GET['type']==2)
            $where .= ' AND shipping_fee = 0';
        if($_GET['order_sn'])
            $where .= ' AND order_sn like \'%'.$_GET['order_sn'].'%\'';
        if(!is_numeric($_GET['curpage'])){
            $count = $model_order->getOrderCount($where);
            $array = array();
            if($count > self::EXPORT_SIZE){
                $page = ceil($count/self::EXPORT_SIZE);
                for ($i=1;$i<=$page;$i++){
                    $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
                    $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
                    $array[$i] = $limit1.' ~ '.$limit2 ;
                }
                Tpl::output('list',$array);
                Tpl::output('murl','index.php?act=shipping_fee&op=index');
                Tpl::showpage('export.excel');
            }else{
                $data = $model_order->getOrderList($where,'','order_sn,add_time,payment_time,shipping_fee,shipping_code','order_id desc',self::EXPORT_SIZE);
                $this->createExcel($data);
            }
        }else{
            $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $model_order->getOrderList($condition,'','order_sn,add_time,payment_time,shipping_fee,shipping_code','order_id desc',"{$limit1},{$limit2}");
            $this->createExcel($data);
        }
    }

    /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel($data = array()){
        Language::read('export');
        import('libraries.excel');
        $excel_obj = new Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //header
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单编号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'下单时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'付款时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'运费');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'物流单号');
        //data
        foreach ((array)$data as $k=>$v){
            $tmp = array();
            $tmp[] = array('data'=>'NC'.$v['order_sn']);
            $tmp[] = array('data'=>date('Y-m-d H:i:s',$v['add_time']));
            $tmp[] = array('data'=>$v['payment_time'] ? date('Y-m-d H:i:s', $v['payment_time']) : '');
            $tmp[] = array('format'=>'Number', 'data'=>$v['shipping_fee']);
            $tmp[] = array('data'=>$v['shipping_code']);
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(L('exp_od_order'),CHARSET));
        $excel_obj->generateXML($excel_obj->charset(L('exp_od_order'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
    }
}