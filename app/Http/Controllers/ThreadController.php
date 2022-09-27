<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ThreadController extends ModelControllerBase
{
    protected static array $rules = [
        'title' => ['required', 'min:2'],
    ];

    public function getModelQuery(): Builder
    {
        return Thread::query();
    }

    public function store(): Model
    {
        $this->request->merge([
           'user_id' => $this->request->user()->id
        ]);

        return parent::store();
    }

    public function index(string $id): Collection
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        return $user->threads;
    }
}
