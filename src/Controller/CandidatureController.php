<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CandidatureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CandidatureController extends AbstractController
{
    #[Route('/api/candidater/{formationId}', name: 'app_candidater', methods:['POST'])]
    public function candidater(EntityManagerInterface $em,int $formationId,FormationRepository $formationRepository ): JsonResponse {
        
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['message' => 'Utilisateur non connecté'], Response::HTTP_UNAUTHORIZED);
        }

        $formation = $formationRepository->find($formationId);
      

        if (!$formation) {
            return new JsonResponse(['message' => 'Formation  non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $candidature = new Candidature();
        
        $candidature->setUserId($user)
                    ->setFormationId($formation)->setValidation("accepter");
                  

        $em->persist($candidature);
        $em->flush();

        return new JsonResponse(['message' => 'Candidature enregistrée avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/api/candidater/{candidatureId}', name: 'app_refusercandidater', methods:['PUT'])]
    public function refusercandidature(EntityManagerInterface $em,int $candidatureId,CandidatureRepository $CandidatureRepository ): JsonResponse 
    {
        $candidature = $CandidatureRepository->find($candidatureId);

        $candidature->setValidation("Refuser");
      

$em->persist($candidature);
$em->flush();
return new JsonResponse(['message' => 'Candidature Refusee avec succès'], Response::HTTP_CREATED);
        
    }
}
