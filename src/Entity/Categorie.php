<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]    
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $nom = null;

    /**
     * @var Collection<int, BonPlan>
     */
    #[ORM\OneToMany(targetEntity: BonPlan::class, mappedBy: 'categorie')]
    private Collection $bonsPlans;

    public function __construct()
    {
        $this->bonsPlans = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, BonPlan>
     */
    public function getBonsPlans(): Collection
    {
        return $this->bonsPlans;
    }

    public function addBonsPlan(BonPlan $bonsPlan): static
    {
        if (!$this->bonsPlans->contains($bonsPlan)) {
            $this->bonsPlans->add($bonsPlan);
            $bonsPlan->setCategorie($this);
        }

        return $this;
    }

    public function removeBonsPlan(BonPlan $bonsPlan): static
    {
        if ($this->bonsPlans->removeElement($bonsPlan)) {
            // set the owning side to null (unless already changed)
            if ($bonsPlan->getCategorie() === $this) {
                $bonsPlan->setCategorie(null);
            }
        }

        return $this;
    }
}
