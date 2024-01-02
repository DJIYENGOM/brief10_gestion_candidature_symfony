<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    /**
     * @Route('/api/listformation', name='app_listformation', methods=['GET'])
     */
    public function listFormation(FormationRepository $formationRepository): JsonResponse
    {
        $formations = $formationRepository->findAll();

        return $this->json($formations, 200, [], ['groups' => 'formation']);
    }
/**
 * @Route('/api/addformation', name='app_addformation', methods=['POST'])
 */
public function addFormation(Request $request, EntityManagerInterface $entityManager): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    // Vérifier si les clés nécessaires 'nom' et 'status' existent dans $data
    if (!isset($data['nom']) || !isset($data['status'])) {
        return $this->json(['message' => 'Les clés nécessaires "nom" et "status" sont manquantes dans les données.'], 400);
    }

    $formation = new Formation();
    $formation->setNom($data['nom']);
    $formation->setStatus($data['status']);

    $entityManager->persist($formation);
    $entityManager->flush();

    return $this->json($formation, 200, [], ['groups' => 'formation']);
}

    /**
     * @Route('/api/updateformation/{id}', name='app_updateformation', methods=['PUT'])
     */
    public function updateFormation(int $id, Request $request, FormationRepository $formationRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $formation = $formationRepository->find($id);

        if (!$formation) {
            return $this->json(['message' => 'Formation non trouvée'], 404);
        }

        $formation->setNom($data['nom'] ?? $formation->getNom());
        $formation->setStatus($data['status'] ?? $formation->getStatus());

        $entityManager->flush();

        return $this->json($formation, 200, [], ['groups' => 'formation']);
    }

    /**
     * @Route('/api/deleteformation/{id}', name='app_deleteformation', methods=['DELETE'])
     */
    public function deleteFormation(int $id, FormationRepository $formationRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $formation = $formationRepository->find($id);

        if (!$formation) {
            return $this->json(['message' => 'Formation non trouvée'], 404);
        }

        $entityManager->remove($formation);
        $entityManager->flush();

        return $this->json(['message' => 'Formation supprimée avec succès'], 200);
    }
}
