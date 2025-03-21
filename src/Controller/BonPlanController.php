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

#[Route(path:"/bonplan", name:"bonplan_")]
class BonPlanController extends AbstractController
{

    #[Route(path:"/create", name:"create", methods: ["GET", "POST"])]
    public function create(Request $request, EntityManagerInterface $em): Response 
    {
        $bonPlan = new BonPlan();
        $form = $this->createForm(BonPlanType::class, $bonPlan);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            $bonplan = $form->getData();
            $em->persist($bonPlan);
            $em->flush();

            return $this->redirectToRoute('bonplan_view', ['id'=> $bonPlan->getId()]);
        }

        return $this->render(
            "bonplan/create.html.twig",
            [
                "form" => $form->createView(),
            ]
        );
    }

    #[Route(path:"/update/{id}", name:"update", methods: ["GET", "POST"])]
    public function update(Request $request, EntityManagerInterface $em, BonPlan $bonPlan): Response 
    {
        $form = $this->createForm(BonPlanType::class, $bonPlan);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $bonplan = $form->getData();
            $em->flush();
            return $this->redirectToRoute('bonplan_view', ['id'=> $bonPlan->getId()]);
        }

        return $this->render(
            "bonplan/create.html.twig",
            [
                "form" => $form->createView(),
            ]
        );
    }

    #[Route(path:"/view/{id}", name:"view", methods: ["GET"])]
    public function view(BonPlan $bonPlan)
    {
        return $this->render(
            'bonplan/view.html.twig',
            [
                'bonPlan' => $bonPlan
            ]
        );
    }

    #[Route(path:"/delete/{id}", name:"delete", methods: ["DELETE"])]
    public function delete(Request $request, EntityManagerInterface $em, BonPlan $bonPlan): Response 
    {
        $form = $this->createForm(BonPlanType::class, $bonPlan);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $em->remove($bonPlan);
            $em->flush();
            return $this->redirectToRoute('bonplan_list');
        }

        return $this->render(
            "bonplan/create.html.twig",
            [
                "form" => $form->createView(),
            ]
        );
    }

    #[Route(path:"/list", name:"list", methods: ["GET"])]
    public function list(EntityManagerInterface $em)
    {
        $bonPlans = $em->getRepository(BonPlan::class)->findAll();
        return $this->render(
            'bonplan/list.html.twig',
            [
                'bonPlans' => $bonPlans
            ]
        );
    }

}