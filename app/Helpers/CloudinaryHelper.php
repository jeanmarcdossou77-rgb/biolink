<?php

namespace App\Helpers;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class CloudinaryHelper
{
    private static function getClient()
    {
        return new Cloudinary(
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
                'url' => ['secure' => true]
            ])
        );
    }

    public static function uploadImage($filePath, $folder = 'biolink/posts')
    {
        try {
            $cloudinary = self::getClient();
            $result = $cloudinary->uploadApi()->upload($filePath, [
                'folder' => $folder,
                'resource_type' => 'image',
            ]);
            return $result['secure_url'];
        } catch (\Exception $e) {
            \Log::error('Cloudinary upload error: ' . $e->getMessage());
            return null;
        }
    }

    public static function uploadVideo($filePath, $folder = 'biolink/videos')
    {
        try {
            $cloudinary = self::getClient();
            $result = $cloudinary->uploadApi()->upload($filePath, [
                'folder' => $folder,
                'resource_type' => 'video',
            ]);
            return $result['secure_url'];
        } catch (\Exception $e) {
            \Log::error('Cloudinary video upload error: ' . $e->getMessage());
            return null;
        }
    }
}