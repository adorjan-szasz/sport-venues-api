<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SportVenueApiTest extends WebTestCase
{
    public function testGetVenuesWithinDistance(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/sport_venues/within_distance?lat=48.8566&lng=2.3522&distance=10', [
            'headers' => [
                'X-API-KEY' => 'super_secret_key_123',
                'Accept' => 'application/json',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        // Check known venue exists
        $names = array_column($data, 'name');
        $this->assertContains('Stadium A', $names);

        // Check distance field exists if available
        if (isset($data[0]['distance'])) {
            $this->assertIsFloat($data[0]['distance'] + 0);
        }
    }
}
