<?php

namespace App\Api;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Response};
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;

#[Route(path:"/categories", name:"categories_")]
class CategorieApi extends AbstractController
{
    #[Route(path:"", name:"list", methods: ["GET"])]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $categories = $em->getRepository(Categorie::class)->findAll();
        $formatedCategories = $this->buildCategorie($categories);
        
        return $this->json($formatedCategories, Response::HTTP_OK);
    }

    private function buildCategorie(array $categories): array
    {
        $formatedCategories = [];
        foreach ($categories as $categorie) {
            $formatedCategories[] = [
                "id"=> $categorie->getId(),
                "name"=> $categorie->getNom(),
            ];
        }
        return $formatedCategories;
    }
}