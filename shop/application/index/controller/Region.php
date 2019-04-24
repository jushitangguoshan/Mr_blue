<?php

namespace app\index\controller;

use app\service\RegionService;

/**
 * 地区
 */
class Region extends Common
{
    /**
     * 构造方法
     * @desc    description
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取地区
     * @desc    description
     */
    public function Index()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        // 获取地区
        $params = [
            'where' => [
                'pid'   => intval(input('pid', 0)),
            ],
        ];
        $data = RegionService::RegionNode($params);
        return DataReturn('操作成功', 0, $data);
    }
}
?>