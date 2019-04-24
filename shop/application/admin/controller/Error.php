<?php

namespace app\admin\controller;

use think\Request;

/**
 * 空控制器响应
 * @desc    description
 */
class Error extends Common
{
    /**
     * 空控制器响应
     * @param   Request         $request [参数]
     */
    public function Index(Request $request)
    {
        if(IS_AJAX)
        {
            exit(json_encode(DataReturn($request->controller().' 控制器不存在', -1000)));
        } else {
            exit($request->controller().' 控制器不存在');
        }
    }
}
?>