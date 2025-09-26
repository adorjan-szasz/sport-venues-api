<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\Api\SportVenueWithinDistanceController;
use App\Filter\DistanceFilter;
use App\Repository\SportVenueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SportVenueRepository::class)]
#[ORM\Table(name: 'sport_venue')]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/sport_venues/within_distance',
            controller: SportVenueWithinDistanceController::class,
            paginationEnabled: false,
        ),
        new GetCollection(),
        new Get(),
    ],
    normalizationContext: ['groups' => ['read']],
    paginationEnabled: true,
    paginationItemsPerPage: 10,
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['name', 'lat', 'lng'])]
#[ApiFilter(DistanceFilter::class)]
class SportVenue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['read'])]
    private ?string $name = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 6)]
    #[Assert\NotBlank]
    #[Assert\Range(min: -90, max: 90)]
    #[Groups(['read'])]
    private ?string $lat = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 6)]
    #[Assert\NotBlank]
    #[Assert\Range(min: -180, max: 180)]
    #[Groups(['read'])]
    private ?string $lng = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(string $lng): static
    {
        $this->lng = $lng;

        return $this;
    }
}
