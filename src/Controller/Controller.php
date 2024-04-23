<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class Controller extends AbstractController
{
    #[Route('/menu', name: 'app_controller')]
    public function index(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        return $this->json([
            'message' => 'Que pasa pisha',
            'path' => 'esta',
        ]);
    }
}
