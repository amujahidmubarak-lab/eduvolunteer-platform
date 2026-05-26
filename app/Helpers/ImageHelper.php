<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Compress and resize an uploaded image, then save it as WebP.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $directory
     * @param  int  $maxWidth
     * @param  int  $quality
     * @return string  Relative path to public storage
     */
    public static function compressAndResize($file, $directory, $maxWidth = 1200, $quality = 75)
    {
        $realPath = $file->getRealPath();
        $mime = $file->getMimeType();

        // Load image based on mime type
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = @imagecreatefromjpeg($realPath);
                break;
            case 'image/png':
                $image = @imagecreatefrompng($realPath);
                if ($image) {
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
                break;
            case 'image/gif':
                $image = @imagecreatefromgif($realPath);
                break;
            case 'image/webp':
                $image = @imagecreatefromwebp($realPath);
                break;
            default:
                // Fallback to storing original if mime type is unsupported
                return $file->store($directory, 'public');
        }

        if (!$image) {
            // Fallback if image creation failed
            return $file->store($directory, 'public');
        }

        // Get original dimensions
        $width = imagesx($image);
        $height = imagesy($image);

        // Calculate new dimensions
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) floor($height * ($maxWidth / $width));

            // Create new canvas
            $tmpImage = imagecreatetruecolor($newWidth, $newHeight);

            // Handle transparency
            imagecolortransparent($tmpImage, imagecolorallocatealpha($tmpImage, 0, 0, 0, 127));
            imagealphablending($tmpImage, false);
            imagesavealpha($tmpImage, true);

            // Resize
            imagecopyresampled($tmpImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $tmpImage;
        }

        // Output buffer to capture WebP format
        ob_start();
        imagewebp($image, null, $quality);
        $webpContent = ob_get_clean();

        // Destroy resource
        imagedestroy($image);

        // Save using Laravel Storage
        $filename = Str::random(40) . '.webp';
        $fullPath = $directory . '/' . $filename;
        Storage::disk('public')->put($fullPath, $webpContent);

        return $fullPath;
    }
}
