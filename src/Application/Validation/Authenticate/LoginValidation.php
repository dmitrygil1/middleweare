<?php

declare(strict_types=1);

namespace App\Application\Validation\Authenticate;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

readonly class LoginValidation implements \App\Application\Validation\HasValidation
{
    private ValidatorInterface $validator;

    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }

    public function validate(array $data): void
    {
        $constraints = new Assert\Collection([
            'username' => [
                new Assert\NotBlank(message: 'Должен быть заполнен.'),
                new Assert\Type(type: 'string', message: 'Имя пользователя должно быть строкой.'),
            ],
            'password' => [
                new Assert\NotBlank(message: 'Должен быть заполнен.'),
                new Assert\Type(type: 'string', message: 'Пароль должен быть строкой.'),
            ],
        ]);

        $violations = $this->validator->validate($data, $constraints);

        if ($violations->count() > 0) {
            throw new ValidationFailedException('Ошибка валидации', $violations);
        }
    }
}
