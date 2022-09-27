<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected Request $request;

    /**
     * Constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->validateRequest($request);

        $this->request = $request;
    }

    /**
     * Validates Request depending from request content type.
     *
     * @param Request $request the Request to be validated
     *
     * @throws HttpException if validation does not pass
     */
    private function validateRequest(Request $request)
    {
        if ($request->getContentType() == 'json') {
            $this->validateJsonRequest($request);
        }
    }

    /**
     * Validates if content is in acceptable json format.
     *
     * @param Request $request the request object to validate
     *
     * @throws HttpException if content cannot be decoded to json
     */
    private function validateJsonRequest(Request $request): void
    {
        if (!empty($request->getContent()) && is_null(json_decode($request->getContent()))) {
            throw new HttpException(ResponseAlias::HTTP_UNSUPPORTED_MEDIA_TYPE, 'Invalid request content format!');
        }
    }
}
