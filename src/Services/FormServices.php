<?php

namespace App\Services;

use App\Form\LoginFormType;
use App\Form\RegistrationFormType;
use Symfony\Component\Form\FormFactory;

class FormServices
{
    // private $formFactory;

    // public function __construct(FormFactory $formFactory)
    // {
    //     $this->formFactory = $formFactory;
    // }

    // public function createLoginForm($entity, $route)
    // {
    //     $login_form = $this->createForm(LoginFormType::class, $utilisateur);

    //     return $login_form;
    // }

    // public function createRegisterForm($entity, $route)
    // {
    //     $register_form = $this->formFactory->createForm(RegistrationFormType::class, $utilisateur)->createView();

    //     return $register_form;
    // }
}