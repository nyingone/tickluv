<?php

namespace App\Domain\DTO;

use App\Validator\Constraints as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints\BookingDateIsOpen;
use Doctrine\ORM\Mapping as ORM;

/**
 * Undocumented class
 */
class NewBookingOrderDTO
{

    /**
    * @Assert\Positive
    * Column(type="integer")
    */
    public $wishes = 1;

    /**
     * Column(type="integer")
     */
    public $orderNumber;

    /**
     * Column(type="datetime")
     * @Assert\DateTime()
     */
    public $orderDate;

    /**
     * Column(type="date")
     * @Assert\Type(type="Date")
     * @var string A "Y-m-d" formatted value
     * @CustomAssert\BookingDateIsOpen
     */
    public $expectedDate;

    /**
     * Column(type="smallint")
     */
    public $partTimeCode;

    /**
     * @ManyToOne(targetEntity="App\Domain\DTO\NewCustomerDTO", inversedBy="bookingOrders")
     * @JoinColumn(nullable=false)
     * @Assert\Type(type="App\Domain\DTO\NewCustomerDTO")
     * @Assert\Valid
     */
    public $customer;

    /**
     * OneToMany(targetEntity="App\Domain\DTO\NewVisitorDTO", mappedBy="bookingOrder", orphanRemoval=false, cascade={"persist"})
      * @Assert\Collection(
     *     fields = { 
     *          "firstName" = @Assert\string,
     *          "lastName" = @Assert\string,
     *          "birthDate" =  @Assert\Type (type="Date")
     *          "country" = {
     *                  @Assert\NotBlank,
     *                  @Assert\Country},
     *          "discounted"
     *                  },      
     *     allowMissingFields = false
     * )
     */
    public $visitors;

}