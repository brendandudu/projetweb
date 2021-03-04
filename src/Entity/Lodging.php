<?php

namespace App\Entity;

use App\Repository\LodgingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=LodgingRepository::class)
 * @Vich\Uploadable
 */
class Lodging
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=LodgingType::class, inversedBy="lodgings")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $lodgingType;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $capacity;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $space;

    /**
     * @ORM\Column(type="boolean")
     */
    private $internetAvailable;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $currentCondition;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $nightPrice;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="lodging")
     */
    private $bookings;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $picture;

    /**
     * @Vich\UploadableField(mapping="lodgingPictures", fileNameProperty="picture")
     * @var File
     */
    private $pictureFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=8)
     */
    private $lat;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=8)
     */
    private $lon;

    public function setPictureFile(?File $picture = null)
    {
        $this->pictureFile = $picture;

        if ($picture) {
            $this->updatedAt = new \DateTime();
        }
    }

    public function getPictureFile()
    {
        return $this->pictureFile;
    }


    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLodgingType(): ?LodgingType
    {
        return $this->lodgingType;
    }

    public function setLodgingType(?LodgingType $lodgingType): self
    {
        $this->lodgingType = $lodgingType;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getSpace(): ?int
    {
        return $this->space;
    }

    public function setSpace(int $space): self
    {
        $this->space = $space;

        return $this;
    }

    public function getInternetAvailable(): ?bool
    {
        return $this->internetAvailable;
    }

    public function setInternetAvailable(bool $internetAvailable): self
    {
        $this->internetAvailable = $internetAvailable;

        return $this;
    }

    public function getCurrentCondition(): ?string
    {
        return $this->currentCondition;
    }

    public function setCurrentCondition(string $currentCondition): self
    {
        $this->currentCondition = $currentCondition;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNightPrice(): ?float
    {
        return $this->nightPrice;
    }

    public function setNightPrice(float $nightPrice): self
    {
        $this->nightPrice = $nightPrice;

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
            $booking->setIdLodging($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getIdLodging() === $this) {
                $booking->setIdLodging(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture($picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?string
    {
        return $this->lon;
    }

    public function setLon(string $lon): self
    {
        $this->lon = $lon;

        return $this;
    }
}
