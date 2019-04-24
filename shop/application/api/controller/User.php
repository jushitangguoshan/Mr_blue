<?php
namespace app\api\controller;

use app\service\Area;
use app\service\UserService;
use app\service\OrderService;
use app\service\GoodsService;
use app\service\MessageService;
use think\Db;

/**
 * 用户
 */
class User extends Common
{
    /**
     * [__construct 构造方法]
     */
    public function __construct()
    {
        // 调用父类前置方法
        parent::__construct();
    }

    /**
     * [Reg 用户注册-数据添加]
     */
    public function Reg()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }
        // 调用服务层
        return UserService::AppReg(input('post.'));
    }

    /**
     * [RegVerifySend 用户注册-验证码发送]
     */
    public function RegVerifySend()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }
        // 调用服务层
        return UserService::AppUserBindVerifySend(input('post.'));
    }

    /**
     * [GetAlipayUserInfo 获取支付宝用户信息]
     */
    public function AlipayUserAuth()
    {
        // 参数
        if(empty($this->data_post['authcode']))
        {
            return DataReturn('授权码不能为空', -1);
        }

        // 授权
        $result = (new \base\AlipayAuth())->GetAlipayUserInfo($this->data_post['authcode'], MyC('common_app_mini_alipay_appid'));
        if($result === false)
        {
            return DataReturn('获取授权信息失败', -10);
        } else {
            $result['gender'] = empty($result['gender']) ? 0 : ($result['gender'] == 'm') ? 2 : 1;
            $result['openid'] = $result['user_id'];
            $result['referrer']= isset($this->data_post['referrer']) ? intval($this->data_post['referrer']) : 0;
            return UserService::AuthUserProgram($result, 'alipay_openid');
        }
    }

    /**
     * 微信小程序获取用户授权
     */
    public function WechatUserAuth()
    {
        $result = (new \base\Wechat(MyC('common_app_mini_weixin_appid'), MyC('common_app_mini_weixin_appsecret')))->GetAuthSessionKey(input('authcode'));
        if($result !== false)
        {
            return DataReturn('授权登录成功', 0, $result);
        }
        return DataReturn('授权登录失败', -100);
    }

    /**
     * 微信小程序获取用户信息
     */
    public function WechatUserInfo()
    {
        // 参数
        $params = input();

        // 先从数据库获取用户信息
        $user = UserService::UserInfo('weixin_openid', $params['openid']);
        if(empty($user))
        {
            $result = (new \base\Wechat(MyC('common_app_mini_weixin_appid'), MyC('common_app_mini_weixin_appsecret')))->DecryptData($params['encrypted_data'], $params['iv'], $params['openid']);

            if(is_array($result))
            {
                $result['nick_name'] = isset($result['nickName']) ? $result['nickName'] : '';
                $result['avatar'] = isset($result['avatarUrl']) ? $result['avatarUrl'] : '';
                $result['gender'] = empty($result['gender']) ? 0 : ($result['gender'] == 2) ? 1 : 2;
                $result['openid'] = $result['openId'];
                $result['referrer']= isset($this->data_post['referrer']) ? intval($this->data_post['referrer']) : 0;
                return UserService::AuthUserProgram($result, 'weixin_openid');
            }
        } else {
            return DataReturn('授权成功', 0, $user);
        }
        return DataReturn(empty($result) ? '获取用户信息失败' : $result, -100);
    }

    /**
     * 百度小程序获取用户信息
     */
    public function BaiduUserAuth()
    {
        return DataReturn('暂未开放', -1);

        $_POST['config'] = MyC('baidu_mini_program_config');
        $result = (new \Library\BaiduAuth())->GetAuthUserInfo($_POST);
        if($result['status'] == 0)
        {
            return UserService::AuthUserProgram($result, 'alipay_openid');
        }
        return DataReturn($result['msg'], -10);
    }

    /**
     * [ClientCenter 用户中心]
     */
    public function Center()
    {
        // 登录校验
        $this->Is_Login();

        // 订单总数
        $where = ['user_id'=>$this->user['id'], 'is_delete_time'=>0, 'user_is_delete_time'=>0];
        $user_order_count = OrderService::OrderTotal($where);

        // 商品收藏总数
        $where = ['user_id'=>$this->user['id']];
        $user_goods_favor_count = GoodsService::GoodsFavorTotal($where);

        // 商品浏览总数
        $where = ['user_id'=>$this->user['id']];
        $user_goods_browse_count = GoodsService::GoodsBrowseTotal($where);

        // 未读消息总数
        $params = ['user'=>$this->user, 'is_more'=>1, 'is_read'=>0];
        $common_message_total = MessageService::UserMessageTotal($params);
        $common_message_total = ($common_message_total > 99) ? '99+' : $common_message_total;

        // 用户订单状态
        $user_order_status = OrderService::OrderStatusStepTotal(['user_type'=>'user', 'user'=>$this->user, 'is_comments'=>1]);

        // 初始化数据
        $result = array(
            'integral'                          => (int) $this->user['integral'],
            'avatar'                            => $this->user['avatar'],
            'nickname'                          => $this->user['nickname'],
            'username'                          => $this->user['username'],
            'customer_service_tel'              => MyC('common_app_customer_service_tel', null, true),
            'common_user_center_notice'         => MyC('common_user_center_notice', null, true),
            'user_order_status'                 => $user_order_status['data'],
            'user_order_count'                  => $user_order_count,
            'user_goods_favor_count'            => $user_goods_favor_count,
            'user_goods_browse_count'           => $user_goods_browse_count,
            'common_message_total'              => $common_message_total,
            'common_app_is_enable_answer'       => (int) MyC('common_app_is_enable_answer', 0),
        );

        // 返回数据
        return DataReturn('success', 0, $result);
    }


    /**
     * 获取用户有效服务单列表
     */
    public function GetOpenOrderList(){
        $user_id = input('user_id');
        $data = Db::name('OrderService')->field('os.id,os.user_id,os.service_num,os.serial_num,service_class,concrete_issue,os.model,os.is_open,os.status,os.add_time,g.title,g.images,g.model')
            ->alias('os')
            ->join("Goods g",'os.model=g.model')->where('os.user_id',$user_id)
            ->where('os.is_open',1)->select();
        return DataReturn('ok',200,$data);
    }

    /**
     * 获取用户关闭服务单列表
     */
    public function GetCloseOrderList(){
        $user_id = input('user_id');
        $data = Db::name('OrderService')->field('os.id,os.user_id,os.service_num,os.serial_num,service_class,concrete_issue,os.model,os.is_open,os.status,os.add_time,g.title,g.images,g.model')
            ->alias('os')
            ->join("Goods g",'os.model=g.model')->where('os.user_id',$user_id)
            ->where('os.is_open',0)->select();
        return DataReturn('ok',200,$data);
    }

    /**
     * 服务订单详情
     */
    public function GetServiceDetail(){
        $user_id = input('user_id');
        $order_id = input('id');
        $data = Db::name('OrderService')->field('os.id,os.user_id,os.service_num,os.serial_num,service_class,concrete_issue,os.model,os.service_way,os.is_open,os.status,os.add_time,g.title,g.images,g.model')
            ->alias('os')
            ->join("Goods g",'os.model=g.model')->where('os.user_id',$user_id)
            ->where('os.id',$order_id)->select();
        return DataReturn('ok',200,$data);
    }

    /**
     * 申请售后服务
     */
    public function PostAddServiceOrder(){
        $input = input();
        $params['user_id'] = $input['user_id'];  //用户ID
        $params['service_num'] = time(). mt_rand(999,9999); //服务单号
        $params['goods_category_id'] = $input['goods_category_id']; //分类ID
        $params['model'] = $input['model']; //产品型号
        $params['serial_num'] = $input['serial_num']; //产品序列号
        $params['service_class'] = isset($input['service_class'])?$input['service_class']:1;//服务类型 1维修  2换货
        $params['reason'] = isset($input['reason'])?$input['reason']:'';//理由
        $params['concrete_issue'] = isset($input['concrete_issue'])?$input['concrete_issue']:''; //具体问题
        $params['service_way'] = isset($input['service_way'])?$input['service_way']:1;//服务方式 1到店 2到家 3寄修
        $params['is_invoice'] = isset($input['is_invoice'])?$input['is_invoice']:0; //1要发票  0不要发票
        $params['invoice_date'] = isset($input['invoice_date'])?$input['invoice_date']:0;//发票日期
        $params['status'] = 1;//1申请中 2通过申请 3拒绝申请
        $params['apply_time'] = time();//拒绝时间
        $params['refuse'] = ''; //拒绝原因
        $params['is_open'] = 1;//1打开  0关闭
        $params['store_id'] = isset($input['store_id'])?$input['store_id']:0;//仓库ID
        $params['reservation_date'] = isset($input['reservation_date'])?$input['reservation_date']:0;//预约日期
        $params['time_id'] = isset($input['time_id'])?$input['time_id']:0;//预约时间段ID
        $params['reservation_name'] = isset($input['reservation_name'])?$input['reservation_name']:'';//预约人姓名
        $params['reservation_phone'] = isset($input['reservation_phone'])?$input['reservation_phone']:0;//预约人手机
        $params['visit_time_start'] = isset($input['visit_date'])?$input['visit_date']:0;//预约上门日期
        $params['visit_time_end'] = isset($input['visit_time'])?$input['visit_time']:0;//预约上门时间段
        $params['get_type'] = isset($input['get_type'])?$input['get_type']:0;//取件方式 1快递上门 2寄给门店
        $params['add_time'] = time();
        $params['upd_time'] = time();
        $params['myFiles'] = isset($input['myFiles']) ? $input($input['myFiles']) : [] ;
        $params['invoice_image'] = isset($input['invoice_image']) ? $input['invoice_image'] : '' ;

        $site['alike'] = isset($input['alike']) ? $input['alike'] : 0;

        // 开启事务
        Db::startTrans();
        //寄修
        if($params['service_way'] == 3){
            //上门地址
            $site['site']['name'] = isset($input['name']) ? $input['name'] : ''; //地址姓名
            $site['site']['phone'] = isset($input['phone']) ? $input['phone'] : ''; //地址联系手机
            $site['site']['state'] = isset($input['state']) ? $input['state'] : 0; //国家ID
            $site['site']['province'] = isset($input['province']) ? $input['province'] : ''; //省ID
            $site['site']['city'] = isset($input['city']) ? $input['city'] : ''; //市ID
            $site['site']['district'] = isset($input['district']) ? $input['district'] : ''; //区ID
            $site['site']['region'] = isset($input['region']) ? $input['region'] : ''; //国外市区
            $site['site']['address'] = isset($input['address']) ? $input['address'] : ''; //详细地址
            $site['site']['add_time'] = time(); //创建时间
            $params['return'] = isset($input['return']) ? $input['return'] : 0;

            $params['visit_site_id'] = Db::name('OrderServiceSite')->insertGetId($site['site']);
            if(!$params['visit_site_id'])
            {
                // 事务回滚
                Db::rollback();
                return DataReturn('地址出错', -10);
            }

            if($params['alike'] == 0){
                //收货地址
                $site['site2']['name'] = isset($input['name_p']) ? $input['name_p'] : ''; //地址姓名
                $site['site2']['phone'] = isset($input['phone_p']) ? $input['phone_p'] : ''; //地址联系手机
                $site['site2']['state'] = isset($input['state_p']) ? $input['state_p'] : 0; //国家ID
                $site['site2']['province'] = isset($input['province_p']) ? $input['province_p'] : ''; //省ID
                $site['site2']['city'] = isset($input['city_p']) ? $input['city_p'] : ''; //市ID
                $site['site2']['district'] = isset($input['district_p']) ? $input['district_p'] : ''; //区ID
                $site['site2']['region'] = isset($input['region_p']) ? $input['region_p'] : ''; //国外市区
                $site['site2']['address'] = isset($input['address_p']) ? $input['address_p'] : ''; //详细地址
                $site['site2']['add_time'] = time(); //创建时间

                $params['take_site_id'] = Db::name('OrderServiceSite')->insertGetId($site['site2']);
                if(!$params['take_site_id'])
                {
                    // 事务回滚
                    Db::rollback();
                    return DataReturn('收货地址出错', -10);
                }
            }
            if($params['return'] == 0){
                $params['return_phone'] = isset($input['return_phone'])?$input['return_phone']:0;//回访电话
                $params['return_name'] = isset($input['return_name'])?$input['return_name']:'';//回访姓名
            }else{
                $params['return_phone'] = $site['site']['name'];//回访电话
                $params['return_name'] = $site['site']['phone'];//回访姓名
            }

        }

        //写入数据
        $service_id = Db::name('OrderService')->insertGetId($params);
        if(!$service_id)
        {
            // 事务回滚
            Db::rollback();
            return DataReturn('生成服务订单失败', -10);
        }

        //图片
        $images = $params['myFiles'];
        if(!empty($images) && is_array($images)){
            $arr = [];
            foreach ($images as $v){
                $arr[][] = ['service_id'=>$service_id,'image'=>$v,'image_class'=>1];
            }

            if(Db::name('OrderService')->insertAll($arr))
            {
                // 事务回滚
                Db::rollback();
                return DataReturn('产品图片数据插入失败', -10);
            }
        }
        if($params['invoice_image'] != ''){
            $data = ['service_id'=>$service_id,'image'=>$params['voucher'],'image_class'=>2];
            if(Db::name('OrderService')->insert($data))
            {
                // 事务回滚
                Db::rollback();
                return DataReturn('发票图片数据插入失败', -10);
            }
        }
        if($service_id){
            // 提交事务
            Db::commit();
            return DataReturn('ok',200);
        }else{
            return DataReturn('系统异常！',-2);
        }
    }

    /**
     * 保存图片，返回路径
     */
    public function PostImages(){
        if(isset($_FILES["myFile"])) {
            $ret = array();  //用来保存图片上传之后的路径，文件名
            $uploadDir = 'images' . DIRECTORY_SEPARATOR . date("Y/m/d") . DIRECTORY_SEPARATOR;  // DIRECTORY_SEPARATOR常量，解析后为"/"为了兼容不同系统之间路径写法的区别
            $dir = dirname("./public/static/serviceImg") . DIRECTORY_SEPARATOR . $uploadDir; //路径名
            file_exists($dir) || (mkdir($dir, 0777, true) && chmod($dir, 0777));
            if (!is_array($_FILES["myFile"]["name"])) //single file
            {
                $fileName = time() . uniqid() . '.' . pathinfo($_FILES["myFile"]["name"])['extension'];
                move_uploaded_file($_FILES["myFile"]["tmp_name"], $dir . $fileName); //移动到指定$dir 目录下，该目录不存在会自动创建，重命名上传的文件$ret['file'] = DIRECTORY_SEPARATOR.$uploadDir.$fileName;
                $path = $dir . $fileName;
                return json(['code'=>200,'msg'=>'图片已接收','data'=>$path]);
            }
            return json(['code'=>500,'msg'=>'数据异常！']);
        }
        return json(['code'=>500,'msg'=>'未获取到图片信息！']);
    }


    /*
     * 门店列表
     */
    public function GetShopList(){
        $page = input('page') ? input('page') : 1 ;
        $limit = input('limit') ? input('limit') : 6;
        $start = ($page - 1)*$limit;
        $count = Db::name('Storage')->where('status',1)->count();
        $shop = Db::name('Storage')->field('id,name,pro_id,city_id,area_id,address,adtime')->limit($start,$limit)->where('status',1)->select();
        $data = [];
        foreach($shop as $k=>$v){
            $data[$k]['id'] = $v['id'];
            $data[$k]['name'] = $v['name'];
            $data[$k]['province'] = Area::GetAreaName($v['pro_id']);
            $data[$k]['city'] = Area::GetAreaName($v['city_id']);
            $data[$k]['district'] = Area::GetAreaName($v['area_id']);
            $data[$k]['address'] = $v['address'];
            $data[$k]['add_time'] = date("Y-m-d H:i:s",$v['adtime']);
        }
        return json(['msg'=>'ok','code'=>200,'data'=>$data,'page'=>$page,'count'=>$count]);
    }

    //门店营业时间
    public function GetShopTime(){
        $data = Db::name('ShopTime')->field('id,start_time,end_time')->where('status',1)->select();
        return DataReturn('ok',200,$data);
    }


    //用户余额
    public function GetUserBalance(){
        $user_id = 104;
        $data = Db::name('User')->where('id',$user_id)->field('id,money,grade')->find();
        return DataReturn("ok",200,$data);
    }

    /**
     * 消费记录
     */
    public function GetConsumeRecord(){
        $user_id = 77;
        $page = input('page') ? input("page") : 1;
        $limit = input('limit') ? input("limit") : 3;
        $start = ($page - 1) * $limit ;
        $end = $page * $limit;
        $str = input("str") ? input("str") : 1 ;
        if($str < 1 || $str > 2) return DataReturn('参数错误！',500);
        $symbol = "<";
        if ($str == 1) $symbol = "<";
        if ($str == 2) $symbol = ">";
        $time = strtotime("-1 month");
        $order = Db::name("Order")->where('user_id',$user_id)
            ->field('id,order_no,pay_number,pay_time')->where('add_time',$symbol,$time)->order('add_time','desc')->select();
        $data = [];
        $num = 0;
        foreach ($order as $k=>$v){
            $goods = Db::name('OrderGoods')->where('order_id',$v['id'])->field('id,goods_title,goods_prive')->select();
            foreach ($goods as $key=>$val){
                $data[$num]['id'] = $val['id'];
                $data[$num]['goods_title'] = $val['goods_title'];
                $data[$num]['goods_prive'] = $val['goods_prive'];
                $data[$num]['order_no'] = $v['order_no'];
                $data[$num]['pay_number'] = $v['pay_number'];
                $data[$num]['pay_time'] = $v['pay_time'];
                $num++;
            }
        }
        $datas = [];
        $count = count($data);
        if($end>$count) $end = $count;
        for ($i=$start;$i<$end;$i++){
            $datas[$i] = $data[$i];
        }
        return json(['msg'=>'ok','code'=>200,'data'=>$datas,'count'=>$count]);
    }


    /**
     * 删除消费记录
     */
    public function DelConsumeRecord(){
        $id = input('id');
        $data = Db::name('OrderGoods')->where('id',$id)->delete();
        if($data){
            return DataReturn('ok',200,$data);
        }
        return DataReturn('删除失败！',500);
    }

    /**
     * 删除所有消费记录
     */
    public function DelAllConsume(){
        $user_id = input('user_id');
        $data = Db::name('Order')->where('user_id',$user_id)->field('id')->select();
        foreach ($data as $k=>$v){
            Db::name("OrderGoods")->where('order_id',$v['id'])->delete();
        }
        $num = Db::name("Order")->where('user_id',$user_id)->delete();
        if($num){
            return DataReturn('ok',200);
        }
        return DataReturn('删除失败!',500);
    }


    /**
     * 获取商品分类
     */
    public function GetClassList(){
        $pid = input("id") ? input("id") : 0;
        $data = Db::name('GoodsCategory')->field('id,name')->where('pid',$pid)->select();
        return DataReturn('ok',200,$data);
    }

}
?>