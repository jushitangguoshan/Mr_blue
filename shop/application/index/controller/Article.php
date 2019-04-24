<?php

namespace app\index\controller;

use app\service\ArticleService;

/**
 * 文章详情
 */
class Article extends Common
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
     * [Index 文章详情]
     */
	public function Index()
	{
		// 获取文章
		$id = input('id');
		$params = [
			'where' => ['a.is_enable'=>1, 'a.id'=>$id],
			'field' => 'a.id,a.title,a.title_color,a.jump_url,a.content,a.access_count,a.article_category_id,a.add_time',
			'm' => 0,
			'n' => 1,
		];
		$article = ArticleService::ArticleList($params);
		if(!empty($article['data'][0]))
		{
			// 访问统计
			ArticleService::ArticleAccessCountInc(['id'=>$id]);

			// 是否外部链接
			if(!empty($article['data'][0]['jump_url']))
			{
				return redirect($article['data'][0]['jump_url']);
			}

			// 浏览器标题
			$this->assign('home_seo_site_title', $this->GetBrowserSeoTitle($article['data'][0]['title'], 1));

			// 获取分类和文字
			$article_category_content = ArticleService::ArticleCategoryListContent();
            $this->assign('category_list', $article_category_content['data']);

			$this->assign('article', $article['data'][0]);
			return $this->fetch();
		} else {
			$this->assign('msg', '文章不存在或已删除');
			return $this->fetch('public/tips_error');
		}
	}
}
?>