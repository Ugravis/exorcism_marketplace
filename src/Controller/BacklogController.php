<?php

    namespace App\Controller;

    use App\Entity\Service;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    final class BacklogController extends AbstractController
    {
        #[Route('/backlog/{id}', name: 'app_backlog_show')]
        public function show(int $id, EntityManagerInterface $em): Response
        {
            $service = $em->getRepository(Service::class)->find($id);

            if (!$service) {
                throw $this->createNotFoundException('Service non trouvé.');
            }
            
            return $this->render('backlog/index.html.twig', [
                'service' => $service,
            ]);
        }
    }