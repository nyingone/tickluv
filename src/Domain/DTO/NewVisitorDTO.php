<?php

declare(strict_types=1);

/**
 * 
 */

namespace App\Domain\DTO;

class NewVisitorDTO
{
    
    /**
     * Undocumented variable
     *
     * @var string $firtName
     */
    public $firstName;

    /**
     * @var string $lasttName
     */
    public $lastName;

    /**
     * @var string $birthDate
     */    
    public $birthDate;

    /**
     * @var string $country
     */
    public $country;

    /**
     * @var bool $discounted
     */
    public $discounted;


     /**
     * @ManyToOne(targetEntity="App\Domain\DTO\NewBookingOrderDTO", inversedBy="visitors")
     * @JoinColumn(nullable=false)
     * @Assert\Type(type="App\Domain\DTO\NewBookingOrderDTO")
     * @Assert\Valid
     */
    public $bookingOrder;

    public function __construct()
    {

    }
}