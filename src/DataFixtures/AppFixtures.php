<?php

namespace App\DataFixtures;

use App\Entity\Commentaires;
use App\Entity\Habitats;
use App\Entity\Notes;
use App\Entity\Reservations;
use App\Entity\Utilisateurs;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{   
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
       $this->passwordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $utilisateurs = array();

        // create 20 products! Bam!
        for ($i = 0; $i < 10; $i++) {
            $utilisateur = new Utilisateurs();
            $utilisateur->setNom($faker->firstName);
            $utilisateur->setprenom($faker->lastName);
            $utilisateur->setEmail($faker->email);
            $utilisateur->setPassword($this->passwordHasher->hashPassword($utilisateur, 'Fake'));
            $utilisateur->setCivilite($faker->randomElement(['M', 'F']));
            $utilisateur->setRoles($i < 7 ? ['ROLE_USER'] : ['ROLE_HOTE']);
            $utilisateur->setTelephone($faker->serviceNumber);
            $utilisateur->setAdresse(rand(1, 80) ." ". $faker->streetPrefix . $faker->asciify(str_repeat('*', rand(6, 10))));
            $utilisateur->setCodePostal($faker->postcode);
            $utilisateur->setVille($faker->departmentName);
            $utilisateur->setPays('France');
            $utilisateur->setCreatedAt(new DateTimeImmutable('now'));

            array_push($utilisateurs, $utilisateur);
            $manager->persist($utilisateur);
        
        }

        $habitats = array();
        for ($i = 0; $i < 10; $i++) {
            $habitat = new Habitats();
            $habitat->setLibelle($faker->company);
            $habitat->setAdresse($faker->streetAddress);
            $habitat->setCodePostal($faker->postcode);
            $habitat->setVille($faker->city);
            $habitat->setPays($faker->country);
            $habitat->setEstDisponible(1);
            $habitat->setCreatedAt(new DateTimeImmutable('now'));
            $habitat->setProprietaire($utilisateurs[rand(7,9)]);

            array_push($habitats, $habitat);
            $manager->persist($habitat);
        }

        $commentaires = array();
        for ($i = 0; $i < 10; $i++) {
            $commentaire = new Commentaires();
            $commentaire->setCommentaire($faker->sentence(40));
            $commentaire->setUtilisateur($utilisateurs[$i]);
            
            array_push($commentaires, $commentaire);
            $manager->persist($commentaire);
        }



        $reservations = array();
        for ($i = 0; $i < 10; $i++) {
            $reservation = new Reservations();
            $reservation->setMontant(rand(60, 200));
            $reservation->setCreatedAt(new DateTimeImmutable('now'));
            $reservation->setUtilisateur($utilisateurs[rand(0, count($utilisateurs)-1)]);

            $valid_reservation = false;
            while ($valid_reservation === false){
                $reservation->setHabitat($habitats[rand(0, count($habitats)-1)]);
                $reservation->setDateDebut($faker->dateTimeBetween('-3 week', '+3 week'));
                $date_fin = $reservation->getDateDebut();

                $habitat = $reservation->getHabitat();
                $habitat_reservations = [];
                foreach ($reservations as $res) {
                    if ($res->getHabitat() == $habitat){
                        array_push($habitat_reservations, $res);
                    }
                }
                if (count($habitat_reservations) != 0){
                    foreach($habitat_reservations as $hab_res){
                        if ($reservation->getDateDebut() > $hab_res->getDateDebut() && $reservation->getDateFin() > $hab_res->getDateDebut()){
                            $valid_reservation = true;
                            break;
                        } else {
                            $valid_reservation = false;
                        }
                    }
                } else {
                    $valid_reservation = true;
                }

                $date_fin = $date_fin->format('Y-m-d h:i:s');
                $date_fin = strtotime($date_fin);
                $added_period = "+" . rand(1,3) . " " . array('day', 'week')[array_rand(array('day', 'week'))];
                $reservation->setDateFin(new DateTime(date('Y-m-d h:i:s', strtotime($added_period, $date_fin))));
                
            }
            array_push($reservations, $reservation);
            $manager->persist($reservation);
        }

        $notes = array();
        for ($i = 0; $i < 10; $i++) {
            $note = new Notes();
            $note->setNote(rand(0, 5));
            $note->setUtilisateur($utilisateurs[$i]);
            $note->setReservation($reservations[$i]);
            array_push($notes, $note);

            $manager->persist($note);
        }

        $manager->flush();
    }
}
