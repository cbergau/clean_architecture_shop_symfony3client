<?php

namespace BwsShop\WebBundle\Controller;

use Bws\Usecase\PresentArticles\PresentArticles;
use Bws\Usecase\SearchArticles\SearchArticles;
use Bws\Usecase\SearchArticles\SearchArticlesRequest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends FOSRestController
{
    public function indexAction()
    {
        /** @var PresentArticles $presentArticles */
        $presentArticles = $this->get('interactor.present_articles');
        $articles = $presentArticles->execute()->getArticles();
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

        /** @var SearchArticles $interactor */
        $interactor = $this->get('interactor.search_articles');
        $articles = $interactor->execute($searchRequest)->getArticles();

        $view = $this
            ->view($articles, 200)
            ->setTemplate('BwsShopWebBundle:Article:index.html.twig')
            ->setTemplateVar('articles');

        return $this->handleView($view);
    }

    public function viewAction(Request $request)
    {
        $presentArticle = $this->get('interactor.present_article');
        $article = $presentArticle->execute($request->get('id'))->getArticle();
        $view = $this
            ->view($article, 200)
            ->setTemplate('BwsShopWebBundle:Article:view.html.twig')
            ->setTemplateVar('article');

        return $this->handleView($view);
    }
}
