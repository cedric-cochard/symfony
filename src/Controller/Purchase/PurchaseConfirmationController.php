<?php 

namespace App\Controller\Purchase;

use DateTimeImmutable;
use App\Entity\Purchase;
use App\Cart\CartService;
use App\Entity\PurchaseItem;
use App\Form\CartConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PurchaseConfirmationController extends AbstractController {

  protected $cartService;
  protected $em;


  public function __construct(CartService $cartService, EntityManagerInterface $em)
  {
    $this->cartService = $cartService;
    $this->em = $em;
  }

  /**
   * Undocumented function
   *@Route("purchase/confirm", name="purchase_confirm")
   *@IsGranted("ROLE_USER", message="Vous devez être connecté pour confirmer une commande")
   */
  public function confirm(Request $request) {

    $form = $this->createForm(CartConfirmationType::class);

    $form->handleRequest($request);

    if (!$form->isSubmitted()) {
      $this->addFlash("warning", "Vous devez remplir le formulaire de confirmation");
      return $this->redirectToRoute("cart_show");
      
    }

    $user = $this->getUser();


    $cartItems = $this->cartService->getDetailledCartItems();

    if ($cartItems === 0) {
      $this->addFlash("warning", "Vous ne pouvez pas confirmer une commande avec un panier vide");

      return $this->redirectToRoute("cart_show");
     
    }
    /** @var Purchase */
    $purchase = $form->getData();
    
    $purchase->setUser($user)
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

    $this->cartService->empty();

    $this->addFlash("success", "La commande a bien été enregistré");

    return $this->redirectToRoute("purchase_index");
  }
}