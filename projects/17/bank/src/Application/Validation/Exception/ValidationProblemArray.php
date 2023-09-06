<?php

declare(strict_types=1);

namespace App\Application\Validation\Exception;

use App\Application\Validation\Dto\BadRequestMessage;
use App\Application\Validation\Exception\Contract\ValidationProblemInterface;

class ValidationProblemArray extends \Exception implements ValidationProblemInterface
{
    public function __construct(private readonly BadRequestMessage $dataset)
    {
        parent::__construct($this->dataset->detail, $this->dataset->status);
    }

    /**
     * @return array{
     *     status:int,
     *     title:string,
     *     detail:string,
     *     violations:array
     * }
     */
    public function toArray(): array
    {
        return [
            'status' => $this->dataset->status,
            'title' => $this->dataset->title,
            'detail' => $this->dataset->detail,
            'violations' => $this->dataset->violations,
        ];
    }
}
