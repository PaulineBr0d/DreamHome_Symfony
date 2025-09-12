<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Trait\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ListingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ListingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Listing implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['listing:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['listing:read'])]
    #[Assert\NotBlank(message: "Le titre est obligatoire.")]
    #[Assert\Length(
        min: 5,
        max: 50,
        minMessage: "Le titre doit faire au moins {{ limit }} caractères.",
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups(['listing:read'])]
    #[Assert\NotBlank(message: "Le prix est obligatoire.")]
    #[Assert\Type(
        type: 'numeric',
        message: "Le prix doit être un nombre valide."
    )]
    #[Assert\Positive(message: "Le prix doit être un nombre positif.")]
    #[Assert\Range(
        min: 100,
        max: 10000000,
        notInRangeMessage: "Le prix doit être entre {{ min }} et {{ max }}."
    )]
    private ?float $price = null;

    #[ORM\Column(length: 50)]
    #[Groups(['listing:read'])]
    #[Assert\NotBlank(message: "La ville est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "La ville doit faire au moins {{ limit }} caractères.",
        maxMessage: "La ville ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $city = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['listing:read'])]
    #[Assert\NotBlank(message: "La description est obligatoire.")]
    #[Assert\Length(
        min: 10,
        max: 150,
        minMessage: "La description doit faire au moins {{ limit }} caractères.",
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\ManyToOne(inversedBy: 'listings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['listing:read'])]
    private ?TransactionType $transactionType = null;

    #[ORM\ManyToOne(inversedBy: 'listings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PropertyType $propertyType = null;

    #[ORM\ManyToOne(inversedBy: 'listings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }


    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getTransactionType(): ?TransactionType
    {
        return $this->transactionType;
    }

    public function setTransactionType(?TransactionType $transactionType): static
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    public function getPropertyType(): ?PropertyType
    {
        return $this->propertyType;
    }

    public function setPropertyType(?PropertyType $propertyType): static
    {
        $this->propertyType = $propertyType;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="favorites")
     */
    private Collection $usersFavorites;

    public function __construct()
    {
        $this->userFavorites = new ArrayCollection();
    }

    public function getUsersFavorites(): Collection
    {
        return $this->usersFavorites;
    }
}
