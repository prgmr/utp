<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;

class UniqueImageRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $newFileSize = $value->getSize();
        [$newWidth, $newHeight] = getimagesize($value->getRealPath());

        $images = Storage::files('public/images');
        foreach ($images as $img) {
            $storedPath = Storage::path($img);
            if (!file_exists($storedPath)) {
                continue;
            }
            $storedSize = filesize($storedPath);
            $storedImageSize = getimagesize($storedPath);

            if ($storedImageSize === false) {
                continue;
            }
            [$storedWidth, $storedHeight] = $storedImageSize;

            if ($storedWidth === $newWidth && $storedHeight === $newHeight && $storedSize === $newFileSize) {
                $fail("File with these image dimensions and size already exists.");
                return;
            }
        }
    }
}
