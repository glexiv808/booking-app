<?php

namespace App\Repository;

interface ISportTypeRepository
{
    public function show();
    public function getById($id);
    public function store(array $data);
    public function update(array $data,$id);
    public function delete($id);

}
