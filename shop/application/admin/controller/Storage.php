<?php

namespace app\admin\controller;
use think\Db;
use app\service\StorageService;

/**
 * 仓库管理
 */
class Storage extends Common
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
     * [Index 列表]
     */
	public function Storage_list()
	{
        // 参数
        $params = input();

        // 分页
        $number = MyC('admin_page_number', 10, true);

        // 条件
        $where = StorageService::StorageListWhere($params);

        // 获取总数
        $total = StorageService::StorageTotal($where);

        // 分页
        $page_params = array(
                'number'    =>  $number,
                'total'     =>  $total,
                'where'     =>  $params,
                'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
                'url'       =>  MyUrl('admin/storage/index'),
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
        $data = StorageService::StorageList($data_params);
       
        $this->assign('data_list', $data['data']);

        //var_dump($data);
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
            $data = StorageService::StorageList($data_params);

            $this->assign('data', empty($data['data'][0]) ? [] : $data['data'][0]);
        }

        $parent_id['area_parent_id'] = 0;
        $region = Db::name('Area')->where($parent_id)->select();
        $this->assign('region',$region);

        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }

    //选择地区
    public function Region()
    {
        if (isset($_POST['pro_id'])) {
            $area['area_parent_id'] = $_POST['pro_id'];
        } else {
            $area['area_parent_id'] = 0;
        }
        $area = Db::name('Area')->where($area)->select();
        $opt = '<option>--请选择市区--</option>';
        foreach($area as $key=>$val){
                $opt .= "<option value='{$val['area_id']}'>{$val['area_name']}</option>";
         }
         echo json_encode($opt);
    }

	/**
	 * [Save 仓库保存]
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

        return StorageService::StorageSave($params);
	}

	/**
	 * [Delete 仓库删除]
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
        return StorageService::StorageDelete($params);
	}
    

}
?>