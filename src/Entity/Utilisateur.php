<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[Broadcast]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Unique]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\PasswordStrength]
    private ?string $password = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $roles = [];

    /**
     * @var Collection<int, BonPlan>
     */
    #[ORM\OneToMany(targetEntity: BonPlan::class, mappedBy: 'proprietaire')]
    private Collection $bonPlans;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'auteur', orphanRemoval: true)]
    private Collection $commentaires;

    /**
     * @var Collection<int, BonPlan>
     */
    #[ORM\ManyToMany(targetEntity: BonPlan::class, inversedBy: 'utilisateurs_favoris')]
    private Collection $favoris;

    public function __construct()
    {
        $this->bonPlans = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->favoris = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection<int, BonPlan>
     */
    public function getBonPlans(): Collection
    {
        return $this->bonPlans;
    }

    public function addBonPlan(BonPlan $bonPlan): static
    {
        if (!$this->bonPlans->contains($bonPlan)) {
            $this->bonPlans->add($bonPlan);
            $bonPlan->setProprietaire($this);
        }

        return $this;
    }

    public function removeBonPlan(BonPlan $bonPlan): static
    {
        if ($this->bonPlans->removeElement($bonPlan)) {
            // set the owning side to null (unless already changed)
            if ($bonPlan->getProprietaire() === $this) {
                $bonPlan->setProprietaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setAuteur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getAuteur() === $this) {
                $commentaire->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BonPlan>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(BonPlan $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
        }

        return $this;
    }

    public function removeFavori(BonPlan $favori): static
    {
        $this->favoris->removeElement($favori);

        return $this;
    }
}
