<?php

namespace App\Entity;

use App\Repository\AvailabilityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AvailabilityRepository::class)
 */
class Availability
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\GreaterThan(
     *     "today",
     *     message = "La date doit être supérieure à aujourd'hui !"
     * )
     */
    private $beginsAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\NotBlank
     * @Assert\GreaterThan(
     *      propertyPath = "beginsAt",
     *      message = "La date de départ doit être supérieure à celle d'arrivée !"
     * )
     */
    private $endsAt;

    /**
     * @ORM\ManyToOne(targetEntity=Lodging::class, inversedBy="availabilities")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Assert\Valid
     */
    private $lodging;

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

    public function setEndsAt(?\DateTimeInterface $endsAt): self
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    public function getLodging(): ?Lodging
    {
        return $this->lodging;
    }

    public function setLodging(?Lodging $lodging): self
    {
        $this->lodging = $lodging;

        return $this;
    }
}
