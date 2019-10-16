<?php

declare(strict_type=1);

namespace App\Responder;

use Twig\Environment;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Responder\Interfaces\HomeResponderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class HomeResponder
 * 
 */
class HomeResponder implements HomeResponderInterface
{
    /**
     *
     * @var Environment
     */
    private $twig;

    /**
     * Undocumented function
     *
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Undocumented function
     *
     * @param FormInterface $addVisitorType
     * @return void
     */
    public function __invoke($redirect = false, FormInterface $addCustomerType= null)
    {
        $redirect 
        ? $response = new RedirectResponse('/test')
        : $response =  new Response(
            $this->twig->render("home\index.html.twig" , [
                'form' => $addCustomerType->createView()
                ])
        );

        return $response;
    }

    
}