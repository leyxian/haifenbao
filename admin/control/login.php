<?php
/**
 * 登录
 *
 * 包括 登录 验证 退出 操作
 *
 *
 */
defined('ZQ-SHOP') or exit('Access Invalid!');
class LoginControl extends SystemControl {

	/**
	 * 不进行父类的登录验证，所以增加构造方法重写了父类的构造方法
	 */
	public function __construct(){
		Language::read('common,layout,login');
		$result = chksubmit(true,true,'num');
		if ($result){
		    if ($result === -11){
		        showMessage('非法请求');
		    }elseif ($result === -12){
		        showMessage(L('login_index_checkcode_wrong'));
		    }
		    if (processClass::islock('admin')) {
		        showMessage('您的操作过于频繁，请稍后再试');
		    }
			//登录验证
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["user_name"],		"require"=>"true", "message"=>L('login_index_username_null')),
			array("input"=>$_POST["password"],		"require"=>"true", "message"=>L('login_index_password_null')),
			array("input"=>$_POST["captcha"],		"require"=>"true", "message"=>L('login_index_checkcode_null')),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage(L('error').$error);
			}else {
				$model_admin = Model('admin');
				$array	= array();
				$array['admin_name']	= $_POST['user_name'];
				$array['admin_password']= md5(trim($_POST['password']));
				$admin_info = $model_admin->infoAdmin($array);
				if(is_array($admin_info) and !empty($admin_info)) {

					$this->systemSetKey(array('name'=>$admin_info['admin_name'], 'id'=>$admin_info['admin_id'],'gid'=>$admin_info['admin_gid'],'sp'=>$admin_info['admin_is_super']));
					$update_info	= array(
					'admin_id'=>$admin_info['admin_id'],
					'admin_login_num'=>($admin_info['admin_login_num']+1),
					'admin_login_time'=>TIMESTAMP
					);
					$model_admin->updateAdmin($update_info);
					$_SESSION['store_id'] = $admin_info['store_id'];
					$_SESSION['is_login'] = '1';
					
	//获取前台商家登陆信息并存入Session:以便添加商品:					
	        $model_seller = Model('seller');
	        $seller_info = $model_seller->getSellerInfo(array('seller_name' => $_POST['user_name']));
	        if($seller_info) {	
	            $model_member = Model('member');
	            $member_info = $model_member->infoMember(
	                array(
	                    'member_id' => $seller_info['member_id'],
	                    //'member_passwd' => md5($_POST['password'])
	                )
	            );
	            if($member_info) {
	                // 更新卖家登陆时间
					$update_sell_info	= array(
					'seller_id'=>$seller_info['seller_id'],
					'last_login_time'=>TIMESTAMP
					);	                
	                $model_admin->updateSeller($update_sell_info);
	                	
	               // $model_seller_group = Model('seller_group');
	              //  $seller_group_info = $model_seller_group->getSellerGroupInfo(array('group_id' => $seller_info['seller_group_id']));
	
	                $model_store = Model('store');
	                $store_info = $model_store->getStoreInfoByID($seller_info['store_id']);
	
	                $_SESSION['is_login'] = '1';
	                $_SESSION['member_id'] = $member_info['member_id'];
	                $_SESSION['member_name'] = $member_info['member_name'];
	    			$_SESSION['member_email'] = $member_info['member_email'];
	    			$_SESSION['is_buy']	= $member_info['is_buy'];
	    			$_SESSION['avatar']	= $member_info['member_avatar'];
	
	                $_SESSION['grade_id'] = $store_info['grade_id'];
	                $_SESSION['seller_id'] = $seller_info['seller_id'];
	                $_SESSION['seller_name'] = $seller_info['seller_name'];
	                $_SESSION['seller_is_admin'] = intval($seller_info['is_admin']);
	                $_SESSION['store_id'] = intval($seller_info['store_id']);
	                $_SESSION['store_name']	= $store_info['store_name'];
	               // $_SESSION['seller_limits'] = explode(',', $seller_group_info['limits']);
	               // if($seller_info['is_admin']) {
	                    $_SESSION['seller_group_name'] = '管理员';
	                //} else {
	               //     $_SESSION['seller_group_name'] = $seller_group_info['group_name'];
	                //}
	                if(!$seller_info['last_login_time']) {
	                    $seller_info['last_login_time'] = TIMESTAMP;
	                }
	                $_SESSION['seller_last_login_time'] = date('Y-m-d H:i', $seller_info['last_login_time']);
	                $seller_menu = $this->getSellerMenuList($seller_info['is_admin'], explode(',', $seller_group_info['limits']));
	                $_SESSION['seller_menu'] = $seller_menu['seller_menu'];
	                $_SESSION['seller_function_list'] = $seller_menu['seller_function_list'];
	                if(!empty($seller_info['seller_quicklink'])) {
	                    $quicklink_array = explode(',', $seller_info['seller_quicklink']);
	                    foreach ($quicklink_array as $value) {
	                        $_SESSION['seller_quicklink'][$value] = $value ;
	                    }
	                }
	               // $this->recordSellerLog('登录成功');
	               // showMessage('登录成功', 'index.php?act=seller_center');
	            } else {
	                showMessage('用户名密码错误', '', '', 'error');
	            }
	        }else {
          	  showMessage('用户名密码错误', '', '', 'error');
       		 }			
					
					$this->log(L('nc_login'),1);
					processClass::clear('admin');
					@header('Location: index.php');exit;
				}else {
				    processClass::addprocess('admin');
					showMessage(L('login_index_username_password_wrong'),'index.php?act=login&op=login');
				}
			}
		}
		Tpl::output('html_title',$lang['login_index_need_login']);
		Tpl::showpage('login','login_layout');	
		
	}
	
	
	//==============
    public function getSellerMenuList($is_admin, $limits) {
        $seller_menu = array();
            $seller_menu = $this->getMenuList();     
        $seller_function_list = $this->getSellerFunctionList($seller_menu);
        return array('seller_menu' => $seller_menu, 'seller_function_list' => $seller_function_list);
    }

	//===============
    public function getSellerFunctionList($menu_list) {
        $format_menu = array();
        foreach ($menu_list as $key => $menu_value) {
            foreach ($menu_value['child'] as $submenu_value) {
                $format_menu[$submenu_value['act']] = array(
                    'model' => $key,
                    'model_name' => $menu_value['name'],
                    'name' => $submenu_value['name'],
                    'act' => $submenu_value['act'],
                    'op' => $submenu_value['op'],
                );
            }
        }
        return $format_menu;
    }    
    
  //====================
	    public function getMenuList() {
        $menu_list = array(
            'goods' => array('name' => '商品', 'child' => array(
                array('name' => '商品发布', 'act'=>'store_goods_add', 'op'=>'index'),
                array('name' => '出售中的商品', 'act'=>'store_goods_online', 'op'=>'index'),
                array('name' => '仓库中的商品', 'act'=>'store_goods_offline', 'op'=>'index'),
                array('name' => '库存警报', 'act'=>'store_storage_alarm', 'op' => 'index'),
                array('name' => '关联板式', 'act'=>'store_plate', 'op'=>'index'),
                array('name' => '商品规格', 'act' => 'store_spec', 'op' => 'index'),
                array('name' => '图片空间', 'act'=>'store_album', 'op'=>'album_cate'),
            )),
            'order' => array('name' => '订单', 'child' => array(
                array('name' => '订单管理', 'act'=>'store_order', 'op'=>'index'),
                array('name' => '发货', 'act'=>'store_deliver', 'op'=>'index'),
                array('name' => '发货设置', 'act'=>'store_deliver_set', 'op'=>'daddress_list'),
                array('name' => '评价管理', 'act'=>'store_evaluate', 'op'=>'list'),
                array('name' => '打印设置', 'act'=>'store_printsetup', 'op'=>'index'),
            ))     
        );
        return $menu_list;
    }    
  //=================  		
	
	
	
	public function loginOp(){}
	public function indexOp(){}
    
	
}
