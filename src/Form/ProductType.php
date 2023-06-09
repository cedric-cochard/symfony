<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\DataTransformer\CentimesTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add("name", TextType::class, [
            "label" => "Nom du produit",
            "attr" => ["placeholder" => "Tapez le nom du produit"],
            "required" => false,
        ])
            ->add("shortDescription", TextareaType::class, [
                "label" => "Description courte",
                "attr" => ["placeholder" => "Tapez du texte qui décrit le produit"]
            ])
            ->add("price", MoneyType::class, [
                "label" => "prix du produit",
                "attr" => ["placeholder" => "Tapez le prix du produit en €"],
                "divisor" => 100,
                "required" => false,
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
        
        // $builder->get("price")->addModelTransformer(new CentimesTransformer);
        //     function($value) {
        //         if ($value === null) {
        //           return;
        //         }
        //         return $value / 100;
        //     },
        //     function($value) {
        //         if ($value === null) {
        //             return;
        //         }
        //         return $value * 100;
                
        //     }
        // ));
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
