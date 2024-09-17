<?php

namespace App\Entity;

use App\Repository\DataRealtimeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataRealtimeRepository::class)]
class DataRealtime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $IDAssy = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Zvalue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Xvalue = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datetime = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $status = null;

    public function getIDAssy(): ?int
    {
        return $this->IDAssy;
    }

    public function setIDAssy(int $IDAssy): static
    {
        $this->IDAssy = $IDAssy;

        return $this;
    }

    public function getZvalue(): ?string
    {
        return $this->Zvalue;
    }

    public function setZvalue(?string $Zvalue): static
    {
        $this->Zvalue = $Zvalue;

        return $this;
    }

    public function getXvalue(): ?string
    {
        return $this->Xvalue;
    }

    public function setXvalue(?string $Xvalue): static
    {
        $this->Xvalue = $Xvalue;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(?\DateTimeInterface $datetime): static
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
