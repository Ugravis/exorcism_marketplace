<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServicesController extends AbstractController
{
    #[Route('/services', name: 'app_services')]
    public function index(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findAll();

        return $this->render('services/index.html.twig', [
            'services' => $services
        ]);
    }

    #[Route('/services/{id}', name: 'app_service_details', requirements: ['id'=>'\d+'])]
    public function detail(ServiceRepository $serviceRepository, int $id): Response
    {
        $service = $serviceRepository->find($id);

        return $this->render('services/show.html.twig', [
            'service' => $service,
        ]);
    }
}