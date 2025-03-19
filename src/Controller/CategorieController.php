<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Form\Type\CategorieType;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route(path:"/categorie", name:"categorie-")]
class CategorieController extends AbstractController
{

    #[Route(path:"/create", name:"create", methods: ["GET", "POST"])]
    public function create(Request $request, CategorieRepository $categorieieRepository, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute("categorie-view", ["id"=> $categorie->getId()]);
        }

        $errors = $form->getErrors();

        return $this->render(
            "categorie/create.html.twig",
            [
                "form" => $form->createView(),
                "errors" => $errors
            ]
        );
    }

    #[Route(path:"/view/{id}", name:"view", methods: ["GET"])]
    public function view(int $id, CategorieRepository $categorieieRepository): Response
    {
        $categorie = $categorieieRepository->find($id);

        return $this->render(
            "categorie/view.html.twig",
            [
                "categorie" => $categorie
            ]
        );
    }

    
    #[Route(path:"/update/{id}", name:"update", methods: ["GET", "POST"])]
    public function update(int $id, Request $request, CategorieRepository $categorieRepository, EntityManagerInterface $entityManager): Response
    {
        $categorie = $categorieRepository->find($id);

        $user = $this->getUser();

        if(null === $categorie) {
            throw new NotFoundHttpException("Categorie inexistante");
        }
        
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $entityManager->flush();
            return $this->redirectToRoute("categorie-view", ["id"=> $categorie->getId()]);
        }

        return $this->render(
            "categorie/create.html.twig",
            [
                "form" => $form->createView()
            ]
        );
    }

    
    #[Route(path:"/list", name:"list", methods: ["GET"])]
    public function list(Request $request, CategorieRepository $categorieRepository, EntityManagerInterface $entityManager): Response
    {
        $categories = $categorieRepository->findAll();

        return $this->render(
            "categorie/list.html.twig",
            [
                "categories" => $categories
            ]
        );
    }

}