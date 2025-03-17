<?php
declare(strict_types=1);

namespace App\Application\Validation\Authenticate;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class RegisterValidation implements \App\Application\Validation\HasValidation
{
    private ValidatorInterface $validator;

    public function __construct() {
        $this->validator = Validation::createValidator();
    }

    public function validate(array $data): void
    {
        $constraints = new Assert\Collection([
            'username' => [
                new Assert\NotBlank(message: "Имя пользователя обязательно."),
                new Assert\Length(
                    min: 2, max: 20,
                    minMessage: "Имя пользователя должно содержать минимум 2 символа.",
                    maxMessage: "Имя пользователя должно содержать не более 20 символов."
                ),
                new Assert\Regex(
                    pattern: "/^\w+$/",
                    message: "Имя пользователя должно содержать только латинские буквы и цифры, без пробелов."
                ),
            ],
            'password' => [
                new Assert\NotBlank(message: "Пароль обязателен."),
                new Assert\Length(min: 5, minMessage: "Пароль должен содержать минимум 5 символов."),
                new Assert\Regex(pattern: "/[^\d]/", message: "Пароль должен содержать хотя бы один нецифровой символ."),
            ],
            'password_confirmation' => [
                new Assert\NotBlank(message: "Подтверждение пароля обязательно."),
                new Assert\EqualTo(
                    value: $data['password'],
                    message: "Пароли должны совпадать."
                ),
            ],
        ]);


        $violations = $this->validator->validate($data, $constraints);

        if ($violations->count() > 0) {
            throw new ValidationFailedException('Ошибка валидации', $violations);
        }
    }
}
