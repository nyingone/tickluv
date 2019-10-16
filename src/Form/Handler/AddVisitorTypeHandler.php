<?php

declare(strict_types=1);

namespace App\Form\Handler;

use App\Form\Handler\Interfaces\AddFormTypeHandlerInterface;
use Symfony\Component\Form\FormInterface;

class AddVisitorTypeHandler implements AddFormTypeHandlerInterface
{
    public function handle(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isvalid()) {
           // dd($form->getData());
        //    $data = new $form->getData(); // instance de NewVisitorDTO hydratée
             $data = $form->getData();
            // DOCTRINE
            // VALIDATOR
            return true;
        } 

        return false;
    }
}