<?php

namespace App\Application\Validator;

use Illuminate\Http\Request;

interface FileUploadValidatorInterface
{
    public function validate(Request $request): void;
}