<?php

namespace app\admin\controller;

/**
 * 应用调用入口
 */
class Plugins extends Common
{
    /**
     * 构造方法
     * @desc    description
     */
    public function __construct()
    {
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
        // 参数
        $params = input();

        // 请求参数校验
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'pluginsname',
                'error_msg'         => '应用名称有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'pluginscontrol',
                'error_msg'         => '应用控制器有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'pluginsaction',
                'error_msg'         => '应用操作方法有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            if(IS_AJAX)
            {
                return DataReturn($ret, -5000);
            } else {
                $this->assign('msg', $ret);
                return $this->fetch('public/error');
            }
        }

        // 应用名称/控制器/方法
        $pluginsname = $params['pluginsname'];
        $pluginscontrol = strtolower($params['pluginscontrol']);
        $pluginsaction = strtolower($params['pluginsaction']);

        // 视图初始化
        $this->PluginsViewInit($pluginsname, $pluginscontrol, $pluginsaction);

        // 编辑器文件存放地址定义
        $this->assign('editor_path_type', 'plugins_'.$pluginsname);

        // 应用控制器
        $plugins = '\app\plugins\\'.$pluginsname.'\\'.ucfirst($pluginscontrol);
        if(!class_exists($plugins))
        {
            $this->assign('msg', ucfirst($pluginscontrol).' 应用控制器未定义');
            return $this->fetch('public/error');
        }

        // 调用方法
        $obj = new $plugins();
        if(!method_exists($obj, $pluginsaction))
        {
            $this->assign('msg', ucfirst($pluginsaction).' 应用方法未定义');
            return $this->fetch('public/error');
        }
        return $obj->$pluginsaction($params);
    }

    /**
     * 视图初始化
     * @param    [string]                   $plugins_name       [应用名称]
     * @param    [string]                   $plugins_control    [控制器名称]
     * @param    [string]                   $plugins_action     [方法]
     */
    public function PluginsViewInit($plugins_name, $plugins_control, $plugins_action)
    {
        // 当前操作名称
        $module_name = 'plugins';

        // 控制器静态文件状态css,js
        $module_css = $module_name.DS.'css'.DS.$plugins_name.DS.$plugins_control;
        $module_css .= file_exists(ROOT_PATH.'static'.DS.$module_css.'.'.$plugins_action.'.css') ? '.'.$plugins_action.'.css' : '.css';
        $this->assign('module_css', file_exists(ROOT_PATH.'static'.DS.$module_css) ? $module_css : '');

        $module_js = $module_name.DS.'js'.DS.$plugins_name.DS.$plugins_control;
        $module_js .= file_exists(ROOT_PATH.'static'.DS.$module_js.'.'.$plugins_action.'.js') ? '.'.$plugins_action.'.js' : '.js';
        $this->assign('module_js', file_exists(ROOT_PATH.'static'.DS.$module_js) ? $module_js : '');
    }
}
?>