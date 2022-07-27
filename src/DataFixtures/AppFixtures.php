<?php

namespace App\DataFixtures;

use App\Entity\CaracteristiquesHabitat;
use App\Entity\CaracteristiquesTypeHabitat;
use App\Entity\Commentaires;
use App\Entity\Ville;
use App\Entity\Departements;
use App\Entity\Habitats;
use App\Entity\Pays;
use App\Entity\Prestations;
use App\Entity\Region;
use App\Entity\Reservations;
use App\Entity\TypesHabitat;
use App\Entity\TypesPrestation;
use App\Entity\Utilisateurs;
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

        // create 10 products! Bam!
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
            $utilisateur->setCodePostal(strval(rand(1, 97)));
            $utilisateur->setVille($faker->departmentName);
            $utilisateur->setPays('France');
            $utilisateur->setImage('');
            // $utilisateur->setDeletedAt(new DateTimeImmutable('now'));

            array_push($utilisateurs, $utilisateur);
            $manager->persist($utilisateur);          
        }

        $typePrestations = array();
        for ($i = 0; $i < 10; $i++) {
            $typePrestation = new TypesPrestation();
            $typePrestation->setNom($faker->name);
            $typePrestation->setDescription($faker->sentence(20));
            $typePrestation->setDeletedAt(new DateTimeImmutable('now'));
            array_push($typePrestations, $typePrestation);
            $manager->persist($typePrestation);
        }

        $prestations = array();
        $prestationsName = ['Télévision', 'Vue sur la mer', 'Balcon', 'Accès à la plage', 'Eau chaude', 'Salle de bain', 'Cintres', 'Draps', 'Kit de premier secours', 'Cuisine'];
        for ($i = 0; $i < 10; $i++) {
            $prestation = new Prestations();
            $prestation->setNom($prestationsName[$i]);
            $prestation->setIcone($faker->name);
            $prestation->setType($faker->randomElement($typePrestations));
            $prestation->setDescription($faker->sentence(20));
            $prestation->setDeletedAt(new DateTimeImmutable('now'));
            array_push($prestations, $prestation);
            $manager->persist($prestation);
        }

        $pays_list = [ 
            'france' => [
                'alsace' => [
                    'bas-rhin' => [
                        'strasbourg' => []
                        ],
                    ],
                    'picardie' => [
                        'aisne' => [
                                'laon' => []
                            ]
                    ],
                    'bourgogne' => [
                        'yonne' => [
                                'auxerre' => []
                        ],
                    ],
                    'guadeloupe' => [
                        'guadeloupe' => [
                                'basse-terre' => []
                            ]
                    ]
                ]
            ];

        // $pays_list = [ 
        //     'pays' => [
        //         'france' => [
        //             'regions' => [
        //                 'alsace' => [
        //                     'departements' => [
        //                         'bas-rhin' => [
        //                             'communes' => [
        //                                 'strasbourg'
        //                             ],
        //                         ]
        //                     ]
        //                 ],
        //                 'picardie' => [
        //                     'departements' => [
        //                         'aisne' => [
        //                             'communes' => [
        //                                 'laon'
        //                             ]
        //                         ]
        //                     ],
        //                 ],
        //                 'bourgogne' => [
        //                     'departements' => [
        //                         'yonne' => [
        //                             'communes' => [
        //                                 'auxerre'
        //                             ]
        //                         ]
        //                     ],
        //                 ],
        //                 'guadeloupe' => [
        //                     'departements' => [
        //                         'guadeloupe' => [
        //                             'communes' => [
        //                                 'basse-terre'
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ]
        //         ]
        //     ]
        // ];

        $pays_s = array();
        $regions = array();
        $departements = array();
        $villes = array();
        foreach($pays_list as $pays_nom => $pays_value) {
            $pays = new Pays();
            $pays->setNom($pays_nom);

            array_push($pays_s, $pays);
            $manager->persist($pays);

            foreach($pays_value as $regions_nom => $region_value) {
                $region = new Region();
                $region->setNom($regions_nom);
                $region->setPays($pays);
    
                array_push($regions, $region);
                $manager->persist($region);
                
                foreach($region_value as $departement_nom => $departement_value) {
                    $departement = new Departements();
                    $departement->setNom($departement_nom);
                    $departement->setRegion($region);
        
                    array_push($departements, $departement);
                    $manager->persist($departement);

                    foreach($departement_value as $ville_nom => $ville_value) {
                        $ville = new Ville();
                        $ville->setNom($ville_nom);
                        $ville->setDepartements($departement);
            
                        array_push($villes, $ville);
                        $manager->persist($ville);
                    }
                }
            }
        }

        

        $type_habitats = array();
        $habitat_name = ['Cabane', 'Tipi', 'Bulle', 'Tente', 'Roulotte', 'Yourte', 'Dôme', 'Tiny House', 'Chalet', 'Chalet'];
        for ($i = 0; $i < 10; $i++) {
            $type_habitat = new TypesHabitat();
            $type_habitat->setNom($habitat_name[$i]);
            $type_habitat->setDescription($faker->sentence(20));
            $type_habitat->setDeletedAt(new DateTimeImmutable('now'));

            array_push($type_habitats, $type_habitat);
            $manager->persist($type_habitat);
        }

        $habitats = array();
        for ($i = 0; $i < 10; $i++) {
            $habitat = new Habitats();
            $habitat->setTitre($faker->company);
            $habitat->setAdresse($faker->streetAddress);
            $habitat->setCodePostal(rand(01, 10));
            $habitat->setVille($villes[rand(0, count($villes)-1)]);
            $habitat->setDescription($faker->sentence(20));
            $habitat->setPays('France');
            $habitat->setEstValide(rand(0, 1));
            $habitat->setEstActif(rand(0, 1));
            $habitat->setPrix(rand(10,300));
            $habitat->setNbPersonnes(1);
            $habitat->setDebutDisponibilite(new DateTimeImmutable('now'));
            $habitat->setFinDisponibilite(new DateTimeImmutable('now'));
            $habitat->addPrestation($prestations[rand(0, count($prestations)-1)]);
            $habitat->setType($type_habitats[rand(0, count($type_habitats)-1)]);
            $habitat->setUtilisateur($utilisateurs[rand(7, 9)]);
            $habitat->setDeletedAt(new DateTimeImmutable('now'));
            array_push($habitats, $habitat);
            $manager->persist($habitat);
        }

        $caracteristiquesTypeHabitat = array();
        $caracteristiques_name = ['Altitude', 'Emplacement', 'Véranda', 'Balcon', 'Baie Vitré', 'Garage', 'Escalier', 'Toit', 'Jardin'];
        for ($i = 0; $i < 10; $i++) {
            $caracteristiques = new CaracteristiquesTypeHabitat();
            $caracteristiques->setNom($faker->randomElement($caracteristiques_name));
            $caracteristiques->setDescription($faker->sentence(20));
            $caracteristiques->setType($faker->randomElement($type_habitats));
            $caracteristiques->setDeletedAt(new DateTimeImmutable('now'));

            array_push($caracteristiquesTypeHabitat, $caracteristiques);
            $manager->persist($caracteristiques);
        }

        $caracteristiquesHabitat = array();
        for ($i = 0; $i < 10; $i++) {
            $caracteristiques = new CaracteristiquesHabitat();
            $caracteristiques->setHabitat($faker->randomElement($habitats));
            $caracteristiques->setCaracteritiqueType($faker->randomElement($caracteristiquesTypeHabitat));
            $caracteristiques->setValeur($faker->sentence(1));
            $caracteristiques->setDeletedAt(new DateTimeImmutable('now'));

            array_push($caracteristiquesHabitat, $caracteristiques);
            $manager->persist($caracteristiques);
        }

        $reservations = array();
        for ($i = 0; $i < 10; $i++) {
            $reservation = new Reservations();
            $reservation->setStatut(1);
            $reservation->setMontant(rand(60, 200));
            $reservation->setNbPersonnes(rand(1, 3));
            $reservation->setDeletedAt(new DateTimeImmutable('now'));
            $reservation->setUtilisateur($utilisateurs[rand(0, count($utilisateurs)-1)]);
            $reservation->setHabitat($habitats[rand(0, count($habitats)-1)]);
            $valid_reservation = false;
            while ($valid_reservation === false){
                $reservation->setDateDebut(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-3 week', '+3 week')));
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
                $reservation->setDateFin(new DateTimeImmutable(date('Y-m-d h:i:s', strtotime($added_period, $date_fin))));
                
            }
            array_push($reservations, $reservation);
            $manager->persist($reservation);
        }

        $commentaires = array();
        for ($i = 0; $i < 10; $i++) {
            $commentaire = new Commentaires();
            $commentaire->setContenu($faker->sentence(40));
            $commentaire->setReponse($i%3==0 ? $faker->sentence(40) : '');
            $commentaire->setNoteProprete(rand(0,5));
            $commentaire->setNoteAccueil(rand(0,5));
            $commentaire->setNoteEmplacement(rand(0,5));
            $commentaire->setNoteQualitePrix(rand(0,5));
            $commentaire->setNoteEquipements(rand(0,5));
            $commentaire->setUtilisateur($utilisateurs[$i]);
            $commentaire->setReservation($reservations[$i]);
            $commentaire->setDeletedAt(new DateTimeImmutable('now'));
            
            array_push($commentaires, $commentaire);
            $manager->persist($commentaire);
        }

        $manager->flush();
    }
}