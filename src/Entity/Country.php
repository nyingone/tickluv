<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $iso2Code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $countryName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIso2Code(): ?string
    {
        return $this->iso2Code;
    }

    public function setIso2Code(string $iso2Code): self
    {
        $this->iso2Code = $iso2Code;

        return $this;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function setCountryName(string $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }
}
