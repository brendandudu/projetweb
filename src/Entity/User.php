<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
fields = {"email"},
 *          message = "l'email est déjà utilisé"
 *     )
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class User implements UserInterface
{

    /**
     * @Assert\EqualTo(propertyPath="password", message="les deux mots de passe sont différents")
     */
    public $confirm_password;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="L'email ne peut pas être vide")
     * @Assert\Email()
     */
    private $email;
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le mot de passe ne peut pas être vide")
     * @Assert\Regex(
     *     pattern="^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8}^",
     *     message="Le mot de passe doit contenir minimum 8 caractères, dont au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial (@,#..)")
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $lastName;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\GreaterThan(propertyPath="createdAt")
     */
    private $deletedAt;
    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="user")
     */
    private $bookings;
    /**
     * @Vich\UploadableField(mapping="userPictures", fileNameProperty="picture")
     * @var File
     * @Assert\File
     */
    private $pictureFile;
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
    /**
     * @ORM\OneToMany(targetEntity=Lodging::class, mappedBy="owner")
     */
    private $lodgings;
    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     * @Assert\Regex(
     *     pattern="^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}^",
     *     message="Le numéro de téléphone n'est pas bon"
     *     )
     */
    private $phone;
    /**
     * @ORM\ManyToMany(targetEntity=Lodging::class)
     */
    private $wishList;
    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user")
     */
    private $comments;
    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="user")
     */
    private $notifications;


    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->lodgings = new ArrayCollection();
        $this->wishList = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new DateTime();
    }

    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    public function setPictureFile(?File $picture = null): void
    {
        $this->pictureFile = $picture;

        if ($picture) {
            $this->updatedAt = new DateTime();
        }
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

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
            $booking->setUser($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        // set the owning side to null (unless already changed)
        if ($this->bookings->removeElement($booking) && $booking->getUser() === $this) {
            $booking->setUser(null);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->email;
    }

    /**
     * @return Collection|Lodging[]
     */
    public function getLodgings(): Collection
    {
        return $this->lodgings;
    }

    public function addLodging(Lodging $lodging): self
    {
        if (!$this->lodgings->contains($lodging)) {
            $this->lodgings[] = $lodging;
            $lodging->setOwner($this);
        }

        return $this;
    }

    public function removeLodging(Lodging $lodging): self
    {
        // set the owning side to null (unless already changed)
        if ($this->lodgings->removeElement($lodging) && $lodging->getOwner() === $this) {
            $lodging->setOwner(null);
        }

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture): void
    {
        $this->picture = $picture;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function addWishList(Lodging $wishList): self
    {
        if (!$this->wishList->contains($wishList)) {
            $this->wishList[] = $wishList;
        }
        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);

        }

        return $this;
    }

    public function removeWishList(Lodging $wishList): self
    {
        $this->wishList->removeElement($wishList);

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        // set the owning side to null (unless already changed)
        if ($this->comments->removeElement($comment) && $comment->getUser() === $this) {
            $comment->setUser(null);
        }

        return $this;
    }

    public function isAlreadyInWishList(Lodging $lodging): bool
    {

        foreach ($this->getWishList() as $aLodging) {
            if ($aLodging === $lodging) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Collection|Lodging[]
     */
    public function getWishList(): Collection
    {
        return $this->wishList;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }

    public function getNotificationsNotSeen(): ?array
    {
        $notifs = array();
        foreach ($this->notifications as $notif) {
            if (!$notif->getSeen()) {
                $notifs[] = $notif;
            }
        }
        return $notifs;
    }

}
