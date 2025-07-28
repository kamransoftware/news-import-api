<?php

namespace App\Application\Validator;

use Illuminate\Http\Request;

class FileUploadValidator implements FileUploadValidatorInterface
{
    public function validate(Request $request): void
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);
    }
}