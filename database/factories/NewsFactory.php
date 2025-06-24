<?php

namespace Database\Factories;
use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Sahte başlık
            'title' => $this->faker->sentence,
            // Sahte içerik
            'content' => $this->faker->paragraph(5),
            // Görsel yolu (dummy, gerçek dosya yok)
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
