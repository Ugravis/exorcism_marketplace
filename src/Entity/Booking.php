<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Sequentially(
        [
            new Assert\NotBlank(
                message: "Vueillez sélectionner une date et heure."
            )
        ], groups: ['step2']
    )]
    private ?\DateTime $sheduledAt = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Sequentially(
        [
            new Assert\NotBlank(
                message: "Vueillez saisir l'adresse du rendez-vous."
            ),
            new Assert\Length(
                max: 255, 
                maxMessage: "L'adresse ne peut pas dépasser {{ limit }} caractères."
            )
        ], groups: ['step2']
    )]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    #[Assert\Sequentially(
        [
            new Assert\NotBlank(
                message: "Vueillez saisir le code postal du rendez-vous."
            ),
            new Assert\Regex(
                pattern: "/^[0-9]{5}$/", 
                message: "Code postal invalide. Exemple : 75000"
            )
        ], groups: ['step2']
    )]
    private ?string $postal_code = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Sequentially(
        [
            new Assert\Length(
                max: 500, 
                maxMessage: "Les informations complémentaires ne peuvent pas dépasser {{ limit }} caractères."
            )
        ], ['step1']
    )]
    private ?string $moreInformation = null;

    #[ORM\ManyToOne(inversedBy: 'bookings', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(groups: ['step2'])]
    #[Assert\Valid]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    public const LOCATION_TYPE_HOUSE = 'house';
    public const LOCATION_TYPE_APARTMENT = 'apartment';
    public const LOCATION_TYPE_OUTDOOR = 'outdoor';
    public const LOCATION_TYPE_HISTORICAL = 'historical';
    public const LOCATION_TYPE_COMPANY = 'company'; 
    public const LOCATION_TYPE_OTHER = 'other';

    public const LOCATION_TYPES = [
        'Maison / pavillon' => self::LOCATION_TYPE_HOUSE,
        'Appartement' => self::LOCATION_TYPE_APARTMENT,
        'Lieu en extérieur' => self::LOCATION_TYPE_OUTDOOR,
        'Bâtiment historique' => self::LOCATION_TYPE_HISTORICAL,
        'Local d\'entreprise' => self::LOCATION_TYPE_COMPANY,
        'Autre' => self::LOCATION_TYPE_OTHER
    ];

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(groups: ['step1'], message: "Vueillez choisir un type de lieu.")]
    #[Assert\Choice(choices: Booking::LOCATION_TYPES, message: 'Vueillez choisir un type de lieu valide.')]
    private ?string $location_type = null;

    public const URGENCY_TYPE_LOW = 'low';
    public const URGENCY_TYPE_MEDIUM = 'medium';
    public const URGENCY_TYPE_HIGH = 'high';
    public const URGENCY_TYPE_CRITICAL = 'critical';

    public const URGENCY_TYPES = [
        'Urgence faible' => self::URGENCY_TYPE_LOW,
        'Urgence modérée' => self::URGENCY_TYPE_MEDIUM,
        'Urgence élevée' => self::URGENCY_TYPE_HIGH,
        'Urgence critique' => self::URGENCY_TYPE_CRITICAL
    ];

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(groups: ['step1'], message: "Vueillez choisir un niveau d'urgence.")]
    #[Assert\Choice(choices: Booking::URGENCY_TYPES, message: 'Vueillez choisir un niveau d\'urgence valide.')]
    private ?string $urgency_rank = null;

    public const TARGET_TYPE_PLACE = 'place';
    public const TARGET_TYPE_OBJECT = 'object';
    public const TARGET_TYPE_ANIMAL = 'animal';
    public const TARGET_TYPE_PERSON = 'person';
    public const TARGET_TYPE_OTHER = 'other';

    public const TARGET_TYPES = [
        'Un lieu' => self::TARGET_TYPE_PLACE,
        'Un objet' => self::TARGET_TYPE_OBJECT,
        'Un animal' => self::TARGET_TYPE_ANIMAL,
        'Une personne' => self::TARGET_TYPE_PERSON,
        'Autre' => self::TARGET_TYPE_OTHER
    ];

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(groups: ['step1'], message: "Vueillez choisir un type de cible.")]
    #[Assert\Choice(choices: Booking::TARGET_TYPES, message: 'Vueillez choisir un type de cible valide.')]
    private ?string $target_type = null;

    public const OBJECTIVE_TYPE_DIAGNOSTIC = 'diagnostic';
    public const OBJECTIVE_TYPE_PURIFICATION = 'purification';
    public const OBJECTIVE_TYPE_EXORCISM = 'exorcism';
    public const OBJECTIVE_TYPE_OTHER = 'other';

    public const OBJECTIVE_TYPES = [
        'Diagnostique' => self::OBJECTIVE_TYPE_DIAGNOSTIC,
        'Purification' => self::OBJECTIVE_TYPE_PURIFICATION,
        'Exorcisme' => self::OBJECTIVE_TYPE_EXORCISM,
        'Autre' => self::OBJECTIVE_TYPE_OTHER
    ];

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(groups: ['step1'], message: "Vueillez choisir un objectif d'intervention.")]
    #[Assert\Choice(choices: Booking::OBJECTIVE_TYPES, message: 'Vueillez choisir un objectif d\'intervention valide.')]
    private ?string $objective_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 50, groups: ['step2'], maxMessage: "L'adresse complémentaire ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $address_line_2 = null;

    #[ORM\Column(length: 255)]
    #[Assert\Sequentially(
        [
            new Assert\NotBlank(
                message: "Vueillez indiquer la ville du rendez-vous."
            ),
            new Assert\Length(
                max: 50, 
                maxMessage: "La ville ne peut pas dépasser {{ limit }} caractères."
            )
        ], groups: ['step2']
    )]
    private ?string $city = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSheduledAt(): ?\DateTime
    {
        return $this->sheduledAt;
    }

    public function setSheduledAt(?\DateTime $sheduledAt): static
    {
        $this->sheduledAt = $sheduledAt;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(?string $postal_code): static
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getMoreInformation(): ?string
    {
        return $this->moreInformation;
    }

    public function setMoreInformation(?string $moreInformation): static
    {
        $this->moreInformation = $moreInformation;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getLocationType(): ?string
    {
        return $this->location_type;
    }

    public function setLocationType(?string $location_type): static
    {
        $this->location_type = $location_type;

        return $this;
    }

    public function getUrgencyRank(): ?string
    {
        return $this->urgency_rank;
    }

    public function setUrgencyRank(?string $urgency_rank): static
    {
        $this->urgency_rank = $urgency_rank;

        return $this;
    }

    public function getTargetType(): ?string
    {
        return $this->target_type;
    }

    public function setTargetType(?string $target_type): static
    {
        $this->target_type = $target_type;

        return $this;
    }

    public function getObjectiveType(): ?string
    {
        return $this->objective_type;
    }

    public function setObjectiveType(?string $objective_type): static
    {
        $this->objective_type = $objective_type;

        return $this;
    }

    public function getAddressLine2(): ?string
    {
        return $this->address_line_2;
    }

    public function setAddressLine2(?string $address_line_2): static
    {
        $this->address_line_2 = $address_line_2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }
}