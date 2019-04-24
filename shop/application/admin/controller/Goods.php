<?php

namespace app\admin\controller;

use app\service\GoodsCommentService;
use app\service\ResourcesService;
use app\service\GoodsService;
use app\service\RegionService;
use app\service\BrandService;
use think\Db;
use think\Request;
use think\Model;

/**
 * 商品管理
 */
class Goods extends Common
{
	/**
	 * 构造方法
	 */
	public function __construct()
	{
		// 调用父类前置方法
		parent::__construct();

		// 登录校验
		//$this->IsLogin();

		// 权限校验
		//$this->IsPower();
	}

    /**
     * 商品评论删除
     * @param Request $request
     */
    public function CommentDel(Request $request)
    {
       if ($request->isPost()){
            $cid = $request->post('id');
            return GoodsCommentService::DelComment($cid,$this->admin);
       }else{
           return $this->error('非法访问');
       }
    }
    /**
     * 商品评论
     */
    public function Comment()
    {

        // 参数
        $params = input();
        // 总数
        $total = GoodsCommentService::GoodsCommentTotal($params['oid']);
        // 分页
        $number = MyC('admin_page_number', 10, true);
        $page_params = array(
            'number'	=>	$number,
            'total'		=>	$total,
            'where'		=>	$params,
            'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
            'url'		=>	MyUrl('admin/goods/comment'),
        );
        $page = new \base\Page($page_params);
        // 获取数据列表
        $data_params = [
            'm'				=> $page->GetPageStarNumber(),
            'n' 			=> $number,
            'is_category'	=> 1,
            'goods_id'      =>$params['oid']
        ];
        $goods = GoodsService::GoodsOneInfo($params['oid']);
        $this->assign('goods',$goods);
        $data = GoodsCommentService::GetComment($data_params);
        $this->assign('params', $params);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data', $data['data']);
        return $this->fetch();
    }
	/**
     * [Index 商品列表]
     */
	public function Index()
	{
		// 参数
		$params = input();

		// 条件
		$where = GoodsService::GetAdminIndexWhere($params);

		// 总数
		$total = GoodsService::GoodsTotal($where);
		// 分页
		$number = MyC('admin_page_number', 10, true);
		$page_params = array(
				'number'	=>	$number,
				'total'		=>	$total,
				'where'		=>	$params,
				'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
				'url'		=>	MyUrl('admin/goods/index'),
			);
		$page = new \base\Page($page_params);

		// 获取数据列表
		$data_params = [
			'where'			=> $where,
			'm'				=> $page->GetPageStarNumber(),
			'n' 			=> $number,
			'is_category'	=> 1,
		];
		$data = GoodsService::GoodsList($data_params);
		foreach($data as $key => $val){
			if($list = Db::name("goods_details")->where(["goods_id"=>$val['id']])->select()){
				$data[$key]['details'] = $list;
			}
		}
		// 是否上下架
		/*echo "<pre>";
		var_dump($data);*/
		$this->assign('common_is_shelves_list', lang('common_is_shelves_list'));

		// 是否首页推荐
		$this->assign('common_is_text_list', lang('common_is_text_list'));

		$this->assign('params', $params);
		$this->assign('page_html', $page->GetPageHtml());
		$this->assign('data', $data);
		return $this->fetch();
	}

	/**
	 * [SaveInfo 商品添加/编辑页面]
	 */
	public function SaveInfo()
	{
		// 参数
		$params = input();
		// 登录校验
		$this->IsLogin();
		// 权限校验
		$this->IsPower();
		// 商品信息
		if(!empty($params['id']))
		{
			$data_params = [
				'where'				=> ['id'=>$params['id']],
				'm'					=> 0,
				'n'					=> 1,
				'is_photo'			=> 1,
				'is_content_app'	=> 1,
				'is_category'		=> 1,
			];


			$data = GoodsService::GoodsList($data_params);
			/*echo "<pre>";
			var_dump($data);*/
			if(empty($data[0]))
			{
				return $this->error('商品信息不存在', MyUrl('admin/goods/index'));
			}
			//$list = Db::name("goods_category_join")->alias("a")->field("name")->join("goods_category b","a.category_id = b.id","left")->where(["a.goods_id"=>$params['id']])->select();
			$mark = Db::name("goods_details")->where(["goods_id"=>$params['id']])->select();

			$this->assign('data', $data[0]);
			//$this->assign("list",$list);
			$this->assign("mark",$mark);

			// 获取商品编辑规格
			$specifications = GoodsService::GoodsEditSpecifications($data[0]['id']);
			$this->assign('specifications', $specifications);
		}

		// 地区信息
		$this->assign('region_province_list', RegionService::RegionItems(['pid'=>0]));


		// 商品分类
		$this->assign('category_list', GoodsService::GoodsCategory());

		// 品牌分类
		$this->assign('brand_list', BrandService::CategoryBrand());

		// 参数
		$this->assign('params', $params);

		// 编辑器文件存放地址
		$this->assign('editor_path_type', 'goods');
		return $this->fetch();
	}

