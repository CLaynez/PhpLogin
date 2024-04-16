<?php

namespace App\Controller;

use App\Entity\Loginaso;
use App\Form\LoginasoType;
use App\Repository\LoginasoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/loginaso')]
class LoginasoController extends AbstractController
{
    #[Route('/', name: 'app_loginaso_index', methods: ['GET'])]
    public function index(LoginasoRepository $loginasoRepository): Response
    {
        return $this->render('loginaso/index.html.twig', [
            'loginasos' => $loginasoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_loginaso_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $loginaso = new Loginaso();
        $form = $this->createForm(LoginasoType::class, $loginaso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($loginaso);
            $entityManager->flush();

            return $this->redirectToRoute('app_loginaso_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('loginaso/new.html.twig', [
            'loginaso' => $loginaso,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_loginaso_show', methods: ['GET'])]
    public function show(Loginaso $loginaso): Response
    {
        return $this->render('loginaso/show.html.twig', [
            'loginaso' => $loginaso,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_loginaso_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Loginaso $loginaso, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LoginasoType::class, $loginaso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_loginaso_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('loginaso/edit.html.twig', [
            'loginaso' => $loginaso,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_loginaso_delete', methods: ['POST'])]
    public function delete(Request $request, Loginaso $loginaso, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$loginaso->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($loginaso);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_loginaso_index', [], Response::HTTP_SEE_OTHER);
    }
}
