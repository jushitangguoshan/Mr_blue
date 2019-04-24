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
namespace app\api\controller;

use app\service\UserService;
use think\Db;

/**
 * 用户地址
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2017-03-02T22:48:35+0800
 */
class UserAddress extends Common
{
    /**
     * [__construct 构造方法]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-03T12:39:08+0800
     */
    public function __construct()
    {
        // 调用父类前置方法
        parent::__construct();

        // 是否登录
        //$this->Is_Login();
    }

    /**
     * 获取用户地址编辑页面
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-18
     * @desc    description
     */
    public function Detail()
    {
        //$params = $this->data_post;
        $params = input();
        $params['user'] = $this->user;
        /*$params = ['id'=>1];
        $params['user'] = ["id"=>'90'];*/
        return UserService::UserAddressRow($params);
    }

    /**
     * 获取用户地址列表
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-18
     * @desc    description
     */
    public function Index()
    {
        $params = input();
        $params['user'] = $this->user;
        return UserService::UserAddressLists($params);
    }

    /**
     * 用户地址保存
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-18
     * @desc    description
     */
    public function Save()
    {
        //$params = $this->data_post;
        $params = input();
        //$params['user'] = $this->user;

        /*$params = [
        "country"=>1,
        "name"=>"玉皇大帝",
        "phone"=>'1383838438',
        "province"=>'19',
        "city"=>'291',
        "postal_code"=>'433000',
        "county"=>"3059",
        "address"=>"某座高楼大厦",
        "identity_number"=>"421023199810242410",
    ];*/
        /*$params = [
            "id"=>6,
            "country"=>2,
            "name"=>"宝玉儿",
            "phone"=>'1383838438',
            "gw_city"=>'阿拉斯加',
            "gw_county"=>"北极熊",
            "address"=>"某座高楼大厦",
            "postal_code"=>"kz-985"
        ];*/
        $params['user'] = $this->user;
        if($params['country']  == 1){

            return UserService::UserAddressSave($params);
        }
        return UserService::UserAbroadAddressSave($params);

        //return UserService::UserAddressSave($params);
    }

    /**
     * 删除地址
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-18
     * @desc    description
     */
    public function Delete()
    {
        //$params = $this->data_post;
        $params = input();
        $params['user'] = $this->user;
        /*$params = ["id"=>"1"];
        $params['user'] = ["id" => "90"];*/
        return UserService::UserAddressDelete($params);
    }

    /**
     * 默认地址设置
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-18
     * @desc    description
     */
    public function SetDefault()
    {
        //$params = $this->data_post;
        $params = input();
        $params['user'] = $this->user;
        return UserService::UserAddressDefault($params);
    }


    /**
     * 用户保存、编辑地址页面
     */
    public function saveUpdPage()
    {

        $params = input();
        $params['user'] = $this->user;
        if(!empty($params['address_id']) ){
            $where = ['ua.id'=>$params['address_id'],"ua.user_id"=>$params['user']['id']];
            $data = Db::name("user_address")->alias("ua")->join("country c","ua.country = c.id")->where($where)->select();
        }
        $data[0]['country_detail'] = Db::name("country")->select();
        foreach($data[0]['country_detail'] as $key => $val){
            if($val['id'] == 1){
                $provinceAndCity = Db::name("china")->select();
                $data[0]['country_detail'][$key]['provinceAndCity'] = chinaTree($provinceAndCity);
            }
        }
        return DataReturn("请求页面成功",200,$data);
    }

    /**
     * 获取省市区
     */
    public function provinceCityCounty()
    {
        $data = Db::name("china")->select();
        $data = chinaTree($data);
        return DataReturn("success",200,$data);
    }
}
?>