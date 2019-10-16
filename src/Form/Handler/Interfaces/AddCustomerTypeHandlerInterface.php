<?php

declare(strict_type=1);

namespace App\Form\Handler\Interfaces;

use Symfony\Component\Form\FormInterface;

interface AddCustomerTypeHandlerInterface
{
    public function handle(FormInterface $form): bool;
}