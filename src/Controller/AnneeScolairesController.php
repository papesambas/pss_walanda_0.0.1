<?php

namespace App\Controller;

use App\Entity\AnneeScolaires;
use App\Form\AnneeScolairesType;
use App\Repository\AnneeScolairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/annee/scolaires')]
final class AnneeScolairesController extends AbstractController
{
    #[Route(name: 'app_annee_scolaires_index', methods: ['GET'])]
    public function index(AnneeScolairesRepository $anneeScolairesRepository): Response
    {
        return $this->render('annee_scolaires/index.html.twig', [
            'annee_scolaires' => $anneeScolairesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_annee_scolaires_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $anneeScolaire = new AnneeScolaires();
        $form = $this->createForm(AnneeScolairesType::class, $anneeScolaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($anneeScolaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_annee_scolaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annee_scolaires/new.html.twig', [
            'annee_scolaire' => $anneeScolaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_scolaires_show', methods: ['GET'])]
    public function show(AnneeScolaires $anneeScolaire): Response
    {
        return $this->render('annee_scolaires/show.html.twig', [
            'annee_scolaire' => $anneeScolaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annee_scolaires_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AnneeScolaires $anneeScolaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnneeScolairesType::class, $anneeScolaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annee_scolaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annee_scolaires/edit.html.twig', [
            'annee_scolaire' => $anneeScolaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_scolaires_delete', methods: ['POST'])]
    public function delete(Request $request, AnneeScolaires $anneeScolaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$anneeScolaire->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($anneeScolaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annee_scolaires_index', [], Response::HTTP_SEE_OTHER);
    }
}
