<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/21 0021
 * Time: 09:51
 */

namespace app\admin\controller;
use app\service\OrderLogistics;
use app\service\PayService;
use app\service\StatisticalService;
use phpmailer\PHPMailer;
use think\Db;
use app\service\OrderService;
use app\service\PaymentService;
use app\service\ExpressService;
use app\service\Talk;
use think\response\Json;


class Zoology extends Common
{

    //public $prefix = "D:/PhpStudy20180211/PHPTutorial/WWW/shop/public/static/total";
    public function index()
    {
        // 系统信息
        $mysql_ver = db()->query('SELECT VERSION() AS `ver`');
        $data = array(
            'server_ver'	=>	php_sapi_name(),
            'php_ver'		=>	PHP_VERSION,
            'mysql_ver'		=>	isset($mysql_ver[0]['ver']) ? $mysql_ver[0]['ver'] : '',
            'os_ver'		=>	PHP_OS,
            'host'			=>	isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : '',
            'ver'			=>	'ShopXO'.' '.APPLICATION_VERSION,
        );
        $this->assign('data', $data);

        // 用户
        $user = StatisticalService::UserYesterdayTodayTotal();
        $this->assign('user', $user['data']);

        // 订单总数
        $order_number = StatisticalService::OrderNumberYesterdayTodayTotal();
        $this->assign('order_number', $order_number['data']);

        // 订单成交总量
        $order_complete_number = StatisticalService::OrderCompleteYesterdayTodayTotal();
        $this->assign('order_complete_number', $order_complete_number['data']);

        // 订单收入总计
        $order_complete_money = StatisticalService::OrderCompleteMoneyYesterdayTodayTotal();
        $this->assign('order_complete_money', $order_complete_money['data']);

        // 近7日订单交易走势
        $order_trading_trend = StatisticalService::OrderTradingTrendSevenTodayTotal();
        $this->assign('order_trading_trend', $order_trading_trend['data']);

        // 近7日订单支付方式
        $order_type_number = StatisticalService::OrderPayTypeSevenTodayTotal();
        $this->assign('order_type_number', $order_type_number['data']);

        // 近7日热销商品
        $goods_hot_sale = StatisticalService::GoodsHotSaleSevenTodayTotal();
        $this->assign('goods_hot_sale', $goods_hot_sale['data']);

        return $this->fetch();
    }


    /**
     * 用户访问量统计
     */
    public function UserAccess()
    {
        $params = input();
        $ip = $_SERVER['SERVER_ADDR'];
        if(!empty($params)){
            $addtime = strtotime($params['time_start']);
            $updtime = strtotime($params['time_end']);
            $data = Db::name("user_access")->where([["add_time",">=",$addtime],["add_time","<",$updtime]])->count();
            $this->assign("data",$data);
            $this->assign("addtime",date("Y-m-d",$addtime));
            $this->assign("updtime",date("Y-m-d",$updtime));
        }else{
            $start = strtotime(date("Y-m-d 00:00:00"));
            $end = strtotime(date("Y-m-d 00:00:00",time()+3600*24));
            $Wstart = strtotime(date("Y-m-d 00:00:00",time()-7*3600*24));
            $Mstart = strtotime(date("Y-m-1 00:00:00"));
            $Ystart = strtotime(date("Y-1-1 00:00:00"));
            $day = Db::name("user_access")->where([['add_time',">=",$start],["add_time","<",$end]])->count();
            $Week = Db::name("user_access")->where([['add_time',">=",$Wstart],["add_time","<",$end]])->count();
            $Month = Db::name("user_access")->where([['add_time',">=",$Mstart],["add_time","<",$end]])->count();
            $Year= Db::name("user_access")->where([['add_time',">=",$Ystart],["add_time","<",$end]])->count();
            $this->assign("day",$day);
            $this->assign("Week",$Week);
            $this->assign("Month",$Month);
            $this->assign("Year",$Year);
        }
        $this->assign("params",$params);
        return $this->fetch();
    }

