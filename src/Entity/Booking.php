<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $sheduledAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $postal_code = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $moreInformation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSheduledAt(): ?\DateTime
    {
        return $this->sheduledAt;
    }

    public function setSheduledAt(\DateTime $sheduledAt): static
    {
        $this->sheduledAt = $sheduledAt;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): static
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getMoreInformation(): ?string
    {
        return $this->moreInformation;
    }

    public function setMoreInformation(?string $moreInformation): static
    {
        $this->moreInformation = $moreInformation;

        return $this;
    }
}
