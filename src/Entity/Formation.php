<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups; // Importer l'annotation Groups
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'formation_id', targetEntity: Candidature::class)]
    private Collection $candidatures;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
    }

    // Ajouter l'annotation @Groups("formation") pour spécifier le groupe de sérialisation
    #[Groups("formation")]
    public function getId(): ?int
    {
        return $this->id;
    }

    // Ajouter l'annotation @Groups("formation")
    #[Groups("formation")]
    public function getNom(): ?string
    {
        return $this->nom;
    }

    // Ajouter l'annotation @Groups("formation")
    #[Groups("formation")]
    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    // Ajouter l'annotation @Groups("formation")
    #[Groups("formation")]
    public function getStatus(): ?string
    {
        return $this->status;
    }

    // Ajouter l'annotation @Groups("formation")
    #[Groups("formation")]
    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Candidature>
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): static
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures->add($candidature);
            $candidature->setFormationId($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): static
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getFormationId() === $this) {
                $candidature->setFormationId(null);
            }
        }

        return $this;
    }
}
