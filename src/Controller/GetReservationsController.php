<?php

namespace App\Controller;

use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Paginator;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator as OrmPaginator;
use App\Entity\Reservations;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Repository\ReservationsRepository;
use Doctrine\DBAL\Types\JsonType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Request;

#[AsController]
class GetReservationsController extends AbstractController{

    // private $habitats;

    public function __construct(ReservationsRepository $reservationsRepository)
    {
        $this->reservationsRepository = $reservationsRepository;
    }
    // ,Habitats $data, Request $request, Integer $id
    public function __invoke(Request $request)
    {

        $data = $this->reservationsRepository->findByExampleField([1,2]);
        // return $data;
        // dd($request->query->get('id'));
        // dd($data);
        // dd($request->query->get('id'));
        // // dd($request->request->all());
        // // dd($this->habitatsRepository->findBy(['id'=> $request->get('array')]));  
        // // dd($request->query->get('id'));
        // return $this->habitatsRepository->findBy(['id'=> $request->query->get('id')]);
        // // return $data;
        // return $request->query->get('id');
        return $data;
    }
};
