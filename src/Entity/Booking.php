<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $beginsAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endsAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $bookedAt;

    /**
     * @ORM\Column(type="float")
     */
    private $totalPricing;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalOccupiers;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBeginsAt(): ?\DateTimeInterface
    {
        return $this->beginsAt;
    }

    public function setBeginsAt(\DateTimeInterface $beginsAt): self
    {
        $this->beginsAt = $beginsAt;

        return $this;
    }

    public function getEndsAt(): ?\DateTimeInterface
    {
        return $this->endsAt;
    }

    public function setEndsAt(\DateTimeInterface $endsAt): self
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    public function getBookedAt(): ?\DateTimeInterface
    {
        return $this->bookedAt;
    }

    public function setBookedAt(\DateTimeInterface $bookedAt): self
    {
        $this->bookedAt = $bookedAt;

        return $this;
    }

    public function getTotalPricing(): ?float
    {
        return $this->totalPricing;
    }

    public function setTotalPricing(float $totalPricing): self
    {
        $this->totalPricing = $totalPricing;

        return $this;
    }

    public function getTotalOccupiers(): ?int
    {
        return $this->totalOccupiers;
    }

    public function setTotalOccupiers(int $totalOccupiers): self
    {
        $this->totalOccupiers = $totalOccupiers;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
