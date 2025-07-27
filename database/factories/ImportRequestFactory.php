<?php

namespace Database\Factories;

use App\Models\ImportRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ImportRequest>
 */
class ImportRequestFactory extends Factory
{
    protected $model = ImportRequest::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_path' => 'imports/sample.csv',
            'status' => 'completed',
            'error_file_path' => null,
        ];
    }
}
