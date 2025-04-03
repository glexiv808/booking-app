<?php

namespace App\Services;


use App\Http\Requests\SportTypeRequest;
use App\Models\SportType;

interface ISportTypeService
{
    /**
     * Handle getting all Sport Types.
     *
     * @return SportType[] Returns list of Sport Type
     */
    public function show(): array;

    /**
     * Handle getting a Sport Type by id.
     * @param int $id id of sport type
     * @return ?SportType Returns a Sport Type
     */
    public function findById(int $id): ?SportType;

    /**
     * Handle updating a Sport Type by id.
     * @param int $id int id of sport type
     * @param SportTypeRequest $request
     * @return ?SportType Returns a Sport Type
     */
    public function update(int $id, SportTypeRequest $request): ?SportType;


    /**
     * Handle deleting a Sport Type by id.
     * @param int $id id of sport type
     * @return ?SportType
     */
    public function delete(int $id): ?SportType;


    /**
     * Handle adding a Sport Type by id.
     * @param SportTypeRequest $request id of sport type
     * @return SportType
     */
    public function add(SportTypeRequest $request): SportType;
}
