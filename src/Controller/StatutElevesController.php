<?php

namespace App\Controller;

use App\Entity\StatutEleves;
use App\Form\StatutElevesType;
use App\Repository\StatutElevesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/statut/eleves')]
final class StatutElevesController extends AbstractController
{
    #[Route(name: 'app_statut_eleves_index', methods: ['GET'])]
    public function index(StatutElevesRepository $statutElevesRepository): Response
    {
        return $this->render('statut_eleves/index.html.twig', [
            'statut_eleves' => $statutElevesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_statut_eleves_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $statutElefe = new StatutEleves();
        $form = $this->createForm(StatutElevesType::class, $statutElefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($statutElefe);
            $entityManager->flush();

            return $this->redirectToRoute('app_statut_eleves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('statut_eleves/new.html.twig', [
            'statut_elefe' => $statutElefe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statut_eleves_show', methods: ['GET'])]
    public function show(StatutEleves $statutElefe): Response
    {
        return $this->render('statut_eleves/show.html.twig', [
            'statut_elefe' => $statutElefe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_statut_eleves_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StatutEleves $statutElefe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatutElevesType::class, $statutElefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_statut_eleves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('statut_eleves/edit.html.twig', [
            'statut_elefe' => $statutElefe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statut_eleves_delete', methods: ['POST'])]
    public function delete(Request $request, StatutEleves $statutElefe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$statutElefe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($statutElefe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_statut_eleves_index', [], Response::HTTP_SEE_OTHER);
    }
}
