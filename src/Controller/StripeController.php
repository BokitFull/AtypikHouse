<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservations;
use App\Entity\Habitats;
use App\Repository\ReservationsRepository;
use Symfony\Component\Security\Core\Security;

class StripeController extends AbstractController
{
    public function __construct(ReservationsRepository $repository, Security $security) {
        $this->repository = $repository;
        $this->security = $security;
    }

    #[Route('/payment/{id}', name: 'payment', methods: ['GET'])]
    public function paymentAction(Habitats $habitat, Request $request) : Response {

        $dates = $request->get("form-date");
        $dateDebut = new \DateTime(trim(explode('au', $dates)[0]));
        $dateFin = new \DateTime(trim(explode('au', $dates)[1]));
        $duree = $dateDebut->diff($dateFin);

        if($request->get('reservation') == null) {

            $reservation = new Reservations();

            $reservation->setNbPersonnes($request->get('nb_personnes'));

            $reservation->setDateDebut(new \DateTimeImmutable($dateDebut->format('Y-m-d')));
            $reservation->setDateFin(new \DateTimeImmutable($dateFin->format('Y-m-d')));

            $reservation->setMontant(round($habitat->getPrix() * ($duree->format('%a')), 2));
            $reservation->setStatut("1");
            $reservation->setUtilisateur($this->security->getUser());
            $reservation->setHabitat($habitat);
            $reservation->setCreatedAt(new \DateTimeImmutable("now"));
            
            $this->repository->add($reservation, true); 
            
            \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));
            $apiKey = $this->getParameter('stripe_public_key');
            
            $payment = $this->getParameter('payment');
            
            $amount = $reservation->getMontant() * 100;
            $currency = $payment['currency'];
            
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);
        }
            
        return $this->render('payment/index.html.twig', [
            'clientKey' => $apiKey,
            'clientSecret' => $paymentIntent->client_secret,
            'habitat' => $habitat,
            'reservation' => $reservation,
            'duree' => $duree->format('%a'),
            'url' => $this->getParameter('domain') . "/confirmPayment/" . $reservation->getId()
        ]);
            
    }

    #[Route('/confirmPayment/{id}', name: 'confirm_payment', methods: ['GET'])]
    public function paymentConfirm($id, Request $request) : Response {

        //Enregistrement du statut de la réservation en base
        $reservation = $this->repository->find($id);

        $reservation->setStatut("2");

        $this->repository->add($reservation, true);

        return $this->render('payment/confirm.html.twig', [
        ]);
    }
}
