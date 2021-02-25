<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 * @ORM\HasLifecycleCallbacks()
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
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity=Lodging::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lodging;

    /**
     * @ORM\Column(type="date")
     * @ORM\JoinColumn(nullable=false)
     */
    private $beginsAt;

    /**
     * @ORM\Column(type="date")
     * @ORM\JoinColumn(nullable=false)
     */
    private $endsAt;

    /**
     * @ORM\ManyToOne(targetEntity=BookingState::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bookingState;

    /**
     * @ORM\PrePersist
     */
    public function setBookedAtValue(): void
    {
        $this->bookedAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist()
     */
    public function calculateTotalPrice(): void
    {
        $nbNuits = $this->endsAt->diff($this->beginsAt)->format("%a");
        $total = $nbNuits * $this->getLodging()->getNightPrice();
        $this->totalPricing = $total;
    }

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

    public function setBookedAt($date): self
    {
        $this->bookedAt = $date;
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

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $idUser): self
    {
        $this->User = $idUser;

        return $this;
    }

    public function getLodging(): ?Lodging
    {
        return $this->lodging;
    }

    public function setLodging(?Lodging $id_lodging): self
    {
        $this->lodging = $id_lodging;

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
