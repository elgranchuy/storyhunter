<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MessageController extends ModelControllerBase
{
    protected static array $rules = [
        'thread_id' => ['required', 'exists:threads,id'],
        'body' => ['required', 'min:2'],
    ];

    public function getModelQuery(): Builder
    {
        return Message::query();
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
        /** @var Thread $thread */
        $thread = Thread::findOrFail($id);

        $query = $thread->thread_messages()->getQuery();

        // If request has search attribute, do a simple wildcard search.
        if ($this->request->has('search')) {
            $query->where('body', 'like', '%' . $this->request->get('search') . '%');
        }

        return $query->get();

    }

}