	/**
	 * [Save 商品添加/编辑]
	 */
	public function Save()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始操作
		$params = input('post.');
		//var_dump($params);
		$params['admin'] = $this->admin;
		return GoodsService::GoodsSave($params);
	}

	/**
	 * [Delete 商品删除]
	 */
	public function Delete()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始操作
		$params = input('post.');
		$params['admin'] = $this->admin;
		return GoodsService::GoodsDelete($params);
	}

	/**
	 * [StatusShelves 上下架状态更新]
	 */
	public function StatusShelves()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始操作
		$params = input('post.');
		$params['admin'] = $this->admin;
		$params['field'] = 'is_shelves';
		return GoodsService::GoodsStatusUpdate($params);
	}

	/**
	 * [StatusHomeRecommended 是否首页推荐状态更新]
	 */
	public function StatusHomeRecommended()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始操作
		$params = input('post.');
		$params['admin'] = $this->admin;
		$params['field'] = 'is_home_recommended';
		return GoodsService::GoodsStatusUpdate($params);
	}

	/**
     * 批量删除
     */
	public function Alldel(){
        // 是否ajax
		if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }
        // 开始操作
        $params = input('post.');
        if(empty($params['str'])){
			return DataReturn("删除数据为空");
      	}
		Db::startTrans();
        $id = $params['str'];
        if(!Db::name("goods")->where("id in ($id)")->delete()){
			Db::rollback();
            return DataReturn("删除失败");
        }
		if(!Db::name("goods_details")->where("goods_id in ($id)")->delete()){
			Db::rollback();
			return DataReturn("删除失败");
		}
		Db::commit();
		$logs = [
			'admin_id'=>$this->admin['id'],
			'title'=>'删除',
			'detail'=>$this->admin['username'].'批量删除了商品'.$id,
			'add_time'=>time()
		];
		System::AdminLogSave($logs);
        return DataReturn("删除成功");
    }

    /**
     * 库存管理
     */
    public function Repertory(){
        // 参数
        $params = input();

        // 条件
        $where = GoodsService::GetAdminIndexWhere($params);

        // 总数
        $total = GoodsService::GoodsTotal($where);

        // 分页
        $number = MyC('admin_page_number', 10, true);
        $page_params = array(
            'number'	=>	$number,
            'total'		=>	$total,
            'where'		=>	$params,
            'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
            'url'		=>	MyUrl('admin/goods/index'),
        );
        $page = new \base\Page($page_params);

        // 获取数据列表
        $data_params = [
            'where'			=> $where,
            'm'				=> $page->GetPageStarNumber(),
            'n'				=> $number,
            'is_category'	=> 1,
        ];
        $data = GoodsService::GoodsList($data_params);

        // 是否上下架
        $this->assign('common_is_shelves_list', lang('common_is_shelves_list'));

        // 是否首页推荐
        $this->assign('common_is_text_list', lang('common_is_text_list'));

        $this->assign('params', $params);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * 修改库存
     */
    public function SaveRepertory(){
        // 参数
        $params = input();

        // 商品信息
        if(!empty($params['id']))
        {
            $data_params = [
                'where'				=> ['id'=>$params['id']],
                'm'					=> 0,
                'n'					=> 1,
                'is_photo'			=> 1,
                'is_content_app'	=> 1,
                'is_category'		=> 1,
            ];
            $data = GoodsService::GoodsList($data_params);
            if(empty($data[0]))
            {
                return $this->error('商品信息不存在', MyUrl('admin/goods/index'));
            }
            $this->assign('data', $data[0]);

            // 获取商品编辑规格
            $specifications = GoodsService::GoodsEditSpecifications($data[0]['id']);
            $this->assign('specifications', $specifications);
        }

        // 地区信息
        $this->assign('region_province_list', RegionService::RegionItems(['pid'=>0]));

        // 商品分类
        $this->assign('category_list', GoodsService::GoodsCategory());

        // 品牌分类
        $this->assign('brand_list', BrandService::CategoryBrand());

        // 参数
        $this->assign('params', $params);

        // 编辑器文件存放地址
        $this->assign('editor_path_type', 'goods');

        return $this->fetch();
    }
}
?>