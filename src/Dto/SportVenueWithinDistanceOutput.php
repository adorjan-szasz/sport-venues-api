<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

final class SportVenueWithinDistanceOutput
{
    #[Groups(['read'])]
    public int $id;

    #[Groups(['read'])]
    public string $name;

    #[Groups(['read'])]
    public float $lat;

    #[Groups(['read'])]
    public float $lng;

    #[Groups(['read'])]
    public ?float $distance = null;
}