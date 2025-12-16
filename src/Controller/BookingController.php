<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Customer;
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
    #[Route('/booking/step-1', name: 'app_booking_step1')]
    public function step1(Request $request): Response
    {

        $session = $request->getSession();
        $session->start();
        $booking = $session->get('booking', new Booking());

        $form = $this->createForm(BookingStep1Type::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $request->getSession()->set('booking', $booking);
            return $this->redirectToRoute('app_booking_step2');
        }

        return $this->render('booking/step1.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/booking/step-2', name: 'app_booking_step2')]
    public function step2(Request $request, EntityManagerInterface $entityManager): Response
    {
        $booking = $request->getSession()->get('booking');

        if (!$booking) {
            return $this->redirectToRoute('app_booking_step1');
        }

        $form = $this->createForm(BookingStep2Type::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $booking->getCustomer();
            $existingCustomer = $entityManager->getRepository(Customer::class)->findOneBy(['email' => $customer->getEmail()]);

            if ($existingCustomer) {
                $booking->setCustomer($existingCustomer);
            } else {
                $entityManager->persist($customer);
            }

            $entityManager->persist($booking);
            $entityManager->flush();
            
            $request->getSession()->remove('booking');

            return $this->redirectToRoute('app_booking_success');
        }

        return $this->render('booking/step2.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
