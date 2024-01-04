<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\CandidatureController;
use Symfony\Component\Serializer\Annotation\Groups;

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
    #[Groups("candidature")]
    public function getId(): ?int
    {
        return $this->id;
    }
    
    #[Groups("candidature")]
    public function getUserId(): ?User
    {
        return $this->user;
    }
    #[Groups("candidature")]
    public function setUserId(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
    #[Groups("candidature")]
    public function getFormationId(): ?Formation
    {
        return $this->formation;
    }
    #[Groups("candidature")]
    public function setFormationId(?Formation $formation): static
    {
        $this->formation= $formation;

        return $this;
    }
    #[Groups("candidature")]
    public function getValidation()
    {
        return $this->validation;
    }
    #[Groups("candidature")]
    public function setValidation($validation): static
    {
        $this->validation = $validation;

        return $this;
    }
}
