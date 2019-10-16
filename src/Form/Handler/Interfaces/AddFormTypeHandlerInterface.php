<?php

declare(strict_type=1);

namespace App\Form\Handler\Interfaces;

use Symfony\Component\Form\FormInterface;

interface AddFormTypeHandlerInterface
{
    public function handle(FormInterface $form): bool;
}