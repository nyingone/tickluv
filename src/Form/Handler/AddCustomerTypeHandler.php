<?php

declare(strict_types=1);

namespace App\Form\Handler;

use App\Form\Handler\Interfaces\AddCustomerTypeHandlerInterface;
use Symfony\Component\Form\FormInterface;

class AddCustomerTypeHandler implements AddCustomerTypeHandlerInterface
{
    public function handle(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isvalid()) {
            // dd($form->getData());
            //    $data = new $form->getData(); // instance de NewCustomerDTO hydratée
             $data = $form->getData();
             dd($form->getData());
            // DOCTRINE
            // VALIDATOR
            return true;
        } 

        return false;
    }
}