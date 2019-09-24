<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitorRepository")
 */
class Visitor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $country;

    /**
     * @ORM\Column(type="boolean")
     */
    private $discounted;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $confirmedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ticketRef;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cancelled;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BookingOrder", inversedBy="visitors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bookingOrder;

    public function getId(): ?int
    {




        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getDiscounted(): ?bool
    {
        return $this->discounted;
    }

    public function setDiscounted(bool $discounted): self
    {
        $this->discounted = $discounted;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(?float $cost): self
    {
        $this->cost = $cost;

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

    public function getConfirmedAt(): ?\DateTimeInterface
    {
        return $this->confirmedAt;
    }

    public function setConfirmedAt(?\DateTimeInterface $confirmedAt): self
    {
        $this->confirmedAt = $confirmedAt;

        return $this;
    }

    public function getTicketRef(): ?string
    {
        return $this->ticketRef;
    }

    public function setTicketRef(?string $ticketRef): self
    {
        $this->ticketRef = $ticketRef;

        return $this;
    }

    public function getCancelled(): ?bool
    {
        return $this->cancelled;
    }

    public function setCancelled(bool $cancelled): self
    {
        $this->cancelled = $cancelled;

        return $this;
    }

    public function getBookingOrder(): ?BookingOrder
    {
        return $this->bookingOrder;
    }

    public function setBookingOrder(?BookingOrder $bookingOrder): self
    {
        $this->bookingOrder = $bookingOrder;

        return $this;
    }


    /**
     * @param datetime $birthdate
     * @return integer $age
     */
    public function findAgeYearsOld(datetime $birthDate)
    
    {
        $yearsOld = $birthDate->diff(new DateTime('today'));
        
        return $yearsOld->format('%Y');
    }
}