    /**
     * 订单总量统计
     * @return mixed
     */
    public function OrderFlow()
    {
        $params = input();
        if(!empty($params)){
            $addtime = strtotime($params['time_start']);
            $updtime = strtotime($params['time_end']);
            $data = Db::name("order")->where([["add_time",">=",$addtime],["upd_time","<",$updtime]])->count();
            $this->assign("data",$data);
            $this->assign("addtime",date("Y-m-d",$addtime));
            $this->assign("updtime",date("Y-m-d",$updtime));
        }else{
            $start = strtotime(date("Y-m-d 00:00:00"));
            $end = strtotime(date("Y-m-d 00:00:00",time()+3600*24));
            $Wstart = strtotime(date("Y-m-d 00:00:00",time()-7*3600*24));
            $Mstart = strtotime(date("Y-m-1 00:00:00"));
            $Ystart = strtotime(date("Y-1-1 00:00:00"));
            $day = Db::name("order")->where([['add_time',">=",$start],["add_time","<=",$end]])->count();
            $Week = Db::name("order")->where([['add_time',">=",$Wstart],["add_time","<=",$end]])->count();
            $Month = Db::name("order")->where([['add_time',">=",$Mstart],["add_time","<=",$end]])->count();
            $Year= Db::name("order")->where([['add_time',">=",$Ystart],["add_time","<=",$end]])->count();
            $this->assign("day",$day);
            $this->assign("Week",$Week);
            $this->assign("Month",$Month);
            $this->assign("Year",$Year);
        }
        $this->assign("params",$params);
        return $this->fetch();
    }

    /**
     * 订单成交量统计
     */
    public function OrderSuccess()
    {
        $params = input();
        if(!empty($params)){
            $addtime = strtotime($params['time_start']);
            $updtime = strtotime($params['time_end']);
            $data = Db::name("order")->where([["upd_time",">=",$addtime],["upd_time","<",$updtime],['status','=','4']])->count();
            $this->assign("data",$data);
            $this->assign("addtime",date("Y-m-d",$addtime));
            $this->assign("updtime",date("Y-m-d",$updtime));
        }else{
            $start = strtotime(date("Y-m-d 00:00:00"));
            $end = strtotime(date("Y-m-d 00:00:00",time()+3600*24));
            $Wstart = strtotime(date("Y-m-d 00:00:00",time()-7*3600*24));
            $Mstart = strtotime(date("Y-m-1 00:00:00"));
            $Ystart = strtotime(date("Y-1-1 00:00:00"));

            $day = Db::name("order")->where([['upd_time',">=",$start],["upd_time","<=",$end],['status','=','4']])->count();
            $Week = Db::name("order")->where([['upd_time',">=",$Wstart],["upd_time","<=",$end],['status','=','4']])->count();
            $Month = Db::name("order")->where([['upd_time',">=",$Mstart],["upd_time","<=",$end],['status','=','4']])->count();
            $Year= Db::name("order")->where([['upd_time',">=",$Ystart],["upd_time","<=",$end],['status','=','4']])->count();
            $this->assign("day",$day);
            $this->assign("Week",$Week);
            $this->assign("Month",$Month);
            $this->assign("Year",$Year);
        }
        $this->assign("params",$params);
        return $this->fetch();
    }

