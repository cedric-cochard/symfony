<?php 

namespace App\Controller\Purchase;

use App\Entity\User;
use Twig\Environment;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PurchasesListController extends AbstractController {

  /**
   * Undocumented function
   *@Route("/purchases", name="purchase_index")
   *@IsGranted("ROLE_USER", message="Vous devez être connecté pour accèder à vos commandes")
   */
  public function index() {
    /**
     * @var User
     */
    $user = $this->getUser();

   
    return $this->render("purchase/index.html.twig", [
      "purchases" => $user->getPurchases()
    ]);
  }

}