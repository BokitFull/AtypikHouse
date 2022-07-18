<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Repository\ReservationsRepository;
use Symfony\Component\HttpFoundation\Request;

#[AsController]
class GetReservationsController extends AbstractController{

    public function __construct(ReservationsRepository $reservationsRepository)
    {
        $this->reservationsRepository = $reservationsRepository;
    }

    public function __invoke(Request $request)
    {
        $data = $this->reservationsRepository->getReservationsByDate($request->query->all());
        return $data;
    }
};