    /**
     * 订单的总收入统计
     */
    public function OrderIncome()
    {
        $params = input();
        if(!empty($params)){
            $addtime = strtotime($params['time_start']);
            $updtime = strtotime($params['time_end']);
            $data = Db::name("order")->field("sum(total_price)")->where([["upd_time",">=",$addtime],["upd_time","<",$updtime],['status','=','4']])->select();
            $this->assign("data",$data);
            $this->assign("addtime",date("Y-m-d",$addtime));
            $this->assign("updtime",date("Y-m-d",$updtime));
        }else{
            $start = strtotime(date("Y-m-d 00:00:00"));
            $end = strtotime(date("Y-m-d 00:00:00",time()+3600*24));
            $Wstart = strtotime(date("Y-m-d 00:00:00",time()-7*3600*24));
            $Mstart = strtotime(date("Y-m-1 00:00:00"));
            $Ystart = strtotime(date("Y-1-1 00:00:00"));

            $day = Db::name("order")->field("sum(total_price)")->where([['upd_time',">=",$start],["upd_time","<=",$end],['status','=','4']])->select();
            $Week = Db::name("order")->field("sum(total_price)")->where([['upd_time',">=",$Wstart],["upd_time","<=",$end],['status','=','4']])->select();
            $Month = Db::name("order")->field("sum(total_price)")->where([['upd_time',">=",$Mstart],["upd_time","<=",$end],['status','=','4']])->select();
            $Year= Db::name("order")->field("sum(total_price)")->where([['upd_time',">=",$Ystart],["upd_time","<=",$end],['status','=','4']])->select();
            $this->assign("day",$day);
            $this->assign("Week",$Week);
            $this->assign("Month",$Month);
            $this->assign("Year",$Year);
        }
        $this->assign("params",$params);
        return $this->fetch();
    }

    /**
     * 管理员与用户沟通页面
     * @return mixed
     */
    public function Chat(){
        $params = [];
        $params['user_list'] = Talk::GetTalkUser();
        $this->assign('user_list',$params['user_list']);
        return $this->fetch();
    }

    //修改状态
    public function ReadMes(){
        $params = $_GET;
        $data = Talk::Read($params);

        return ;
    }



    public function Chatp(){
        return $this->fetch();
    }

    /**
     * 正在沟通的用户列表
     */
    public function UserList(){
        $list = Talk::GetUserList();
        return json_encode($list);
    }

    /**
     * AJAX获取用户聊天记录
     */
    public function GetUserChat()
    {
        if (isset($_GET['username'])) {
            $username = $_GET['username'];
        } else {
            $username = $_COOKIE['username'];
        }
        $data = Talk::GetUserRecord($username);
        if (!$data) {
            $data = Talk::CreateChat($username);
        }
        foreach ($data as $k=>$v){
            if($data[$k]['post'] == '客服'){
                $data[$k]['code'] = 1;
            }else{
                $data[$k]['code'] = 0;
            }
        }
        return json_encode($data);
    }

    public function GetUserList(){
        $data = Talk::GetTalkUser();
        return $data;
    }

