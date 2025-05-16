<?php

/**
* This file contains the ProductController for the La Boot'ique e-commerce platform, which manages the product browsing functionality. 
* 
* It defines two main routes: one for displaying a list of all products with search capabilities, and another for showing detailed information about a specific product. 
* The controller interacts with the ProductRepository to fetch product data from the database and renders appropriate Twig templates to display the information. 
* 
* The search functionality allows users to filter products based on criteria defined in a SearchType form, enhancing the shopping experience by helping customers find specific items more efficiently.
*/

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\ProductRepository;
use App\Model\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
    * Handles the product listing page, displaying all products or filtered results based on search criteria. Creates and processes a search form, then renders the product index template with the appropriate products.
    * 
    * @param ProductRepository repository Repository used to fetch product data from the database
    * @param Request request The HTTP request object containing form submission data
    * 
    * @return Response object containing the rendered product listing page with products and search form
    */
    #[Route('/articles', name: 'product')]
    public function index(ProductRepository $repository, Request $request): Response
    {
       
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $repository->findWithSearch($search);
        } else {
            $products = $repository->findAll();
        }

        
        return $this->renderForm('product/index.html.twig', [
            'products' => $products,
            'form' => $form,
        ]);
    }

    /**
    * Displays the detail page for a specific product identified by its slug. If the product is not found, redirects to the product listing page.
    * 
    * @param ProductRepository repository Repository used to fetch product data from the database
    * @param string slug URL-friendly identifier for the product
    * 
    * @return Response object containing either the rendered product detail page or a redirect to the product listing page
    */
    #[Route('/articles/{slug}', name: 'product_show')]
    public function show(ProductRepository $repository, string $slug): Response
    {
        $product = $repository->findOneBySlug($slug);

        if (!$product) {
            return $this->redirectToRoute('product');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}


