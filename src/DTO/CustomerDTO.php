<?php

namespace App\DTO;


use App\DTO\Interfaces\DefaultDTOInterface;
use Doctrine\Common\Collections\Collection;
use App\Validator\Constraints as CustomAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 
 */
class CustomerDTO implements DefaultDTOInterface
{
    public $bookingOrderCount = 0;
  
    /**
     * Column(type="string", length=255)
     */
    public $firstName;

    /**
     * Column(type="string", length=255)
     */
    public $lastName;

    /**
     * Column(type="string", length=255)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    public $email;

    /**
     * @Assert\Collection(
     *     fields = { 
     *         "expectedDate" = {
     *             @Assert\Date,
     *             @CustomAssert\BookingDateIsOpen
     *                  },
     *         "partTimeCode" = @Assert\NotBlank,
     *         "wishes" =  @Assert\Positive,
     *         "visitors" = @Assert\NotNull
     *     },
     *     allowMissingFields = false
     * )
     */
    public $bookingOrderDTOs;

    public function __construct()
    {
        
    }
}