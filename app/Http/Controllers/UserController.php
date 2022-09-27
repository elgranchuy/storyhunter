<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class UserController extends ModelControllerBase
{
    protected static array $rules = [
        'name' => ['required', 'min:2'],
        'email' => ['required','email'],
        'bio'   => ['required', 'min:10'],
        'password' => 'required',

    ];

    public function getModelQuery(): Builder
    {
        return User::query();
    }

    public function show(string $id): Model
    {
        $model = parent::show($id);
        $user = $this->request->user();

        if ($model->email != $user->email)
        {
            $model->makeHidden('email');
        }

        return $model;
    }

}
