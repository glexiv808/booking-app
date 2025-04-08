<?php

namespace App\Repository;

interface IVenueRepository
{
    public function show(int $perPage);
    public function getById(string $id);
    public function store(array $data);
    public function update(array $data, string $id);
    public function delete(string $id);
}
