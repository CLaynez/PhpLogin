<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class Controller extends AbstractController
{
    #[Route('/', name: 'app_controller')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Que pasa pisha',
            'path' => 'esta',
        ]);
    }
}
