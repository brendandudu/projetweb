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
     * @ORM\Column(type="datetime")
     */
    private $beginsAt;


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

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity=Lodging::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_lodging;

    /**
     * @ORM\ManyToOne(targetEntity=Week::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $week;

    /**
     * @ORM\ManyToOne(targetEntity=BookingState::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bookingState;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdLodging(): ?Lodging
    {
        return $this->id_lodging;
    }

    public function setIdLodging(?Lodging $id_lodging): self
    {
        $this->id_lodging = $id_lodging;

        return $this;
    }

    public function getWeek(): ?Week
    {
        return $this->week;
    }

    public function setWeek(?Week $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getBookingState(): ?BookingState
    {
        return $this->bookingState;
    }

    public function setBookingState(?BookingState $bookingState): self
    {
        $this->bookingState = $bookingState;

        return $this;
    }
}
