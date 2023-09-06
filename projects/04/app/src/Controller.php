<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class Controller
{
    private ValidatorInterface $validator;

    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }

    public function __invoke(Request $request): Response
    {
        $errors = $this->validator->validate($request->request->get('string'), [
            new Assert\NotBlank(),
            new Assert\Regex('#^([^()]*+(\((?>[^()]|(?1))*+\)[^()]*+)++)$|^[^\(\)]*$#')
        ]);

        return 0 === $errors->count()
            ? new Response('OK', Response::HTTP_OK)
            : new Response('Bad request', Response::HTTP_BAD_REQUEST)
        ;
    }
}
