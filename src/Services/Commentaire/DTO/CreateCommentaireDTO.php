<?php

namespace App\Services\Commentaire\DTO;

use App\Entity\{BonPlan, Utilisateur};
use Symfony\Component\Validator\Constraints as Assert;

class CreateCommentaireDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 255)]
    public string $contenu;

    public Utilisateur $auteur;

    public BonPlan $bonPlan;
}