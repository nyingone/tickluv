<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use App\Responder\Interfaces\HomeResponderInterface;
use App\Form\Handler\Interfaces\AddCustomerTypeHandlerInterface;
use App\Form\Type\AddCustomerType;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class TestController
 * 
 */
class TestController
{
    /**
     *
     * @var FormFactoryInterface
     */
    private $formfactory;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Undocumented variable
     *
     * @var AddCustomerTypeHandlerInterface
     */
    private $addCustomerTypeHandler;

    /**
     * Undocumented function
     *
     * @param FormFactoryInterface $formFactory
     * @param EventDispatcherInterface $eventDispatcher
     * @param AddCustomerTypeHandlerInterface $addCustomerTypeHandler
     */
    public function __construct(
        FormFactoryInterface $formFactory, 
        EventDispatcherInterface $eventDispatcher, 
        AddCustomerTypeHandlerInterface $addCustomerTypeHandler) 
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->addCustomerTypeHandler = $addCustomerTypeHandler;
    }

    /**
    * @Route(path ="/test", name="test")
    * @param Request $request
    * @param HomeResponderInterface $responder
    * @return Response
    */
    public function invoke(Request $request, HomeResponderInterface $responder)
    {
        $addCustomerType = $this->formFactory->create(AddCustomerType::class)
                                            ->handleRequest($request);
       // dd($addVisitorType);
       if ($this->addCustomerTypeHandler->handle($addCustomerType)) {
           // ...
           return $responder(true);
       }
        return $responder(false, $addCustomerType);
    }
}