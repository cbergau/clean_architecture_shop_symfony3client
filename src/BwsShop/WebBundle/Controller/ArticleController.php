<?php

namespace BwsShop\WebBundle\Controller;

use Bws\Interactor\SearchArticlesRequest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends FOSRestController
{
    public function indexAction()
    {
        $articles = $this->get('interactor.present_articles')->execute()->getArticles();
        return $this->render('BwsShopWebBundle:Article:index.html.twig', array('articles' => $articles));
    }

    /**
     * @View()
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $searchRequest = new SearchArticlesRequest($request->get('by'));
        $articles      = $this->get('interactor.search_articles')->execute($searchRequest)->getArticles();

        $view = $this
            ->view($articles, 200)
            ->setTemplate('BwsShopWebBundle:Article:index.html.twig')
            ->setTemplateVar('articles');

        return $this->handleView($view);
    }

    public function viewAction(Request $request)
    {
        $article = $this->get('interactor.present_article')->execute($request->get('id'))->getArticle();
        $view    = $this
            ->view($article, 200)
            ->setTemplate('BwsShopWebBundle:Article:view.html.twig')
            ->setTemplateVar('article');

        return $this->handleView($view);
    }
}
