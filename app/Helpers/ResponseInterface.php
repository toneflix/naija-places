<?php

namespace App\Helpers;

use App\Enums\HttpStatus;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ResponseInterface
{
    public function info(
        array|Collection|AbstractPaginator|LengthAwarePaginator|JsonResource $data,
        int|HttpStatus $code = 200,
        ?array $extra = []
    ): \Illuminate\Http\Response;

    public function error(
        array|Collection|AbstractPaginator|LengthAwarePaginator|JsonResource $data,
        int|HttpStatus $code = 200,
        ?array $extra = []
    ): \Illuminate\Http\Response;

    public function success(
        array|Collection|AbstractPaginator|LengthAwarePaginator|JsonResource $data,
        int|HttpStatus $code = 200,
        ?array $extra = []
    ): \Illuminate\Http\Response;
}
