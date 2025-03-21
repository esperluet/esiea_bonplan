<?php

namespace App\Services\Commentaire;

use App\Entity\Commentaire;
interface CommentaireRepositoryInterface
{
    public function save(Commentaire $commentaire): Commentaire;
}