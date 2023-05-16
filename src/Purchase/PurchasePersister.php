<?php 

namespace App\Purchase;

use App\Cart\CartService;
use DateTimeImmutable;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePersister extends AbstractController {

  protected $cartService;
  protected $em;

  public function __construct(CartService $cartService, EntityManagerInterface $em)
  {
    $this->cartService = $cartService;
    $this->em = $em;
  }


    public function storePurchase(Purchase $purchase) {

      $purchase->setUser($this->getUser())
        ->setPurchaseAt(new DateTimeImmutable())
        ->setTotal($this->cartService->getTotal());

    $this->em->persist($purchase);

    foreach ($this->cartService->getDetailledCartItems() as $cartItem) {
      $purchaseItem = new PurchaseItem;
      $purchaseItem->setPurchase($purchase)
              ->setProduct($cartItem->product)
              ->setProductName($cartItem->product->getName())
              ->setQuantity($cartItem->quantity)
              ->setTotal($cartItem->getTotal())
              ->setProductPrice($cartItem->product->getPrice());

      $this->em->persist($purchaseItem);

    }
    $this->em->flush();
    }

}