<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $url = $this->getUrl('post');
        $mime = $this->getMimeType($url);

        return [
            'url' => $url,
            'mime' => $mime,
            'mediable_id' => fn ($attributes) => \App\Models\Post::find($attributes['mediable_id'])->getMorphClass(),
        ];
    }

    private function getUrl($type = 'post') {
        switch ($type) {
            case 'post':
                $urls = [
                    "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
                    "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
                    "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/VolkswagenGTIReview.mp4",
                    "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4",
                    "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                    "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/WhatCarCanYouGetForAGrand.mp4",
                    "https://plus.unsplash.com/premium_photo-1690971631360-c7b4f08b4f94?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxmZWF0dXJlZC1waG90b3MtZmVlZHwxMHx8fGVufDB8fHx8fA%3D%3D",
                    "https://images.unsplash.com/photo-1726828952056-5efd2d76c22b?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxmZWF0dXJlZC1waG90b3MtZmVlZHw3fHx8ZW58MHx8fHx8",
                    "https://plus.unsplash.com/premium_photo-1699566447802-0551b84a186d?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxmZWF0dXJlZC1waG90b3MtZmVlZHwzN3x8fGVufDB8fHx8fA%3D%3D"
                ];

                return $this->faker->randomElement($urls);
                break;

            case 'reel':
                $urls = [
                    "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4",
                    "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4",
                    "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4",
                    "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                ];

                return $this->faker->randomElement($urls);
                break;
            
            default:
                # code...
                break;
        }
    }

    private function getMimeType($url) {
        if (str()->contains($url, 'gtv-videos-bucket')) {
            return 'video';
        } else if(str()->contains($url, 'plus.unsplash.com') || str()->contains($url, 'images.unsplash.com')) {
            return 'image';
        }
    }

    public function post() {
        $url = $this->getUrl('post');
        $mime = $this->getMimeType($url);

        return $this->state(function($attributes) use($url, $mime) {
            return [
                'mime' => $mime,
                'url' => $url,
            ];
        });
    }
    public function reel() {
        $url = $this->getUrl('reel');
        $mime = $this->getMimeType($url);

        return $this->state(function($attributes) use($url, $mime) {
            return [
                'mime' => $mime,
                'url' => $url,
            ];
        });
    }
}
