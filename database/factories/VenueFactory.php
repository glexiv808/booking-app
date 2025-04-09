<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use MatanYadaev\EloquentSpatial\Objects\Point;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venue>
 */
class VenueFactory extends Factory
{
    public function definition(): array
    {
        $latitude = $this->faker->latitude;
        $longitude = $this->faker->longitude;

        return [
            'venue_id' => $this->faker->uuid,
            'owner_id' => User::factory(),
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'coordinates' => new Point($latitude, $longitude),
            'status' => 'locked',
        ];
    }
}
