<?php
// +----------------------------------------------------------------------
// | ShopXO 国内领先企业级B2C免费开源电商系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011~2019 http://shopxo.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Devil
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\service\AdminLog;
use app\service\AdminService;
use app\service\ConfigService;
use app\admin\controller\phpmailers\Phpmailer;
use think\Db;

class System extends Common
{
    public function __construct()
    {
        // 调用父类前置方法
        parent::__construct();

        // 登录校验
        $this->IsLogin();

        // 权限校验
        $this->IsPower();
    }
    public function Index()
    {
        // 配置信息
        $this->assign('data', ConfigService::ConfigList());
        $type = input('type', 'email');

        // 导航
        $this->assign('nav_type', $type);
        if($type == 'email')
        {
            return $this->fetch('index');
        } else {
            return $this->fetch('message');
        }
    }
    public function Backups()
    {
        return $this->fetch();
    }

    /**
     * 数据备份
     */
    public function Orders()#数据备份#
    {
        $pars = "public/static/mysql_backups/" . date('Y/m/d');
        function create_folders($dir) {
            return  is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777));
        }
        $times = date('H.i.s');
        if(create_folders($pars)){
            $cfg_dbname = "cms_solarshop";
            $cfg_dbpwd = "root";
            $cfg_dbuser = "root";
            $filename=$times.".sql";
            header("Content-disposition:filename=".$filename);
            header("Content-type:application/octetstream");
            header("Pragma:no-cache");
            header("Expires:0");
            $tmpFile =  $pars."\\".$filename;
            exec("mysqldump -h 192.168.0.104 -u$cfg_dbuser -p$cfg_dbpwd --default-character-set=utf8 $cfg_dbname > ".$tmpFile);
            return 1;
      }
    }

    /**
     * 数据恢复页面
     */
    public function Recover()
    {
        function my_dir($dir) {
            $files = array();
            if(@$handle = opendir($dir)) {
                while(($file = readdir($handle)) !== false) {
                    if($file != ".." && $file != ".") { //排除根目录；
                        if(is_dir($dir."/".$file)) { //如果是子文件夹，就进行递归
                            $files[$file] = my_dir($dir."/".$file);
                        } else { //不然就将文件的名字存入数组；
                            $files[] = $file;
                        }
                    }
                }
                closedir($handle);
                return $files;
            }
        }
        $path = json_encode(my_dir("public/static/mysql_backups"));
        $this->assign('path',$path);
        return $this->fetch();
    }
    public function Getord(){#数据恢复#
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }
        $cfg_dbname = "cms_solarshop";
        $cfg_dbpwd = "root";
        $cfg_dbuser = "root";
        $params = input('get.');
        exec("mysql -h 192.168.0.104 -u$cfg_dbuser -p$cfg_dbpwd $cfg_dbname < public/static/mysql_backups/".$params['file_name']);
        return 1;
    }

    /**
     * 发送邮件
     */
    public function GetEmail()
    {

        $mail = new Phpmailer();

        // 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->SMTPDebug = 1;
        // 使用smtp鉴权方式发送邮件
        $mail->isSMTP();
        // smtp需要鉴权 这个必须是true
        $mail->SMTPAuth = true;
        // 链接qq域名邮箱的服务器地址
        $mail->Host = 'smtp.qq.com';
        // 设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';
        // 设置ssl连接smtp服务器的远程服务器端口号
        $mail->Port = 465;
        // 设置发送的邮件的编码
        $mail->CharSet = 'UTF-8';
        // 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = 'TEST';
        // smtp登录的账号
        $mail->Username = '1021069236@qq.com';
        // smtp登录的密码 使用生成的授权码
        $mail->Password = 'bfsyyktmkuytbffe';
        // 设置发件人邮箱地址 同登录账号
        $mail->From = '1021069236@qq.com';
        // 邮件正文是否为html编码
        $mail->isHTML(true);
        // 设置收件人邮箱地址
        $mail->addAddress('zhangjixian.hello@qq.com');
        // 添加多个收件人 则多次调用方法即可
        $mail->addAddress('zhangjixian.hello@qq.com');
        // 添加该邮件的主题
        $mail->Subject = '测试';
        // 添加邮件正文
        $mail->Body = '<h1>Hello World</h1>';
        // 为该邮件添加附件
        $mail->addAttachment('public/static/mysql_backups/2019/03/21/18-41-07.sql');
        // 发送邮件 返回状态
        $status = $mail->send();
        var_dump($status);
    }

    /**
     * 数据初始化
     */
    public function Clean()
    {
        //var_dump(strtotime(date("2018-10-24")));
        $array = [
            "admin_log"=>"管理员操作日志管理",
            //["cms_comment_photo,cms_goods_comment"=>"评论管理"],
            "goods_coupon"=>"优惠卷管理",
            "notice,notice_log"=>"消息通知管理",
            "message"=>"积分变动"
            ];
        $sql = "show tables";
        $re = Db::query($sql);
        $s = 'tables_in_cms_solarshop';
        $data = [];
        foreach ($re as $index => $item) {
            $r=strpos($item[$s],'cms_');
            if($r!== false){

                $arr = str_replace("cms_","",$item[$s]);
                foreach($array as $key => $value){
                    $k = explode(",",$key);
                    if(in_array($arr,$k)){
                        $data[$key] = $value;
                    }
                }
            }
        }
        $this->assign("data",$data);
        return $this->fetch();
    }

    /**
     * 数据初始化处理
     */
    public function cleanHandle()
    {
        $params = input();
        if(empty($params) || empty($params['table_name']) || empty($params['add_time']) || empty($params['end_time'])){
            return DataReturn("初始化条件不满足");
        }
        $add_time = strtotime($params['add_time']);
        $end_time = strtotime($params['end_time']);
        if($add_time > $end_time){
            return DataReturn("初始化日期格式不对");
        }
        $where = [['add_time',">=",$add_time],['add_time',"<=",$end_time]];
        $table_name = explode(",",$params['table_name']);
        if(count($table_name) > 1){
            foreach($table_name as $v){
                if(!Db::name($v)->where($where)->delete()){
                     return DataReturn("初始化失败");
                }
            }
        }else{
            if(!Db::name($table_name[0])->where($where)->delete()){
                return DataReturn("初始化失败");
            }
        }
        return ["msg"=>"初始化成功","code"=>1];
    }

    /**
     * 管理员操作日志列表
     */
    public function LogList(){
        // 参数
        $params = input();
        // 登录校验
        $this->IsLogin();
        // 权限校验
        $this->IsPower();
        // 条件
        $where = AdminLog::AdminLogWhere($params);
        // 总数
        $total = AdminLog::AdminLogTotal($where);
        // 分页
        $number = MyC('admin_page_number', 20, true);
        $page_params = array(
            'number'	=>	$number,
            'total'		=>	$total,
            'where'		=>	$params,
            'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
            'url'		=>	MyUrl('admin/system/logList'),
        );
        $page = new \base\Page($page_params);

        // 获取管理员列表
        $data_params = [
            'where'		=> $where,
            'm'			=> $page->GetPageStarNumber(),
            'n'			=> $number,
        ];
        $data = AdminLog::AdminLogList($data_params);

        // 角色
        $role_params = [
            'where'		=> ['is_enable'=>1],
            'field'		=> 'id,name',
        ];
        $role = AdminLog::RoleList($role_params);

        // 性别
        $this->assign('common_gender_list', lang('common_gender_list'));

        $this->assign('role', $role);
        $this->assign('params', $params);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * 记录管理员操作日志
     */
    public static function AdminLogSave($params=[]){
        return AdminLog::AdminLogWrite($params);
    }
}