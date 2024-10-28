<?php
namespace App\Helpers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Decoders\DataUriImageDecoder;
use Intervention\Image\Decoders\Base64ImageDecoder;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    private $manager;
    
    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Handle and save image.
     *
     * @param string $input Input image (base64 or file path)
     * @param string $path Storage path 
     * @param int $quality WebP quality (1-100)
     * @return string|null Saved image path
     */
    public function handleImage(string $input, string $path, string $name , int $quality = 60): ?string
    {
        try {
            // Read image using multiple decoders
            $image = $this->manager->read($input, [
                new DataUriImageDecoder(),
                new Base64ImageDecoder(),
            ]);
            // Generate random filename with webp extension
            $filename = $name . '.webp';
            $fullPath = $path . '/' . $filename;

            // Encode to WebP format with specified quality
            $encoded = $image->toWebp($quality);

            // Save to storage
            Storage::disk('public')->put($fullPath, $encoded);

            return $fullPath;
        } catch (\Exception $e) {
            // Log error or handle exception
            return null;
        }
    }
}