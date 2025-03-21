<?php

namespace App\Services\Commentaire;

use App\Entity\Commentaire;
use App\Services\Commentaire\DTO\CreateCommentaireDTO;
use Doctrine\ORM\EntityManagerInterface;

class CreateCommentaireService
{
    public function __construct(private EntityManagerInterface $em){
    }
    public function create(CreateCommentaireDTO $data): Commentaire
    {
        // check les infos reçues
        if( false === $this->check($data) ){
            throw new \Exception("unable to create a comment");
        }

        $commentaire = new Commentaire();

        $commentaire->setContenu($data->contenu);
        $commentaire->setAuteur($data->auteur);
        $commentaire->setBonPlan($data->bonPlan);

        $this->em->persist($commentaire);
        $this->em->flush();

        return $commentaire;
    }

    private function check(CreateCommentaireDTO $data): bool
    {
        return true;
    }
}