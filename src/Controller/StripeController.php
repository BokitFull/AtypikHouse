<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\PaymentFormType;

class StripeController extends AbstractController
{

    #[Route('/payment', name: 'app_payment')]
    public function paymentAction(Request $request) : Response {

        \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));
        // $form = $this->createForm(PaymentFormType::class);

        $stripe = new \Stripe\StripeClient($this->getParameter('stripe_secret_key'));

        $amount = 500;
        $name = 'test';

        $product_id = $stripe->products->search(["query" => "name:'" . $name . "'", "limit" => 1])["data"][0]["id"];
        // var_dump($product_id);

        $price_id = $stripe->prices->search(["query" => "product:'" . $product_id . "'", "limit" => 1])["data"][0]["id"];
        // var_dump($price_id);

        if($price_id != null && $price_id != []) {
            $stripe->prices->update(
                $price_id,
                ['metadata' => ['unit_amount' => $amount]]
            );
        }
        else {
            $product_id = $stripe->products->create([
                'name' => $name,
            ]);

            $price_id = $stripe->prices->create(
                [
                'product' => $product_id,
                'unit_amount' => $amount,
                'currency' => 'eur',
                ]
            );
        }

        $result = \Stripe\Checkout\Session::create([
            'line_items' => [['price' => $price_id,'quantity' => 1]],
            'mode' => 'payment',
            'success_url' => $this->getParameter('domain') . '/payment',
            'cancel_url' => $this->getParameter('domain') . '/payment',
        ]);



        // $form = $this->get('form.factory')
        //     ->createNamedBuilder('payment_form')
        //     ->add('token', HiddenType::class, [
        //         'constraints' => [new NotBlank()],
        //     ])
        //     ->add('submit', SubmitType::class)
        //     ->getForm();

        // if ($request->isMethod('POST')) {
        //     $form->handleRequest($request);

        //     if ($form->isValid()) {
        //     // TODO: charge the card
        //     }
        // }
            // $paymethod =  \Stripe\PaymentMethod::create([
            //     'type' => 'card',
            //     'card' => [
            //         'number' => $form->get('number_card'),
            //         'exp_month' => $form->get('validity_month'),
            //         'exp_year' => $form->get('validity_year'),
            //         'cvc' => $form->get('code'),
            //     ],
            // ]);

            // $intent =  \Stripe\PaymentIntent::create([
            //     'amount' => $request->get('amt'),
            //     'currency' => 'eur',
            //     "payment_method_types" => ['card'],
            //     'metadata' => ['integration_check' => 'accept_a_payment']
            // ]);


        // }
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
            // 'form' => $form->createView(),
            'payout' => $result,
        ]);
    }
}
