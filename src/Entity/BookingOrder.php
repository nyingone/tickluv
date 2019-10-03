<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingOrderRepository")
 */
class BookingOrder
{
    public $visitorCount = 0;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderNumber;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $orderDate;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date
     * @var string A "Y-m-d" formatted value
     */
    private $expectedDate;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     */
    private $partTimeCode;

    /**
     * @ORM\Column(type="float")
     */
    private $totalAmount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bookingRef;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validatedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $invoiceNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paymentMethod;

    /**
     * @ORM\Column(type="integer")
     */
    private $paymentNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $paymentExtRef;

    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $cancelledAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="bookingOrders")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Type(type="App\Entity\Customer")
     * @Assert\Valid
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visitor", mappedBy="bookingOrder", orphanRemoval=true, cascade={"persist"})
     */
    private $visitors;


    public function __construct()
    {
        $this->orderDate         = new \Datetime();
        $this->visitors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(int $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

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

    public function getExpectedDate(): ?\DateTimeInterface
    {
        return $this->expectedDate;
    }

    public function setExpectedDate(\DateTimeInterface $expectedDate): self
    {
        $this->expectedDate = $expectedDate;

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

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

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

    public function getValidatedAt(): ?\DateTimeInterface
    {
        return $this->validatedAt;
    }

    public function setValidatedAt(?\DateTimeInterface $validatedAt): self
    {
        $this->validatedAt = $validatedAt;

        return $this;
    }

    public function getInvoiceNumber(): ?int
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(?int $invoiceNumber): self
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getPaymentNumber(): ?int
    {
        return $this->paymentNumber;
    }

    public function setPaymentNumber(int $paymentNumber): self
    {
        $this->paymentNumber = $paymentNumber;

        return $this;
    }

    public function getPaymentExtRef(): ?string
    {
        return $this->paymentExtRef;
    }

    public function setPaymentExtRef(string $paymentExtRef): self
    {
        $this->paymentExtRef = $paymentExtRef;

        return $this;
    }

    
    public function getCancelledAt(): ?\DateTimeInterface
    {
        return $this->cancelledAt;
    }

    public function setCancelledAt(?\DateTimeInterface $cancelledAt): self
    {
        $this->cancelledAt = $cancelledAt;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection|Visitor[]
     */
    public function getVisitors(): Collection
    {
        return $this->visitors;
    }

    public function addVisitor(Visitor $visitor): self
    {
        if (!$this->visitors->contains($visitor)) {
            $this->visitors[] = $visitor;
            $visitor->setBookingOrder($this);
        }

        return $this;
    }

    public function removeVisitor(Visitor $visitor): self
    {
        if ($this->visitors->contains($visitor)) {
            $this->visitors->removeElement($visitor);
            // set the owning side to null (unless already changed)
            if ($visitor->getBookingOrder() === $this) {
                $visitor->setBookingOrder(null);
            }
        }

        return $this;
    }

    public function getVisitorCount(): int
    {
        return $this->visitorCount;
    }

    public function setVisitorCount(int $visitorCount): self
    {
        $this->visitorCount = $visitorCount;

        return $this;
    }
}
