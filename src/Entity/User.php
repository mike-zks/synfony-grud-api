<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    attributes: [
        'validation_groups' => []
    ],
    normalizationContext: ['groups' => ('read:collection')],
    denormalizationContext: ['groups' => ('write:Post')],
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: [
        'put',
        'delete',
        'get' => [
            'normalization_context' => ['groups' => ['read:collection', 'read:item']]
        ]
    ]
)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[
        Groups(['read:collection', 'write:Post']),
        Length(min: 4, groups: ['create:Post'])
    ]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[
        Groups(['read:collection', 'write:Post']),
        Length(min: 4, groups: ['create:Post'])
    ]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read:collection'])]
    private ?\DateTimeInterface $creationdate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read:item'])]
    private ?\DateTimeInterface $updatedate = null;

    public function __construct()
    {
        $this->creationdate = new DateTime();
        $this->updatedate = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCreationdate(): ?\DateTimeInterface
    {
        return $this->creationdate;
    }

    public function setCreationdate(\DateTimeInterface $creationdate): self
    {
        $this->creationdate = $creationdate;

        return $this;
    }

    public function getUpdatedate(): ?\DateTimeInterface
    {
        return $this->updatedate;
    }

    public function setUpdatedate(\DateTimeInterface $updatedate): self
    {
        $this->updatedate = $updatedate;

        return $this;
    }
}
