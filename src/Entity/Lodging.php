<?php

namespace App\Entity;

use App\Repository\LodgingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LodgingRepository::class)
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
     */
    private $lodgingType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $space;

    /**
     * @ORM\Column(type="boolean")
     */
    private $internetAvailable;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $builtIn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $orientation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $currentCondition;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $weeklyPricing;

    /**
     * @ORM\OneToMany(targetEntity=Availability::class, mappedBy="lodging")
     */
    private $availabilities;

    public function __construct()
    {
        $this->availabilities = new ArrayCollection();
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

    public function getBuiltIn(): ?int
    {
        return $this->builtIn;
    }

    public function setBuiltIn(?int $builtIn): self
    {
        $this->builtIn = $builtIn;

        return $this;
    }

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(string $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    public function setOrientation(?string $orientation): self
    {
        $this->orientation = $orientation;

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

    public function getWeeklyPricing(): ?float
    {
        return $this->weeklyPricing;
    }

    public function setWeeklyPricing(float $weeklyPricing): self
    {
        $this->weeklyPricing = $weeklyPricing;

        return $this;
    }

    /**
     * @return Collection|Availability[]
     */
    public function getAvailabilities(): Collection
    {
        return $this->availabilities;
    }

    public function addAvailability(Availability $availability): self
    {
        if (!$this->availabilities->contains($availability)) {
            $this->availabilities[] = $availability;
            $availability->setLodging($this);
        }

        return $this;
    }

    public function removeAvailability(Availability $availability): self
    {
        if ($this->availabilities->removeElement($availability)) {
            // set the owning side to null (unless already changed)
            if ($availability->getLodging() === $this) {
                $availability->setLodging(null);
            }
        }

        return $this;
    }
}
