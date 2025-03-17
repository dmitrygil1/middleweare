<?php

declare(strict_types=1);

namespace App\Application\Validation;

use Symfony\Component\Validator\Exception\ValidationFailedException;

interface HasValidation
{
    /**
     * Validate the provided data.
     *
     * @param  array  $data  The data to validate.
     *
     * @throws ValidationFailedException If validation fails.
     */
    public function validate(array $data): void;
}
