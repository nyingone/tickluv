<?php

namespace App\Domain\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * 
 */
class NewCustomerDTO
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
     * OneToMany(targetEntity="App\Domain\DTO\NewBookingOrderDTO", mappedBy="customer", orphanRemoval=true, cascade={"persist"})
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
    public $bookingOrders;

    
}