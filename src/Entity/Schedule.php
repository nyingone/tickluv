<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScheduleRepository")
 */
class Schedule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $startingDate;

    /**
     * @ORM\Column(type="smallint")
     */
    private $dayOfWeek;

    /**
     * @ORM\Column(type="smallint")
     */
    private $partTimeCode;

    /**
     * @ORM\Column(type="time")
     */
    private $openingTime;

    /**
     * @ORM\Column(type="time")
     */
    private $lastEntryTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingDate(): ?\DateTimeInterface
    {
        return $this->startingDate;
    }

    public function setStartingDate(\DateTimeInterface $startingDate): self
    {
        $this->startingDate = $startingDate;

        return $this;
    }

    public function getDayOfWeek(): ?int
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(int $dayOfWeek): self
    {
        $this->dayOfWeek = $dayOfWeek;

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

    public function getOpeningTime(): ?\DateTimeInterface
    {
        return $this->openingTime;
    }

    public function setOpeningTime(\DateTimeInterface $openingTime): self
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    public function getLastEntryTime(): ?\DateTimeInterface
    {
        return $this->lastEntryTime;
    }

    public function setLastEntryTime(\DateTimeInterface $lastEntryTime): self
    {
        $this->lastEntryTime = $lastEntryTime;

        return $this;
    }
}
