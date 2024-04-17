<?php

namespace App\Controller;

use App\Entity\Loginaso;
use App\Form\LoginasoType;
use App\Repository\LoginasoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Json;

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

    #[Route('/register', name: 'app_loginaso_register', methods: ['GET','POST'])]
    public function newData(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $loginaso = null;
        if($this->validateData($email,$password)){
            $product = $entityManager->getRepository(Loginaso::class)->findOneBy(['email' => $email]);
            if ($product === null) {
                $loginaso = new Loginaso();
                $loginaso->setPassword($password);
                $loginaso->setEmail($email);
                $entityManager->persist($loginaso);
                $entityManager->flush();
                return new JsonResponse("Se ha insertado correctamente.");
            }else{
                return new JsonResponse("No se ha insertado correctamente, revisa los datos.", 401);
            }
        } else{
            return new JsonResponse("No se ha insertado correctamente, revisa los datos.", 401);
        }
    }

    #[Route('/recibo', name: 'recibir_datos', methods: ['GET', 'POST'])]
    public function recibirDatos(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $loginaso = null;
        if($this->validateData($email,$password)){
            $product = $entityManager->getRepository(Loginaso::class)->findOneBy(['email' => $email, 'password' => $password]);
            if ($product !== null) {
                $loginaso = new Loginaso();
                $loginaso->setPassword($password);
                $loginaso->setEmail($email);
                return new JsonResponse("Usuario y contraseña correctos");
            }else{
                return new JsonResponse("No se ha encontrado un usuario con esos datos.", 401);
            }
        } else{
            return new JsonResponse("Datos incorrectos", 401);
        }
    }

    function validateData(string $email, string $password): bool {
        
        
        // Validar que ninguno de los datos sea más corto de 5 caracteres
        if (strlen($email) < 5 || strlen($password) < 5) {
            return false;
        }
    
        // Validar que el correo electrónico no sea más largo de 50 caracteres
        if (strlen($email) > 50) {
            return false;
        }
    
        // Validar que la contraseña no sea más larga de 20 caracteres
        if (strlen($password) > 20) {
            return false;
        }
    
        // Validar la estructura del correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
    
        // Si todas las validaciones pasan, retorna true
        return true;
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
