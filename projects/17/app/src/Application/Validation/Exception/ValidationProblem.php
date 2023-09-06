<?php

declare(strict_types=1);

namespace App\Application\Validation\Exception;

use App\Application\Validation\Exception\Contract\ValidationProblemInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationProblem extends \Exception implements ValidationProblemInterface
{
    private string $detail;
    private array $violations;

    public function __construct(ConstraintViolationListInterface $violationList)
    {
        $this->detail = $this->buildDetail($violationList);
        $this->violations = $this->buildViolations($violationList);

        parent::__construct($this->detail, Response::HTTP_BAD_REQUEST);
    }

    public function toArray(): array
    {
        return [
            'status' => Response::HTTP_BAD_REQUEST,
            'title' => 'Validation Failed',
            'detail' => $this->detail,
            'violations' => $this->violations,
        ];
    }

    private function buildDetail(ConstraintViolationListInterface $violationList): string
    {
        $messages = [];

        foreach ($violationList as $violation) {
            $propertyPath = $violation->getPropertyPath();
            $prefix = mb_strlen($propertyPath) > 0 ? sprintf('%s: ', $propertyPath) : '';
            $messages[] = $prefix . $violation->getMessage();
        }

        return implode("\n", $messages);
    }

    private function buildViolations(ConstraintViolationListInterface $violationList): array
    {
        $violations = [];

        foreach ($violationList as $violation) {
            $violations['messages'][$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $violations;
    }
}
