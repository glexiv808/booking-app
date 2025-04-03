<?php

namespace App\Repository\Impl;

use App\Models\SportType;
use App\Repository\ISportTypeRepository;
use Illuminate\Http\Exceptions\HttpResponseException;

class SportTypeRepository implements ISportTypeRepository
{

    /**
     * Throw a Not Found error.
     *
     * @param string $message The error message to display.
     * @throws HttpResponseException Throws a 404 error response with the message.
     */
    public function throwNotFoundError(string $message = 'SportType not found')
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
        ], 404));
    }

    /**
     * Get all Sport Types.
     *
     * @return array Returns an array of all Sport Types.
     */
    public function show(): array
    {
        return SportType::all()->toArray();
    }

    /**
     * Get a Sport Type by ID.
     *
     * @param int $id The ID of the Sport Type.
     * @return SportType|null Returns the Sport Type if found, or null.
     */
    public function getById($id): ?SportType
    {
        return SportType::where('sport_type_id', $id)->first();
    }

    /**
     * Store a new Sport Type.
     *
     * @param array $data The data for the new Sport Type.
     * @return SportType Returns the created Sport Type.
     */
    public function store(array $data): SportType
    {
        return SportType::create($data);
    }

    /**
     * Update an existing Sport Type by ID.
     *
     * @param array $data The data to update the Sport Type with.
     * @param int $id The ID of the Sport Type to update.
     * @return SportType|null Returns the updated Sport Type, or null if not found.
     */
    public function update(array $data, $id): ?SportType
    {
        $sportType = SportType::where('sport_type_id', $id)->first();
        if (empty($sportType)) {
            $this->throwNotFoundError();
        }
        $sportType->update($data);
        $sportType->save();
        return $sportType;
    }

    /**
     * Delete a Sport Type by ID.
     *
     * @param int $id The ID of the Sport Type to delete.
     * @return SportType|null Returns the deleted Sport Type, or null if not found.
     */
    public function delete($id): ?SportType
    {
        $sportType = SportType::where('sport_type_id', $id)->first();
        if (empty($sportType)) {
            $this->throwNotFoundError();
        }
        $sportType->delete();
        return $sportType;
    }
}
