<?php

declare(strict_types=1);

namespace App\DTO;


use App\DTO\Interfaces\DefaultDTOInterface;
use App\Validator\Constraints as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 */
class VisitorDTO implements DefaultDTOInterface
{ 
    /**
     *
     * @var string $firtName
     * @Assert\NotBlank(message="Enter first Name please.")
    * @Assert\Length(
    *      min = 2,
    *      max = 50,
    *      minMessage = "Your firstname must be at least {{ limit }} characters long",
    *      maxMessage = "Your firstname cannot be longer than {{ limit }} characters"
    * )
     */
    public $firstName;

    /**
     * @var string $lastName
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your lastname must be at least {{ limit }} characters long",
     *      maxMessage = "Your lastname cannot be longer than {{ limit }} characters"
     * )
     */
    public $lastName;

    /**
     * Column(type="datetime" , type="datetime", nullable=true)
     * @Assert\Date
     * @Assert\NotBlank()
     * @var string A "Y-m-d" formatted value
     */    
    public $birthDate;

    /**
     * @var string $country
     * @Assert\NotBlank
     * @Assert\Country
     */
    public $country;

    /**
     * @var bool $discounted
     */
    public $discounted;

    private $ageYearsOld;

    /**
    * @Assert\NotBlank(message="Booking is impossible, no tarif found.")
    * Column(type="string", length=2)
    */
    public $tarifCode = 1;

    /**
     * Column(type="integer", nullable=true)
     */
    private $cost;

      /**
     * Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\NotBlank
     */
    public $bookingOrderDTO;


    public function __construct() 
    {
        
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setBirthDate(\DateTime $birthDate): self
    {
        $this->birthDate = $birthDate;
        
        $this->setAgeYearsOld();      

        return $this;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function setDiscounted(bool $discounted): self
    {
        $this->discounted = $discounted;

        return $this;
    }

   

    /**
     * @param date $birthdate
     * @return integer $ageYearsOld
     */
    public function setAgeYearsOld()
    {
        $this->ageYearsOld = $this->birthDate->diff(new \DateTime('today'));
        
        // return $yearsOld->format('%Y');
    }

 
    public function setTarifCode(?int $tarifCode): self
    {
        $this->tarifCode = $tarifCode;

        return $this;
    }

    public function setCost(?float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getBirthDate(): ? \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getDiscounted(): ?bool
    {
        return $this->discounted;
    }

    public function getAgeYearsOld()
    {
     return $this->ageYearsOld->format('%Y');
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function getTarifCode(): ?int
    {
        return $this->tarifCode;
    }

    public function getBookingOrderDTO(): ?BookingOrderDTO
    {
        return $this->bookingOrderDTO;
    }

    public function setBookingOrderDTO(?BookingOrderDTO $bookingOrderDTO): self
    {
        $this->bookingOrderDTO = $bookingOrderDTO;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}

