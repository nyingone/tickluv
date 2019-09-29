<?php

namespace App\Services;

class ReviewMessage
{

    public function ConfirmationMessage($confirmation, $destination)
    {
       $messages =  "it's time to sens your first message" . $confirmation;

       return $messages;

    }
}