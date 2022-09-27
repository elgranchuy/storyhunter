<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Exception that can be thrown when a Model fails to save.
 */
class ModelSaveException extends Exception
{
    /** @var Model */
    protected Model $model;

    /**
     * @param Model $model
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(Model $model, int $code = 0, Throwable $previous = null)
    {
        $id = $model->getKey();
        $class = get_class($model);

        parent::__construct("Failed to save $class [$id]", $code, $previous);
    }
}
