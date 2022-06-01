<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PaymentFormType;

class StripeController extends AbstractController
{
    // #[Route('/payment', name: 'app_payment')]
    // public function index(): Response
    // {
    //     return $this->render('payment/index.html.twig', [
    //         'controller_name' => 'StripeController',
    //     ]);
    // }

    #[Route('/payment', name: 'app_payment')]
    public function paymentAction() : Response {
        $form = $this->createForm(PaymentFormType::class, null, array());
        // $form = $this->get('form.factory')
        // ->createNamedBuilder('payment-form')
        // ->add('token', HiddenType::class, [
        //     'constraints' => [new NotBlank()],
        // ])
        // ->add('submit', SubmitType::class)
        // ->getForm();

        // if ($request->isMethod('POST')) {
        //     $form->handleRequest($request);

        //     if ($form->isValid()) {
        //     // TODO: charge the card
        //     }
        // }

        return $this->render('payment/index.html.twig', [
        'form' => $form->createView(),
        'stripe_public_key' => $this->getParameter('stripe_public_key'),
        ]);
    }
}
