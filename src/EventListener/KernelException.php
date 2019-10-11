<?php

namespace App\EventListener;


    class KernelException
    {
            public function onKernelException ()
            {
                var_dump("I'm a listener");
            }
    }
