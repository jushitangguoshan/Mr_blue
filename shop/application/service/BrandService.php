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
namespace app\service;

use app\admin\controller\System;
use think\Db;
use app\service\GoodsService;
use app\service\ResourcesService;

/**
 * 品牌服务层
 */
class BrandService
{
    /**
     * 品牌列表
     * @param    [array]          $params [输入参数]
     */
    public static function BrandList($params = [])
    {
        $where = empty($params['where']) ? [] : $params['where'];
        $field = empty($params['field']) ? '*' : $params['field'];
        $order_by = empty($params['order_by']) ? 'sort asc' : trim($params['order_by']);

        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;

        // 获取品牌列表
        $data = Db::name('Brand')->where($where)->order($order_by)->limit($m, $n)->select();
        if(!empty($data))
        {
            $common_is_enable_tips = lang('common_is_enable_tips');
            foreach($data as &$v)
            {
                // 是否启用
                if(isset($v['is_enable']))
                {
                    $v['is_enable_text'] = $common_is_enable_tips[$v['is_enable']]['name'];
                }

                // 分类名称
                if(isset($v['brand_category_id']))
                {
                    $v['brand_category_name'] = Db::name('BrandCategory')->where(['id'=>$v['brand_category_id']])->value('name');
                }

                // logo
                if(isset($v['logo']))
                {
                    $v['logo_old'] = $v['logo'];
                    $v['logo'] =  ResourcesService::AttachmentPathViewHandle($v['logo']);
                }

                // 时间
                if(isset($v['add_time']))
                {
                    $v['add_time_time'] = date('Y-m-d H:i:s', $v['add_time']);
                    $v['add_time_date'] = date('Y-m-d', $v['add_time']);
                }
                if(isset($v['upd_time']))
                {
                    $v['upd_time_time'] = date('Y-m-d H:i:s', $v['upd_time']);
                    $v['upd_time_date'] = date('Y-m-d', $v['upd_time']);
                }
            }
        }
        return DataReturn('处理成功', 0, $data);
    }

    /**
     * 品牌总数
     * @param    [array]          $where [条件]
     */
    public static function BrandTotal($where)
    {
        return (int) Db::name('Brand')->where($where)->count();
    }

    /**
     * 列表条件
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function BrandListWhere($params = [])
    {
        $where = [];

        if(!empty($params['keywords']))
        {
            $where[] = ['name', 'like', '%'.$params['keywords'].'%'];
        }

        // 是否更多条件
        if(isset($params['is_more']) && $params['is_more'] == 1)
        {
            // 等值
            if(isset($params['is_enable']) && $params['is_enable'] > -1)
            {
                $where[] = ['is_enable', '=', intval($params['is_enable'])];
            }
            if(isset($params['brand_category_id']) && $params['brand_category_id'] > -1)
            {
                $where[] = ['brand_category_id', '=', intval($params['brand_category_id'])];
            }

            if(!empty($params['time_start']))
            {
                $where[] = ['add_time', '>', strtotime($params['time_start'])];
            }
            if(!empty($params['time_end']))
            {
                $where[] = ['add_time', '<', strtotime($params['time_end'])];
            }
        }

        return $where;
    }

    /**
     * 获取所有分类及下面品牌
     * @param    [array]          $where [条件]
     */
    public static function CategoryBrand($params = [])
    {
        $data = Db::name('BrandCategory')->where(['is_enable'=>1])->select();
        if(!empty($data))
        {
            foreach($data as &$v)
            {
                $v['items'] = Db::name('Brand')->field('id,name')->where(['is_enable'=>1, 'brand_category_id'=>$v['id']])->order('sort asc')->select();
            }
        }
        return $data;
    }

