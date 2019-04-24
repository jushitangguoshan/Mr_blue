<?php

namespace app\admin\controller;

use app\service\BrandService;

/**
 * 品牌管理
 */
class Brand extends Common
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
     * [Index 品牌列表]
     */
	public function Index()
	{
        // 参数
        $params = input();

        // 分页
        $number = MyC('admin_page_number', 10, true);

        // 条件
        $where = BrandService::BrandListWhere($params);

        // 获取总数
        $total = BrandService::BrandTotal($where);

        // 分页
        $page_params = array(
                'number'    =>  $number,
                'total'     =>  $total,
                'where'     =>  $params,
                'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
                'url'       =>  MyUrl('admin/brand/index'),
            );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'     => $page->GetPageStarNumber(),
            'n'     => $number,
            'where' => $where,
            'field' => '*',
        );
        $data = BrandService::BrandList($data_params);
        $this->assign('data_list', $data['data']);

        // 是否启用
        $this->assign('common_is_enable_list', lang('common_is_enable_list'));

        // 品牌分类
        $brand_category = BrandService::BrandCategoryList(['field'=>'id,name']);
        $this->assign('brand_category', $brand_category['data']);

        // 参数
        $this->assign('params', $params);
        return $this->fetch();
	}

    /**
     * [SaveInfo 添加/编辑页面]
     */
    public function SaveInfo()
    {
        // 参数
        $params = input();

        // 数据
        if(!empty($params['id']))
        {
            // 获取列表
            $data_params = array(
                'm'     => 0,
                'n'     => 1,
                'where' => ['id'=>intval($params['id'])],
                'field' => '*',
            );
            $data = BrandService::BrandList($data_params);
            $this->assign('data', empty($data['data'][0]) ? [] : $data['data'][0]);
        }

        // 是否启用
        $this->assign('common_is_enable_list', lang('common_is_enable_list'));

        // 品牌分类
		$brand_category = BrandService::BrandCategoryList(['field'=>'id,name']);
		$this->assign('brand_category', $brand_category['data']);

        // 参数
        $this->assign('params', $params);

        // 编辑器文件存放地址
        $this->assign('editor_path_type', 'brand');

        return $this->fetch();
    }

	/**
	 * [Save 品牌保存]
	 */
	public function Save()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = input();
        $params['admin'] = $this->admin;
        return BrandService::BrandSave($params);
	}

	/**
	 * [Delete 品牌删除]
	 */
	public function Delete()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = input();
        $params['user_type'] = 'admin';
        $params['admin'] = $this->admin;
        return BrandService::BrandDelete($params);
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
        $params = input();
        $params['admin'] = $this->admin;
        return BrandService::BrandStatusUpdate($params);
    }
}
?>