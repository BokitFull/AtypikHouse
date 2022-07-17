<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\PaymentFormType;
use App\Repository\ReservationsRepository;

class StripeController extends AbstractController
{
    public function __construct(ReservationsRepository $repository) {
        $this->repository = $repository;
    }

    #[Route('/payment', name: 'payment_action', methods: ['GET', 'POST'])]
    public function paymentAction(Request $request) : Response {
        
        function getReservationAmount(?array $items): int {
            // Replace this constant with a calculation of the order's amount
            // Calculate the order total on the server to prevent
            // people from directly manipulating the amount on the client
            return 2000;
        }

        \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));
        $apiKey = $this->getParameter('stripe_public_key');

        $jsonStr = $request->get('args');
        $jsonObj = json_decode($jsonStr);

        $payment = $this->getParameter('payment');

        $amount = getReservationAmount($jsonObj);
        $currency = $payment['currency'];

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => $currency,
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        return $this->render('payment/index.html.twig', [
            'clientSecret' => $this->getParameter('stripe_secret_key'),
            'clientKey' => $apiKey
        ]);

    }

    #[Route('/confirmPayment', name: 'confirm_payment', methods: ['GET'])]
    public function paymentConfirm(Request $request) : Response {

    }
    // #[Route('/payment/OK', name: 'success_payment', methods: ['GET'])]
    // public function checkoutSuccess(Request $request) : Response {

    //     return $this->render('payment/success.html.twig', [
    //         'result' => $request,
    //     ]);
    // }

    // #[Route('/payment/CANCEL', name: 'cancel_payment', methods: ['GET'])]
    // public function checkoutCancel(Request $request) : Response {

    //     return $this->render('payment/cancel.html.twig', [
    //         'result' => $request,
    //     ]);
    // }
}
