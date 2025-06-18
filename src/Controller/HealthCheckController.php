<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/api/healthz', name: 'app_health_check', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json([
            'status' => 'ok',
            'timestamp' => time()
        ]);
    }
} 