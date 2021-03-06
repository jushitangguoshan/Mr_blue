<?php

namespace app\service;

use think\Db;

/**
 * 支付日志服务层
 */
class PayLogService
{
    /**
     * 获取支付日志类型
     * @param   [array]          $params [输入参数]
     */
    public static function PayLogTypeList($params = [])
    {
        $data = Db::name('PayLog')->field('payment AS id, payment_name AS name')->group('payment')->select();
        return DataReturn('处理成功', 0, $data);
    }
    
    /**
     * 后台管理员列表
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function AdminPayLogList($params = [])
    {
        $where = empty($params['where']) ? [] : $params['where'];
        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;
        $field = 'p.*,u.username,u.nickname,u.mobile,u.gender';
        $order_by = empty($params['order_by']) ? 'p.id desc' : $params['order_by'];

        // 获取数据列表
        $data = Db::name('PayLog')->alias('p')->join(['__USER__'=>'u'], 'u.id=p.user_id')->where($where)->field($field)->limit($m, $n)->order($order_by)->select();
        if(!empty($data))
        {
            $common_business_type_list = lang('common_business_type_list');
            $common_gender_list = lang('common_gender_list');
            foreach($data as &$v)
            {
                // 业务类型
                $v['business_type_name'] = $common_business_type_list[$v['business_type']]['name'];

                // 性别
                $v['gender_text'] = $common_gender_list[$v['gender']]['name'];

                // 时间
                $v['add_time_time'] = date('Y-m-d H:i:s', $v['add_time']);
                $v['add_time_date'] = date('Y-m-d', $v['add_time']);
            }
        }
        return DataReturn('处理成功', 0, $data);
    }

    /**
     * 后台消息总数
     * @param   [array]          $where [条件]
     */
    public static function AdminPayLogTotal($where = [])
    {
        return (int) Db::name('PayLog')->alias('p')->join(['__USER__'=>'u'], 'u.id=p.user_id')->where($where)->count();
    }

    /**
     * 后台消息列表条件
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function AdminPayLogListWhere($params = [])
    {
        $where = [];
        
        // 关键字
        if(!empty($params['keywords']))
        {
            $where[] = ['p.trade_no|u.username|u.nickname|u.mobile', 'like', '%'.$params['keywords'].'%'];
        }

        // 是否更多条件
        if(isset($params['is_more']) && $params['is_more'] == 1)
        {
            // 等值
            if(isset($params['business_type']) && $params['business_type'] > -1)
            {
                $where[] = ['p.business_type', '=', intval($params['business_type'])];
            }
            if(!empty($params['pay_type']))
            {
                $where[] = ['p.payment', '=', $params['pay_type']];
            }
            if(isset($params['gender']) && $params['gender'] > -1)
            {
                $where[] = ['u.gender', '=', intval($params['gender'])];
            }

            if(!empty($params['time_start']))
            {
                $where[] = ['p.add_time', '>', strtotime($params['time_start'])];
            }
            if(!empty($params['time_end']))
            {
                $where[] = ['p.add_time', '<', strtotime($params['time_end'])];
            }
        }

        return $where;
    }

    /**
     * 删除
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function PayLogDelete($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'id',
                'error_msg'         => '操作id有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 删除操作
        if(Db::name('PayLog')->where(['id'=>$params['id']])->delete())
        {
            return DataReturn('删除成功');
        }

        return DataReturn('删除失败或资源不存在', -100);
    }
}
?>