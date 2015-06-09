<?php
defined('ZQ-SHOP') or exit('Access Invalid!');
/**
 * 汇率控制器
 */
class exchange_rateControl extends SystemControl {
    
    public function __construct(){
        parent::__construct();
    }

    public function indexOp(){
        $table = Model('rate');
        $row = $table->where('addtime >='.strtotime(date('Y-m-d')))->find();
        $rows = $table->where('addtime <'.strtotime(date('Y-m-d')))->page(6)->order('id DESC')->select();
        try{
            $rate = $this->getRate();
        }catch(Exception $e){
            echo $e->getMessage();
        }
        TPL::output('rate', $rate);
        TPL::output('today_rate', $row);
        TPL::output('data', $rows);
        TPL::showpage('exchange_rate.index');
    }

    public function storeOp(){
        $table = Model('rate');
        $row = $table->field('id')->where('addtime >= '.strtotime(date('Y-m-d')))->find();
        if($row){
            echo '今日已经提取过了。';
        }else{
            $rate = $this->getRate();
            if($rate){
                $data['rate'] = $rate;
                $data['addtime'] = isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time();
                $table->insert($data);
                echo '提取成功';
            }else{
                echo '提取失败';
            }
        }
    }

    public function updateOp(){
        $table = Model('rate');
        $id = intval($_POST['id']);
        $rate = is_numeric($_POST['rate']) ? $_POST['rate'] : 0;
        $admin_info = $this->getAdminInfo();
        if($id){
            if($rate > 0){
                $table->where(array('id'=>$id))->update(array('rate'=>$rate, 'editor_name'=>$admin_info['name'], 'updatetime'=>$_SERVER['REQUEST_TIME']));
                echo '修改成功';
            }else{
                echo '提交错误';
            }
        }else{
            echo '提交错误';
        }
    }

    /**
     * [getRate 汇率]
     * @return [type] [description]
     */
    public function getRate(){
        $num = 0;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://srh.bankofchina.com/search/whpj/search.jsp');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('pjname'=>1323)));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 BIDUBrowser/7.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt ($ch, CURLOPT_REFERER, 'http://www.boc.cn/sourcedb/whpj/');
        $contents = curl_exec($ch);
        if(curl_errno($ch))
            throw new Exception('Curl error: '.curl_error($ch));
        curl_close($ch);
        if($contents){
            preg_match('/<td>日元<\/td>([^<]*<td>[^<]*<\/td>){2}[^<]*<td>([^<]*)<\/td>/i', $contents, $matchs);
            if(isset($matchs[2]))
                $num = $matchs[2];
        }
        return $num;
    }
}