<?php

namespace App\DTO;


use App\Domain\DTO\CustomerDTO;
use Doctrine\Common\Collections\Collection;
use App\Validator\Constraints as CustomAssert;
use App\Validator\Constraints\BookingDateIsOpen;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Domain\DTO\Interfaces\DefaultDTOInterface;

/**
 * @CustomAssert\BookingDTODisponibility
 */
class BookingOrderDTO implements DefaultDTOInterface
{
   
    /**
    * @Assert\Positive
    * Column(type="integer")
    */
    public $wishes = 1;

      /**
     * Column(type="date")
     * @Assert\Type(type="Date")
     * @CustomAssert\BookingDateIsOpen
     * @var string A "Y-m-d" formatted value
     */
    public $expectedDate;

    /**
     * Column(type="smallint")
     */
    public $partTimeCode = 0;

    /**
     * ManyToOne(targetEntity="App\Domain\DTO\CustomerDTO", inversedBy="bookingOrderDTOs")
     * JoinColumn(nullable=false)
     * @Assert\Type(type="App\Domain\DTO\CustomerDTO")
     * @Assert\Valid
     */
    public $customerDTO;
   
     /**
     * OneToMany(targetEntity="App\Domain\DTO\VisitorDTO", mappedBy="bookingOrderDTO", orphanRemoval=false)
     * @Assert\Collection(
     *     fields = { 
     *                  "firstName" = @Assert\NotBlank,
     *                  "lastName" = @Assert\NotBlank,
     *                  "birthDate" =  @Assert\Type (type="Date"),
     *                  "country" = {
     *                      @Assert\NotBlank,
     *                      @Assert\Country
     *                      },
     *                  "discounted" = @Assert\NotBlank
     *               },      
     *     allowMissingFields = true
     * )
     */
    public $visitorDTOs;

    /**
     * Column(type="string", length=255)
     */
    public $bookingRef;

     /**
     * Column(type="datetime")
     * @Assert\DateTime()
     */
    public $orderDate;

    public function __construct()
    {
        $this->orderDate = new \Datetime();
        $this->visitorDTOs = new ArrayCollection();     
    }

    public function getCustomerDTO(): ?CustomerDTO
    {
        return $this->customerDTO;
    }

    public function setCustomerDTO(?CustomerDTO $customerDTO): self
    {
        $this->customerDTO = $customerDTO;

        return $this;
    }

    public function getExpectedDate(): \DateTimeInterface
    {
        return $this->expectedDate;
    }

    public function setExpectedDate(\DateTimeInterface $expectedDate): self
    {
        $this->expectedDate = $expectedDate;

        return $this;
    }

    public function getWishes(): int
    {
        return $this->wishes;
    }

    public function setWishes(int $wishes): self
    {
        $this->wishes = $wishes;

        return $this;
    }

    public function getPartTimeCode(): ?int
    {
        return $this->partTimeCode;
    }

    public function setPartTimeCode(int $partTimeCode): self
    {
        $this->partTimeCode = $partTimeCode;

        return $this;
    }

      /**
     * @return Collection|VisitorDTO[]
     */
    public function getVisitorDTOs(): Collection
    {
        return $this->visitorDTOs;
    }

    public function addVisitorDTO(VisitorDTO $visitorDTO): self
    {

        if($visitorDTO !== null)
        {
            if (!$this->visitorDTOs->contains($visitorDTO)) {
                $this->visitorDTOs[] = $visitorDTO;
                $visitorDTO->setBookingOrderDTO($this);
            }
        }
        return $this;
        
    }

    public function removeVisitorDTO(VisitorDTO $visitorDTO): self
    {
        if ($this->visitorDTOs->contains($visitorDTO)) {
            $this->visitorDTOs->removeElement($visitorDTO);
         //   $this->subVisitorDTOCount();
            // set the owning side to null (unless already changed)
            if ($visitorDTO->getBookingOrderDTO() === $this) {
                $visitorDTO->setBookingOrderDTO(null);
            }
        }

        return $this;
    }

    public function getBookingRef(): ?string
    {
        return $this->bookingRef;
    }

    public function setBookingRef(string $bookingRef): self
    {
        $this->bookingRef = $bookingRef;

        return $this;
    }


    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }
}