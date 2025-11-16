<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("", name: 'mainpage.')]
final class MainPageController extends AbstractController
{
    public function __construct(
        private readonly PageRepository $pageRepository,
    ) {
    }

    #[Route("", name: 'index')]
    public function index(): Response
    {
        // Получаем главную страницу по slug "home" или "index"
        $page = $this->pageRepository->findBySlug('home');
        
        // Получаем SEO данные из страницы, если они есть
        $seo = $page?->getSeo();

        return $this->render('main/index.html.twig', [
            'page' => $page,
            'seo' => $seo,
        ]);
    }
}
