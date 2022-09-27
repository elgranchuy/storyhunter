<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TagController extends ModelControllerBase
{
    protected static array $rules = [
        'name' => ['required', 'min:2'],
    ];

    public function getModelQuery(): Builder
    {
        return Tag::query();
    }

    public function index(): Collection
    {
        return $this->getModelQuery()->get();
    }
}
