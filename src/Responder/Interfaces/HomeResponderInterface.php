<?php

namespace App\Responder\Interfaces;

use Symfony\Component\Form\FormInterface;


interface HomeResponderInterface
{
    public function __invoke(FormInterface $formInterface);
}
