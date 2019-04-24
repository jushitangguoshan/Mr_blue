<?php

namespace app\index\controller;

/**
 * 商品分类
 */
class Category extends Common
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
     * 首页
     */
    public function Index()
    {
        return $this->fetch();
    }
}
?>