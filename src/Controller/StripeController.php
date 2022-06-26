<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PaymentFormType;
use Stripe\Charge;
use Stripe\Error\Base;
use Stripe\Stripe;

class StripeController extends AbstractController
{

    #[Route('/payment', name: 'app_payment')]
    public function paymentAction() : Response {
        $form = $this->createForm(PaymentFormType::class, null, array());
        // $request = $this->container->get('request');
        // $message = '';
        // if($request->get('test'))
        // {
        //     Stripe::setApiKey('sk_test_4zvcPWcVyDPt4wZcVwqe95Xc');

        //     $token = $request->get('stripeToken');

        //     $customer = \Stripe_Customer::create(array(
        //           'email' => 'customer@example.com',
        //           'card'  => $token
        //     ));

        //     $charge = Stripe_Charge::create(array(
        //           'customer' => $customer->id,
        //           'amount'   => 5000,
        //           'currency' => 'usd'
        //     ));

        //     $message = '<h1>Successfully charged $50.00!</h1>';
        // }

        return $this->render('payment/index.html.twig', [
        'form' => $form->createView(),
        'stripe_public_key' => $this->getParameter('stripe_public_key'),
        ]);
    }
}