    /**
     * 邮箱管理
     */
    public function email()
    {
        if(request()->isPost()){
            $arr = request()->post();
            if(empty($arr['email'])  && $arr['Addressee'] == null  ){
                return DataReturn('收件人不能为空',-1);

            }
            $patten = "/^((([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6}\,))*(([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})))$/";
            if(!empty($arr['email'])){
                preg_match($patten,$arr['email'],$matches);
                if(empty($matches)){
                    return DataReturn('请输入合法的收件人邮箱',-1);
                }
            }
            // 引入PHPMailer的核心文件
            require_once("PHPMailer/class.phpmailer.php");
            require_once("PHPMailer/class.smtp.php");

            // 实例化PHPMailer核心类
            $mail = new PHPMailer();
            //echo "<pre>";
            //var_dump($mail);
            // 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
            $mail->SMTPDebug = 1;
            // 使用smtp鉴权方式发送邮件
            $mail->isSMTP();
            // smtp需要鉴权 这个必须是true
            $mail->SMTPAuth = true;
            // 链接qq域名邮箱的服务器地址
            $mail->Host = $arr['smpt'];
            // 设置使用ssl加密方式登录鉴权
            $mail->SMTPSecure = 'ssl';
            // 设置ssl连接smtp服务器的远程服务器端口号
            $mail->Port = 465;
            // 设置发送的邮件的编码
            $mail->CharSet = 'UTF-8';
            // 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
            $mail->FromName = $arr['account'];
            // smtp登录的账号 QQ邮箱即可
            $mail->Username = $arr['account'];//'1253199086@qq.com';
            // smtp登录的密码 使用生成的授权码
            $mail->Password = $arr['pwd'];//rnhmuupggplkhdee璐   //cjgszfytbxtobecb张豹
            // 设置发件人邮箱地址 同登录账号
            $mail->From =  $arr['account'];//'1253199086@qq.com';
            // 邮件正文是否为html编码 注意此处是一个方法
            $mail->isHTML(true);
            // 设置收件人邮箱地址

            if(!empty($arr['email'])){
                $length = explode(",",$arr['email']);
                if(count($length) == 1){
                    $mail->addAddress($arr['email']);
                }else{
                    foreach($length as $val){
                        $mail->addAddress($val['email']);
                    }
                }
            }else{
                if($arr['Addressee'] == '0'){
                    $array = Db::name("user")->select();
                    if(!empty($array)){
                        foreach($array as $val){
                            if($val['email'] != ""){
                                $mail->addAddress($val['email']);
                            }
                        }
                    }else{
                        echo "没有用户";exit;
                    }
                }else if($arr['Addressee'] == '1'){
                    $array = Db::name("user")->where(["grade"=>1])->select();
                    if(!empty($array)){
                        foreach($array as $val){
                            if($val['email'] != ""){
                                $mail->addAddress($val['email']);
                            }
                        }
                    }else{
                        return DataReturn('没有该等级的用户',-1);
                    }
                }else if($arr['Addressee'] == "2"){
                    $array = Db::name("user")->where(["grade"=>2])->select();
                    if(!empty($array)){
                        foreach($array as $val){
                            if($val['email'] != ""){
                                $mail->addAddress($val['email']);
                            }
                        }
                    }else{
                        return DataReturn('没有该等级的用户',-1);
                    }
                }else if($arr['Addressee'] == '3'){
                    $array = Db::name("user")->where(["grade"=>3])->select();
                    if(!empty($array)){
                        foreach($array as $val){
                            if($val['email'] != ""){
                                $mail->addAddress($val['email']);
                            }
                        }
                    }else{
                        return DataReturn('没有该等级的用户',-1);
                    }
                }
            }
            //$mail->addAddress('1622549206@qq.com');
            // 添加多个收件人 则多次调用方法即可
            //$mail->addAddress('1021069236@qq.com');//1205645256
            // 添加该邮件的主题
            $mail->Subject = $arr['title'];
            // 添加邮件正文
            $mail->Body = '<h1>'.$arr['body'].'</h1>';
            // 为该邮件添加附件
            //$mail->addAttachment('./example.pdf');
            // 发送邮件 返回状态
            $status = $mail->send();
            //return $this->fetch(['status',$status]);
        }else{

            $arr = Db::name("role")->field("id,name")->select();
            $grade = Db::name("user_grade")->field("id,grade")->select();
            $this->assign('arr',$arr);
            $this->assign('grade',$grade);
            return $this->fetch();
        }
    }

    /**
     * 插入聊天内容
     */
    public function PostImg(){
        if(isset($_FILES["myFile"]))
        {
            $ret = array();  //用来保存图片上传之后的路径，文件名
            $uploadDir = 'images'.DIRECTORY_SEPARATOR.date("Y/m/d").DIRECTORY_SEPARATOR;  // DIRECTORY_SEPARATOR常量，解析后为"/"为了兼容不同系统之间路径写法的区别
            $dir = dirname("./public/static/chatImg").DIRECTORY_SEPARATOR.$uploadDir; //路径名
            file_exists($dir) || (mkdir($dir,0777,true) && chmod($dir,0777));
            if(!is_array($_FILES["myFile"]["name"])) //single file
            {
                $fileName = time().uniqid().'.'.pathinfo($_FILES["myFile"]["name"])['extension'];
                move_uploaded_file($_FILES["myFile"]["tmp_name"],$dir.$fileName); //移动到指定$dir 目录下，该目录不存在会自动创建，重命名上传的文件$ret['file'] = DIRECTORY_SEPARATOR.$uploadDir.$fileName;
                $path = $dir.$fileName;
                $parmas = $_POST;
                $parmas['image'] = $path;
                $is_ok = Talk::PostContent($parmas);
                $is_ok = $is_ok[0];
                if($is_ok['post'] == '客服'){
                    $is_ok['code'] = 1;
                }else{
                    $is_ok['code'] = 0;
                }

                if(!$is_ok){
                    return '';
                }
                return json_encode($is_ok);
            }
            return json_encode(['message'=>'发送失败','code'=>500]);

        }else{

            $parmas = $_POST;
            unset($parmas['myfile']);
            $data = Talk::PostContent($parmas);
            $data = $data[0];
            if($data['post'] == '客服'){
                $data['code'] = 1;
            }else{
                $data['code'] = 0;
            }
            if(!$data){
                return json_encode(['message'=>'发送失败','code'=>500]);
            }
            return json_encode($data);
        }
    }

