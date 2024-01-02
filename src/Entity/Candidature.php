<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\CandidatureController;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
#[ApiResource(operations: [
    new GetCollection(),
    new Post(
        name: 'app_candidater', 
        uriTemplate: '/api/candidater/{formationId}', 
        controller: CandidatureController::class.'::candidater'
    ),
    new Post(
        name: 'app_refusercandidater', 
        uriTemplate: '/api/candidater/{candidatureId}', 
        controller:CandidatureController::class.'::refusercandidature'
    )
])]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    private ?Formation $formation = null;

   // #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    #[ORM\Column(type: Types::STRING,options: ['default' => 'En_cour'])]

    private string $validation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getFormationId(): ?Formation
    {
        return $this->formation;
    }

    public function setFormationId(?Formation $formation): static
    {
        $this->formation= $formation;

        return $this;
    }

    public function getValidation()
    {
        return $this->validation;
    }

    public function setValidation($validation): static
    {
        $this->validation = $validation;

        return $this;
    }
}
