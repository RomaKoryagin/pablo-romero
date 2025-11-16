<?php

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    public function __construct(
        private readonly PageRepository $pageRepository
    ) {
    }

    #[Route('/page/{slug}', name: 'app_page_show')]
    public function show(string $slug): Response
    {
        $page = $this->pageRepository->findBySlug($slug);

        if (!$page) {
            throw $this->createNotFoundException('Страница не найдена');
        }

        return $this->render('page/show.html.twig', [
            'page' => $page,
            'seo' => $page->getSeo(),
        ]);
    }
}
