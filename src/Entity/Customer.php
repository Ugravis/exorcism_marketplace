<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Sequentially(
        [
            new Assert\NotBlank(
                message: "- Requis."
            ),
            new Assert\Length(
                max: 50, 
                maxMessage: "- Maximum {{ limit }} caractères."
            )
        ], groups:['step2']
    )]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\Sequentially(
        [
            new Assert\NotBlank(
                message: "- Requis."
            ),
            new Assert\Length(
                max: 50, 
                maxMessage: "- Maximum {{ limit }} caractères."
            )
        ], groups:['step2']
    )]
    private ?string $surname = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Sequentially(
        [
            new Assert\NotBlank(
                message: "- Requis."
            ),
            new Assert\Email(
                message: "- Invalide. Exemple : john@doe.fr"
            ),
            new Assert\Length(
                max: 50, 
                maxMessage: "- Maximum {{ limit }} caractères."
            )
        ], groups: ['step2']
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Sequentially(
        [
            new Assert\Regex(
                pattern: "/^\+?[0-9\s\-]+$/", 
                message: "- Invalide."
            ),
            new Assert\Length(
                min: 8, 
                max: 20, 
                minMessage: "- Minimum {{ limit }} caractères.", 
                maxMessage: "- Maximum {{ limit }} caractères."
            )
        ], groups: ['step2']
    )]
    private ?string $phone = null;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'customer')]
    private Collection $bookings;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'customer_id')]
    private Collection $reviews;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setCustomer($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getCustomer() === $this) {
                $booking->setCustomer(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setCustomerId($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getCustomerId() === $this) {
                $review->setCustomerId(null);
            }
        }

        return $this;
    }
}
