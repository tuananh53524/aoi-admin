<?php

namespace App\Helpers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Decoders\DataUriImageDecoder;
use Intervention\Image\Decoders\Base64ImageDecoder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
    public function handleImage(string $input, string $path, string $name, int $quality = 60): ?string
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
    /**
     * Convert and optimize image with specific ratio
     *
     * @param string $input Input image (base64 or file path)
     * @param string $path Storage path
     * @param string $name File name
     * @param string $ratio Ratio from config (e.g. '16:9', '1:1')
     * @param array $options Additional options
     * @return string|null Saved image path
     */
    public function convertImage(
        string $input,
        string $path,
        string $name,
        string $ratio = '1:1',
        array $options = []
    ): ?string {
        try {
            // Default options
            $defaultOptions = [
                'quality' => 80,
                'width' => 800,
                'dpi' => 72,
                'optimize' => true
            ];

            $options = array_merge($defaultOptions, $options);

            // Read image
            $image = $this->manager->read($input, [
                new DataUriImageDecoder(),
                new Base64ImageDecoder(),
            ]);

            // Parse ratio (e.g. "16:9" to calculate height)
            [$ratioWidth, $ratioHeight] = array_map('intval', explode(':', $ratio));
            $targetHeight = ($options['width'] * $ratioHeight) / $ratioWidth;

            // Resize image maintaining ratio
            $image->resize($options['width'], (int)$targetHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Crop to exact ratio if needed
            $image->cover($options['width'], (int)$targetHeight);

            // Set resolution (replaces density/DPI setting)
            $encoded = $image->toWebp($options['quality'], $options['dpi']);    

            // Generate filename
            $filename = $name . '.webp';
            $fullPath = $path . '/' . $filename;

            // Convert to WebP with quality setting
            $encoded = $image->toWebp($options['quality']);

            // Save to storage
            Storage::disk('public')->put($fullPath, $encoded);

            return $fullPath;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Image conversion failed: ' . $e->getMessage());
            return null;
        }
    }
}