    /**
     * 分类下品牌列表
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function CategoryBrandList($params = [])
    {
        $brand_where = ['is_enable'=>1];

        // 分类id
        if(!empty($params['category_id']))
        {
            // 根据分类获取品牌id
            $category_ids = GoodsService::GoodsCategoryItemsIds([$params['category_id']], 1);
            $category_ids[] = $params['category_id'];
            $where = ['g.is_delete_time'=>0, 'g.is_shelves'=>1, 'gci.category_id'=>$category_ids];
            $brand_where['id'] = Db::name('Goods')->alias('g')->join(['__GOODS_CATEGORY_JOIN__'=>'gci'], 'g.id=gci.goods_id')->field('g.brand_id')->where($where)->group('g.brand_id')->column('brand_id');
        }

        // 关键字
        if(!empty($params['keywords']))
        {
            $where = [
                ['title', 'like', '%'.$params['keywords'].'%']
            ];
            $brand_where['id'] = Db::name('Goods')->where($where)->group('brand_id')->column('brand_id');
        }

        // 获取品牌列表
        $brand = Db::name('Brand')->where($brand_where)->field('id,name,logo,website_url')->select();
        if(!empty($brand))
        {
            foreach($brand as &$v)
            {
                $v['logo_old'] = $v['logo'];
                $v['logo'] = ResourcesService::AttachmentPathViewHandle($v['logo']);
                $v['website_url'] = empty($v['website_url']) ? null : $v['website_url'];
            }
        }
        return $brand;
    }

    /**
     * 获取品牌名称
     * @desc    description
     * @param   [int]          $brand_id [地区id]
     */
    public static function BrandName($brand_id = 0)
    {
        return empty($brand_id) ? null : Db::name('Brand')->where(['id'=>intval($brand_id)])->value('name');
    }

    /**
     * 品牌分类
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function BrandCategoryList($params = [])
    {
        $field = empty($params['field']) ? '*' : $params['field'];
        $order_by = empty($params['order_by']) ? 'sort asc' : trim($params['order_by']);

        $data = Db::name('BrandCategory')->where(['is_enable'=>1])->field($field)->order($order_by)->select();
        
        return DataReturn('处理成功', 0, $data);
    }

    /**
     * 保存
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function BrandSave($params = [])
    {
        // 请求类型
        $p = [
            [
                'checked_type'      => 'length',
                'key_name'          => 'name',
                'checked_data'      => '2,30',
                'error_msg'         => '名称格式 2~30 个字符',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'brand_category_id',
                'error_msg'         => '请选择品牌分类',
            ],
            [
                'checked_type'      => 'fun',
                'key_name'          => 'website_url',
                'checked_data'      => 'CheckUrl',
                'is_checked'        => 1,
                'error_msg'         => '官网地址格式有误',
            ],
            [
                'checked_type'      => 'length',
                'key_name'          => 'sort',
                'checked_data'      => '3',
                'error_msg'         => '顺序 0~255 之间的数值',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 附件
        $data_fields = ['logo'];
        $attachment = ResourcesService::AttachmentParams($params, $data_fields);

        // 数据
        $data = [
            'name'              => $params['name'],
            'brand_category_id' => intval($params['brand_category_id']),
            'logo'              => $attachment['data']['logo'],
            'website_url'       => empty($params['website_url']) ? '' : $params['website_url'],
            'sort'              => intval($params['sort']),
            'is_enable'         => isset($params['is_enable']) ? intval($params['is_enable']) : 0,
        ];

        if(empty($params['id']))
        {
            $data['add_time'] = time();
            $newDataId = Db::name('Brand')->insertGetId($data);
            if($newDataId > 0)
            {
                $params['message'] = Db::name('Brand')->where('id',$newDataId)->value('name');
                $logs = [
                    'admin_id'=>$params['admin']['id'],
                    'title'=>'增加',
                    'detail'=>$params['admin']['username'].'增加了品牌'.$params['message'],
                    'add_time'=>time()
                ];
                System::AdminLogSave($logs);
                return DataReturn('添加成功', 0);
            }
            return DataReturn('添加失败', -100);
        } else {
            $data['upd_time'] = time();
            if(Db::name('Brand')->where(['id'=>intval($params['id'])])->update($data))
            {
                $params['message'] = Db::name('Brand')->where(['id'=>intval($params['id'])])->value('name');
                $logs = [
                    'admin_id'=>$params['admin']['id'],
                    'title'=>'修改',
                    'detail'=>$params['admin']['username'].'修改了品牌'.$params['message']."信息",
                    'add_time'=>time()
                ];
                System::AdminLogSave($logs);
                return DataReturn('编辑成功', 0);
            }
            return DataReturn('编辑失败', -100); 
        }
    }

    /**
     * 删除
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function BrandDelete($params = [])
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
        $params['name'] = Db::name('Brand')->where(['id'=>$params['id']])->value('name');
        // 删除操作
        if(Db::name('Brand')->where(['id'=>$params['id']])->delete())
        {
            $logs = [
                'admin_id'=>$params['admin']['id'],
                'title'=>'删除',
                'detail'=>$params['admin']['username'].'删除了品牌'.$params['name'],
                'add_time'=>time()
            ];
            System::AdminLogSave($logs);
            return DataReturn('删除成功');
        }
        return DataReturn('删除失败或资源不存在', -100);
    }

    /**
     * 状态更新
     * @param    [array]          $params [输入参数]
     */
    public static function BrandStatusUpdate($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'id',
                'error_msg'         => '操作id有误',
            ],
            [
                'checked_type'      => 'in',
                'key_name'          => 'state',
                'checked_data'      => [0,1],
                'error_msg'         => '状态有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 数据更新
        if(Db::name('Brand')->where(['id'=>intval($params['id'])])->update(['is_enable'=>intval($params['state'])]))
        {
            $params['message'] = Db::name('Brand')->where(['id'=>intval($params['id'])])->value('name');
            $logs = [
                'admin_id'=>$params['admin']['id'],
                'title'=>'修改',
                'detail'=>$params['admin']['username'].'修改了品牌'.$params['message']."信息",
                'add_time'=>time()
            ];
            System::AdminLogSave($logs);
            return DataReturn('编辑成功');
        }
        return DataReturn('编辑失败或数据未改变', -100);
    }

