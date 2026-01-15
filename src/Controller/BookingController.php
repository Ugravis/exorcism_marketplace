<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Customer;
use App\Entity\Service;
use App\Form\BookingStep1Type;
use App\Form\BookingStep2Type;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookingController extends AbstractController
{
    #[Route('services/{id}/booking/step-1', name: 'app_booking_step1')]
    public function step1(Service $service, Request $request): Response
    {
        $session = $request->getSession();
        $session->start();
        $booking = $session->get('booking', new Booking());

        if (!$booking->getCustomer()) {
            $booking->setCustomer(new Customer());
        }

        $booking->setService($service);

        $form = $this->createForm(BookingStep1Type::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $request->getSession()->set('booking', $booking);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $request->getSession()->set('booking', $booking);
            return $this->redirectToRoute('app_booking_step2', ['id' => $service->getId()]);
        }

        return $this->render('/booking/step1.html.twig', [
            'form' => $form->createView(),
            'service' => $service
        ]);
    }

    #[Route('services/{id}/booking/step-2', name: 'app_booking_step2')]
    public function step2(Service $service, Request $request, EntityManagerInterface $entityManager): Response
    {
        $booking = $request->getSession()->get('booking');

        if (!$booking) {
            return $this->redirectToRoute('app_booking_step1', ['id' => $service->getId()]);
        }
        if (!$booking->getCustomer()) {
            $booking->setCustomer(new Customer());
        }

        $form = $this->createForm(BookingStep2Type::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $request->getSession()->set('booking', $booking);

            if ($form->get('back')->isClicked()) {
                return $this->redirectToRoute('app_booking_step1', ['id' => $service->getId()]);
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $booking->getCustomer();
            $existingCustomer = $entityManager->getRepository(Customer::class)->findOneBy(['email' => $customer->getEmail()]);

            if ($existingCustomer) {
                $booking->setCustomer($existingCustomer);
            } else {
                $entityManager->persist($customer);
            }

            $serviceRef = $entityManager->getReference(Service::class, $booking->getService()->getId());
            $booking->setService($serviceRef);

            $entityManager->persist($booking);
            $entityManager->flush();
            
            $request->getSession()->remove('booking');

            return $this->redirectToRoute('app_booking_success', [
                'id' => $booking->getId()
            ]);
        }

        $existingBookings = $entityManager->getRepository(Booking::class)
            ->findBy(['service' => $service]);

        $disabledDates = array_map(function($b) {
            return $b->getSheduledAt()->format('Y-m-d');
        }, $existingBookings);

        return $this->render('/booking/step2.html.twig', [
            'form' => $form->createView(),
            'service' => $service,
            'disabledDates' => $disabledDates,
        ]);
    }

    #[Route('services/{id}/booking/success', name: 'app_booking_success')]
    public function success(int $id, EntityManagerInterface $entityManager): Response
    {
        $booking = $entityManager->getRepository(Booking::class)->find($id);

        if (!$booking) {
            throw $this->createNotFoundException('Un problème est survenue ! Réservation introuvable.');
        }

        return $this->render('booking/success.html.twig', [
            'booking' => $booking
        ]);
    }
}