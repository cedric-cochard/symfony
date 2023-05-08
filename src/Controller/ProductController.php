<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/category/{slug}", name="product_category")
     */
    public function category($slug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy([
            "slug" => $slug
        ]);
        
        if (!$category) {
           throw $this->createNotFoundException("La catégorie demandée n'existe pas");
        }

        return $this->render('product/category.html.twig', [
            "slug" => $slug,
            "category" => $category
        ]);
    }
    /**
     * @Route("/{category_slug}/{slug}", name="product_show")
     */
    public function show($slug, ProductRepository $productRepository) {

        $product = $productRepository->findOneBy([
            "slug" => $slug
        ]);

        if (!$product) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }

        return $this->render("product/show.html.twig", [
            "product" => $product
        ]);
    }

    /**
     * @Route("/admin/product/create", name="product_create")
     *
     */
    public function create(FormFactoryInterface $factory, Request $request, SluggerInterface $slugger, EntityManagerInterface $em) {


        $builder = $factory->createBuilder(FormType::class, null, [
           "data_class" => Product::class
        ]);

        $builder->add("name", TextType::class, [
            "label" => "Nom du produit",
            "attr" => ["placeholder" => "Tapez le nom du produit"]
        ])
            ->add("shortDescription", TextareaType::class, [
                "label" => "Description courte",
                "attr" => ["placeholder" => "Tapez du texte qui décrit le produit"]
            ])
            ->add("price", MoneyType::class, [
                "label" => "prix du produit",
                "attr" => ["placeholder" => "Tapez le prix du produit en €"]
            ])
            ->add("picture", UrlType::class, [
                "label" => "Image du produit",
                "attr" => [
                    "placeholder" => "Tapez une URL d'image !"
                ]
            ])
            ->add("category", EntityType::class, [
                "label" => "Catégorie",
                "placeholder" => "--Choisir une catégorie--",
                "class" => Category::class,
                "choice_label" => function(Category $category) {
                    return strtoupper($category->getName());
                } 
            ]); 

        $form = $builder->getForm();

        $form->handleRequest($request);

      if ($form->isSubmitted()) {
        $product = $form->getData();
        $product->setSlug(strtolower($slugger->slug($product->getName())));

        // $product = new Product;
        // $product->setName($data["name"])
        //     ->setShortDescription($data["shortDescription"])
        //     ->setPrice($data["price"])
        //     ->setCategory($data["category"]);
        $em->persist($product);
        $em->flush();
    
      }

       

        $formView = $form->createView();

        return $this->render("product/create.html.twig", [
            "formView" => $formView
        ]);
    }
}
