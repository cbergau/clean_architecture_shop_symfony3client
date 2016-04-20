<?php

namespace Bws\Interactor;

class SearchArticlesResponse
{
    /**
     * @var array
     */
    private $articles;

    public function __construct(array $articles)
    {
        $this->articles = $articles;
    }

    /**
     * @return array
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
