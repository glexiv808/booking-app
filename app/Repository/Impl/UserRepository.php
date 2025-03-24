<?php

namespace App\Repository\Impl;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function index(){
//        return Product::all();
    }

    public function getById($id){
//        return DB::table('products')->where('id', $id)->first();
    }

    public function getByEmail($email)
    {
//        return DB::table('users')->where('email', $email)->first();
    }

    public function store(array $data){
//        return DB::table('users')->insert($data);
    }

    public function update(array $data,$id){
//        return Product::whereId($id)->update($data);
    }

    public function delete($id): void
    {
//        Product::destroy($id);
    }
}
