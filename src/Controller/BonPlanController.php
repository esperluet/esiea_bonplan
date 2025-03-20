<?php

namespace App\Controller;

use App\Entity\BonPlan;
use App\Form\Type\BonPlanType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route(path:"/bonplan", name:"bonplan-")]
class BonPlanController extends AbstractController
{

    #[Route(path:"/create", name:"create", methods: ["GET"])]
    public function create(CategorieRepository $categorieRepository): Response 
    {
        $bonplan = new BonPlan();
        $form = $this->createForm(BonPlanType::class, $bonplan);

        return $this->render(
            "bonplan/create.html.twig",
            [
                "form" => $form->createView(),
            ]
        );
    }
}