    /**
     * 获取品牌分类节点数据
     * @param    [array]          $params [输入参数]
     */
    public static function BrandCategoryNodeSon($params = [])
    {
        // id
        $id = isset($params['id']) ? intval($params['id']) : 0;

        // 获取数据
        $field = '*';
        $data = Db::name('BrandCategory')->field($field)->where(['pid'=>$id])->order('sort asc')->select();
        if(!empty($data))
        {
            foreach($data as &$v)
            {
                $v['is_son']            =   (Db::name('BrandCategory')->where(['pid'=>$v['id']])->count() > 0) ? 'ok' : 'no';
                $v['ajax_url']          =   MyUrl('admin/brandcategory/getnodeson', array('id'=>$v['id']));
                $v['delete_url']        =   MyUrl('admin/brandcategory/delete');
                $v['json']              =   json_encode($v);
            }

            return DataReturn('操作成功', 0, $data);
        }
        return DataReturn('没有相关数据', -100);
    }

    /**
     * 品牌分类保存
     * @param    [array]          $params [输入参数]
     */
    public static function BrandCategorySave($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'length',
                'key_name'          => 'name',
                'checked_data'      => '2,16',
                'error_msg'         => '名称格式 2~16 个字符',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 数据
        $data = [
            'name'                  => $params['name'],
            'pid'                   => isset($params['pid']) ? intval($params['pid']) : 0,
            'sort'                  => isset($params['sort']) ? intval($params['sort']) : 0,
            'is_enable'             => isset($params['is_enable']) ? intval($params['is_enable']) : 0,
        ];

        // 添加
        if(empty($params['id']))
        {
            $data['add_time'] = time();
            $newId = Db::name('BrandCategory')->insertGetId($data);
            if($newId > 0)
            {
                $params['name'] = Db::name("BrandCategory")->where('id',$newId)->value('name');
                $logs = [
                    'admin_id'=>$params['admin']['id'],
                    'title'=>'增加',
                    'detail'=>$params['admin']['username'].'增加了品牌分类：'.$params['name'],
                    'add_time'=>time()
                ];
                System::AdminLogSave($logs);
                return DataReturn('添加成功', 0);
            }
            return DataReturn('添加失败', -100);
        } else {
            $data['upd_time'] = time();
            $params['name'] = Db::name("BrandCategory")->where('id',intval($params['id']))->value('name');
            if(Db::name('BrandCategory')->where(['id'=>intval($params['id'])])->update($data))
            {
                $logs = [
                    'admin_id'=>$params['admin']['id'],
                    'title'=>'修改',
                    'detail'=>$params['admin']['username'].'修改了品牌分类：'.$params['name']."信息",
                    'add_time'=>time()
                ];
                System::AdminLogSave($logs);
                return DataReturn('编辑成功', 0);
            }
            return DataReturn('编辑失败', -100);
        }
    }

    /**
     * 品牌分类删除
     * @param    [array]          $params [输入参数]
     */
    public static function BrandCategoryDelete($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'id',
                'error_msg'         => '删除数据id有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'admin',
                'error_msg'         => '用户信息有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }
        $params['name'] = Db::name('BrandCategory')->where(['id'=>intval($params['id'])])->value('name');
        // 开始删除
        if(Db::name('BrandCategory')->where(['id'=>intval($params['id'])])->delete())
        {
            $logs = [
                'admin_id'=>$params['admin']['id'],
                'title'=>'删除',
                'detail'=>$params['admin']['username'].'删除了品牌分类：'.$params['name']."信息",
                'add_time'=>time()
            ];
            System::AdminLogSave($logs);
            return DataReturn('删除成功', 0);
        }
        return DataReturn('删除失败', -100);
    }
}
?>