<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups; // Importer l'annotation Groups

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
}
