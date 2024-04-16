<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/recibo', name: 'recibir_datos', methods: ['GET', 'POST'])]
    public function recibirDatos(Request $request): JsonResponse
    {
        // Obtener los datos enviados en formato JSON
        $contenido = $request->getContent();

        // Decodificar el JSON
        $datos = json_decode($contenido, true);

        // Devolver una respuesta
        return new JsonResponse($datos);
    }
}
