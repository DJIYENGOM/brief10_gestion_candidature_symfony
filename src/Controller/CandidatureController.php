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
use Symfony\Component\Security\Http\Attribute\IsGranted;


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


    #[IsGranted("ROLE_ADMIN", message: 'Vous n\'avez pas les droits suffisants pour publier une formation')]
   
    #[Route('/api/listCandidature', name:'app_listCandidature', methods:['GET'])]
   
    public function listCandidature(CandidatureRepository $CandidatureRepository): JsonResponse
    {
        $Candidatures = $CandidatureRepository->findAll();
    
        return $this->json($Candidatures, 200, [], ['groups' => ['candidature', 'formation', 'user']]);      
    }

    #[Route('/api/listCandidatureRefuge', name:'app_listCandidatureRefuge', methods:['GET'])]

    public function listCandidatureRefuge(CandidatureRepository $candidatureRepository): JsonResponse
    {
        $candidatures = $candidatureRepository->createQueryBuilder('c')
            ->where('c.validation = :validation')
            ->setParameter('validation', 'Refuser')
            ->getQuery()
            ->getResult();
    
        return $this->json($candidatures, 200, [], ['groups' => ['candidature', 'formation', 'user']]);
    }

    #[Route('/api/listCandidatureAccepte', name:'app_listCandidatureAccepte', methods:['GET'])]

    public function listCandidatureAccepte(CandidatureRepository $candidatureRepository): JsonResponse
    {
        $candidatures = $candidatureRepository->createQueryBuilder('c')
            ->where('c.validation = :validation')
            ->setParameter('validation', 'Accepte')
            ->getQuery()
            ->getResult();
    
        return $this->json($candidatures, 200, [], ['groups' => ['candidature', 'formation', 'user']]);
    }
}