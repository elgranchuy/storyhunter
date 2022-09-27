<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelSaveException;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class ModelControllerBase extends Controller
{
    protected static array $rules;

    public function show(string $id): Model
    {
        return $this->getModel($id);
    }

    /**
     * @throws ValidationException
     * @throws ModelSaveException
     * @throws Exception
     */
    public function store(): Model
    {
        if (empty($this->request->except('_token'))) {
            throw new HttpException(ResponseAlias::HTTP_BAD_REQUEST, 'POST Request is empty!');
        }

        if (!empty(static::$rules)) {
            $rules = static::$rules;

            $this->validate($this->request, $rules, []);
        }

        $model = $this->getModelQuery()->create($this->request->request->all());

        if (!$model->exists) {
            throw new ModelSaveException($model);
        }

        return $model;
    }

    protected function getModel(string $id): Model
    {
        return $this->getModelQuery()->findOrFail($id);
    }
}
