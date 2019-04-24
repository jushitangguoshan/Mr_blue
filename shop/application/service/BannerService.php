<?php

namespace app\service;

use think\Db;
use app\service\ResourcesService;

/**
 * 轮播服务层
 * @datetime 2016-12-01T21:51:08+0800
 */
class BannerService
{
    /**
     * 获取轮播
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function Banner($params = [])
    {
        $banner = Db::name('Slide')->field('name,images_url,event_value,event_type,bg_color')->where(['platform'=>APPLICATION_CLIENT_TYPE, 'is_enable'=>1])->order('sort asc')->select();
        if(!empty($banner))
        {
            foreach($banner as &$v)
            {
                $v['images_url_old'] = $v['images_url'];
                $v['images_url'] = ResourcesService::AttachmentPathViewHandle($v['images_url']);
                $v['event_value'] = empty($v['event_value']) ? null : $v['event_value'];
            }
        }
        return $banner;
    }

}
?>