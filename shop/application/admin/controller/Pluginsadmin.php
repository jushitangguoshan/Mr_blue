<?php

namespace app\admin\controller;

use app\service\PluginsAdminService;

/**
 * 应用管理
 */
class Pluginsadmin extends Common
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

        // 小导航
        $this->view_type = input('view_type', 'home');
    }

    /**
     * [Index 配置列表]
     */
    public function Index()
    {
        // 导航参数
        $this->assign('view_type', $this->view_type);

        // 参数
        $params = input();

        // 页面类型
        if($this->view_type == 'home')
        {
            // 分页
            $number = 12;

            // 条件
            $where = PluginsAdminService::PluginsListWhere($params);

            // 获取总数
            $total = PluginsAdminService::PluginsTotal($where);

            // 分页
            $page_params = array(
                    'number'    =>  $number,
                    'total'     =>  $total,
                    'where'     =>  $params,
                    'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
                    'url'       =>  MyUrl('admin/plugins/index'),
                );
            $page = new \base\Page($page_params);
            $this->assign('page_html', $page->GetPageHtml());

            // 获取列表
            $data_params = array(
                'm'         => $page->GetPageStarNumber(),
                'n'         => $number,
                'where'     => $where,
            );
            $data = PluginsAdminService::PluginsList($data_params);
            $this->assign('data_list', $data['data']);

            return $this->fetch();
        } else {
            return $this->fetch('upload');
        }
    }

    /**
     * 添加/编辑页面
     */
    public function SaveInfo()
    {
        // 参数
        $params = input();

        // 参数
        $this->assign('params', $params);

        // 获取数据
        if(!empty($params['id']))
        {
            // 获取数据
            $data_params = array(
                'm'         => 0,
                'n'         => 1,
                'where'     => ['id' => intval($params['id'])],
            );
            $data = PluginsAdminService::PluginsList($data_params);
            $this->assign('data', $data['data'][0]);
            $params['plugins'] = $data['data'][0]['plugins'];
        }

        // 标记为空或等于view 并且 编辑数据为空则走第一步
        if((empty($params['plugins']) || $params['plugins'] == 'view') && empty($data['data'][0]))
        {
            return $this->fetch('first_step');
        } else {
            // 编辑器文件存放地址
            $this->assign('editor_path_type', 'plugins_'.$params['plugins']);

            // 唯一标记
            $this->assign('plugins', $params['plugins']);
            return $this->fetch('save_info');
        }
    }

    /**
     * 添加/编辑
     */
    public function Save()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        return PluginsAdminService::PluginsSave(input('post.'));
    }

    /**
     * 删除
     */
    public function Delete()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        return PluginsAdminService::PluginsDelete(input('post.'));
    }

    /**
     * [StatusUpdate 状态更新]
     */
    public function StatusUpdate()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        return PluginsAdminService::PluginsStatusUpdate(input('post.'));
    }

    /**
     * 上传安装
     */
    public function Upload()
    {
        // 是否ajax
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        return PluginsAdminService::PluginsUpload(input());
    }
}
?>