    /**
     * @return mixed保存图片返回途径
     */
    public function PostImage(){
        if(isset($_FILES["myFile"])) {
            $ret = array();  //用来保存图片上传之后的路径，文件名
            $uploadDir = 'images' . DIRECTORY_SEPARATOR . date("Y/m/d") . DIRECTORY_SEPARATOR;  // DIRECTORY_SEPARATOR常量，解析后为"/"为了兼容不同系统之间路径写法的区别
            $dir = dirname("./public/static/chatImg") . DIRECTORY_SEPARATOR . $uploadDir; //路径名
            file_exists($dir) || (mkdir($dir, 0777, true) && chmod($dir, 0777));
            if (!is_array($_FILES["myFile"]["name"])) //single file
            {
                $fileName = time() . uniqid() . '.' . pathinfo($_FILES["myFile"]["name"])['extension'];
                move_uploaded_file($_FILES["myFile"]["tmp_name"], $dir . $fileName); //移动到指定$dir 目录下，该目录不存在会自动创建，重命名上传的文件$ret['file'] = DIRECTORY_SEPARATOR.$uploadDir.$fileName;
                $path = $dir . $fileName;
                return json_encode($path);
            }
            return 'false';
        }
        return "未获取图片信息";
    }


    /*
     * 物流配置 获取物流订单列表
     */
    public function Logistics(){
        $params = input();
        // 条件
        $where = OrderLogistics::LogisticsWhere($params);
        // 总数
        $total = OrderLogistics::LogisticsTotal($where);

        // 分页
        $number = MyC('logistics_page_number', 20, true);
        $page_params = array(
            'number'	=>	$number,
            'total'		=>	$total,
            'where'		=>	$params,
            'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
            'url'		=>	MyUrl('admin/Zoology/Logistics'),
        );
        $page = new \base\Page($page_params);

        // 获取管理员列表
        $data_params = [
            'where'		=> $where,
            'm'			=> $page->GetPageStarNumber(),
            'n'			=> $number,
        ];
        $data = OrderLogistics::GetLogisticsList($data_params);
        $this->assign('params', $params);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data', $data);

        return $this->fetch();
    }

    /**
     * 修改物流页面
     */
    public function DelLogistics(){
        // 开始操作
        $params = input('post.');
        $params['admin'] = $this->admin;
        return OrderLogistics::DelLogistics($params);
    }

    /**
     * 支付管理
     */
    public function PayManage()
    {
        // 是否启用
        $this->assign('common_is_enable_list', lang('common_is_enable_list'));

        // 编辑器文件存放地址
        $this->assign('editor_path_type', 'express');
        return $this->fetch();
    }

    /**
     * [GetNodeSon 获取支付节点子列表]
     */
    public function GetNodeSon()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        // 开始操作
        return PayService::PayNodeSon(input());
    }

    /**
     * 删除支付方式
     */
    public function Delete()
    {
        // 是否ajax
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始操作
        $params = input('post.');
        $params['admin'] = $this->admin;
        return PayService::PayDelete($params);
    }

    /**
     * 增加支付方式
     */
    public function SavePay(){
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }
        $params = input();
        $params['admin'] = $this->admin;
        // 开始操作
        return PaymentService::SavePay($params);
    }
}