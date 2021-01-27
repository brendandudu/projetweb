<?php

namespace App\Entity;

use App\Repository\WeekRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeekRepository::class)
 */
class Week
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
    private $endsAt;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="week")
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
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

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setWeek($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getWeek() === $this) {
                $booking->setWeek(null);
            }
        }

        return $this;
    }
}
