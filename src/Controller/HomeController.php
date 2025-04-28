<?php

/**
* The HomeController manages the main landing page and about page for the La Boot'ique e-commerce platform. 
* 
* It handles two routes: the homepage (root URL) which displays featured products and header content in a carousel layout, and the about page ('/a-propos') which presents information about the company. 
* 
* The controller interacts with product and header repositories to retrieve the necessary data for display, and renders the appropriate Twig templates with the required context variables.
*/

namespace App\Controller;

use App\Repository\HeadersRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
    * Renders the homepage of the La Boot'ique e-commerce platform, displaying featured products and headers with a carousel.
    * 
    * @param ProductRepository productRepository Repository used to fetch products marked for homepage display
    * @param HeadersRepository headersRepository Repository used to fetch all header elements
    * 
    * @return Response object containing the rendered homepage template with carousel, featured products, and headers
    */
    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepository, HeadersRepository $headersRepository): Response
    {
        $products = $productRepository->findByIsInHome(1);
        $headers = $headersRepository->findAll();
        return $this->render('home/index.html.twig', [
            'carousel' => true,  //Le caroussel ne s'affiche que sur la page d'accueil (voir base.twig)
            'top_products' => $products,
            'headers' => $headers
        ]);
    }

    /**
    * Renders the About page of the La Boot'ique e-commerce platform.
    * 
    * @return Response object containing the rendered 'home/about.html.twig' template.
    */
    #[Route('a-propos', name: 'about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }
}
