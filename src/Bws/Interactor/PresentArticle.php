<?php

namespace Bws\Interactor;

use Bws\Repository\ArticleRepository;

class PresentArticle
{
    /**
     * @var \Bws\Repository\ArticleRepository
     */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param int $articleId
     *
     * @return PresentArticleResponse
     */
    public function execute($articleId)
    {
        if (!$article = $this->articleRepository->find($articleId)) {
            return new PresentArticleResponse(PresentArticleResponse::ARTICLE_NOT_FOUND);
        }

        return new PresentArticleResponse(PresentArticleResponse::SUCCESS, $article);
    }
}
