<?php

namespace App\Controller\Api;

use App\Dto\SportVenueWithinDistanceOutput;
use App\Repository\SportVenueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SportVenueWithinDistanceController extends AbstractController
{
    #[Route('/api/sport_venues/within_distance', methods: ['GET'])]
    public function __invoke(Request $request, SportVenueRepository $repository): JsonResponse
    {
        $lat = $request->query->get('lat');
        $lng = $request->query->get('lng');
        $distance = $request->query->get('distance');
        $limit = (int) $request->query->get('limit', 50);

        $venues = $lat && $lng && $distance
            ? $repository->findWithinDistance((float)$lat, (float)$lng, (float)$distance, $limit)
            : $repository->findBy([], ['id'=>'ASC'], $limit);

        $dtos = [];
        foreach ($venues as $venue) {
            $dto = new SportVenueWithinDistanceOutput();

            $dto->id = $venue['id'] ?? $venue->getId();
            $dto->name = $venue['name'] ?? $venue->getName();
            $dto->lat = $venue['lat'] ?? $venue->getLat();
            $dto->lng = $venue['lng'] ?? $venue->getLng();
            $dto->distance = $venue['distance'] ?? null;
            $dtos[] = $dto;
        }

        return new JsonResponse($dtos);
    }
}