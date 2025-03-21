<?php

namespace App\Api;

use App\Entity\BonPlan;
use App\Services\Commentaire\CreateCommentaireService;
use App\Services\Commentaire\DTO\CreateCommentaireDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[Route(path:"/comments", name:"comments_")]
class CommentaireApi extends AbstractController
{
    #[Route(path:"", name:"create", methods: ["POST"])]
    public function create(Request $request, CreateCommentaireService $createService, EntityManagerInterface $em): JsonResponse
    {

        // récupérer et parser la requête
        $data = json_decode($request->getContent(), true);

        // Construction des paramètres d'appel

        $createDTO = new CreateCommentaireDTO();
        $createDTO->auteur = $this->getUser();
        $createDTO->contenu = $data["contenu"];

        $bonPlan = $em->getRepository(BonPlan::class)->find($data["bonplan_id"]);
        $createDTO->bonPlan = $bonPlan;
        
        // faire appel au service de création
        $commentaire = $createService->create($createDTO);

        //Renvoi de la méthode
        return $this->json([
            'id' => $commentaire->getId(),
            'contenu' => $commentaire->getContenu()
        ], Response::HTTP_CREATED);
    }
}