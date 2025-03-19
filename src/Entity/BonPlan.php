<?php

namespace App\Entity;

use App\Repository\BonPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BonPlanRepository::class)]
class BonPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dat_validite = null;

    #[ORM\ManyToOne(inversedBy: 'bonPlans')]
    private ?Utilisateur $proprietaire = null;

    #[ORM\ManyToOne(inversedBy: 'bonsPlans')]
    private ?Categorie $categorie = null;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'bonPlan', orphanRemoval: true)]
    private Collection $commentaires;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'bonPlan', orphanRemoval: true)]
    private Collection $images;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: 'favoris')]
    private Collection $utilisateurs_favoris;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->utilisateurs_favoris = new ArrayCollection();
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDatValidite(): ?\DateTimeInterface
    {
        return $this->dat_validite;
    }

    public function setDatValidite(?\DateTimeInterface $dat_validite): static
    {
        $this->dat_validite = $dat_validite;

        return $this;
    }

    public function getProprietaire(): ?Utilisateur
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Utilisateur $proprietaire): static
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

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
            $commentaire->setBonPlan($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getBonPlan() === $this) {
                $commentaire->setBonPlan(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setBonPlan($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getBonPlan() === $this) {
                $image->setBonPlan(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateursFavoris(): Collection
    {
        return $this->utilisateurs_favoris;
    }

    public function addUtilisateursFavori(Utilisateur $utilisateursFavori): static
    {
        if (!$this->utilisateurs_favoris->contains($utilisateursFavori)) {
            $this->utilisateurs_favoris->add($utilisateursFavori);
            $utilisateursFavori->addFavori($this);
        }

        return $this;
    }

    public function removeUtilisateursFavori(Utilisateur $utilisateursFavori): static
    {
        if ($this->utilisateurs_favoris->removeElement($utilisateursFavori)) {
            $utilisateursFavori->removeFavori($this);
        }

        return $this;
    }
}
