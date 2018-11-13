<?php
declare(strict_types=1);

namespace App\Presenters;

/**
 * Article presenter.
 */
class ArticlePresenter extends BasePresenter
{

	public function renderDetail($id)
	{
		$article = $this->articleManager->getBySlug($id);

		$this->template->article = $article;
	}

}
