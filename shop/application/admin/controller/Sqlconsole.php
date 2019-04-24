<?php

namespace app\admin\controller;

use app\service\SqlconsoleService;

/**
 * sql控制台
 */
class Sqlconsole extends Common
{
    /**
     * 构造方法
     */
    public function __construct()
    {
        // 调用父类前置方法
        parent::__construct();

        // 登录校验
        $this->IsLogin();

        // 权限校验
        $this->IsPower();
    }

    /**
     * [Index 首页]
     */
    public function Index()
    {
        return $this->fetch();
    }

    /**
     * sql执行
     */
    public function Implement()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        return SqlconsoleService::Implement(input());
    }
}
?>