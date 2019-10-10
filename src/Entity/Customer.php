<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")


/**
 * @ORM\Entity
 */
class Customer
{
    public $bookingOrderCount = 0;

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
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $email;

     /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookingOrder", mappedBy="customer", orphanRemoval=true, cascade={"persist"})
     */
    private $bookingOrders;

    public function __construct()
    {
        $this->bookingOrders = new ArrayCollection();
    }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|BookingOrder[]
     */
    public function getBookingOrders(): Collection
    {
        return $this->bookingOrders;
    }

    public function addBookingOrder(BookingOrder $bookingOrder): self
    {
        if (!$this->bookingOrders->contains($bookingOrder)) {
            $this->bookingOrders[] = $bookingOrder;
            $bookingOrder->setCustomer($this);
        }

        return $this;
    }

    public function removeBookingOrder(BookingOrder $bookingOrder): self
    {
        if ($this->bookingOrders->contains($bookingOrder)) {
            $this->bookingOrders->removeElement($bookingOrder);
            // set the owning side to null (unless already changed)
            if ($bookingOrder->getCustomer() === $this) {
                $bookingOrder->setCustomer(null);
            }
        }

        return $this;
    }

    public function getBookingOrderCount(): int
    {
        return $this->bookingOrderCount;
    }

    public function setBookingOrderCount(int $bookingOrderCount): self
    {
        $this->bookingOrderCount = $bookingOrderCount;

        return $this;
    }

    public function addBookingOrderCount(): self
    {
        $this->bookingOrderCount ++;

        return $this;
    }
}
