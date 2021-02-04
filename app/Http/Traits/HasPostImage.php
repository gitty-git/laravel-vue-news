<?php

namespace App\Http\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\Features;

trait HasPostImage
{
    public function updatePostImage(UploadedFile $photo)
    {
        tap($this->image, function ($previous) use ($photo) {
            $this->forceFill([
                'image' => $photo->storePublicly(
                    'profile-photos', ['disk' => $this->profileImageDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->profileImageDisk())->delete($previous);
            }
        });
    }


    public function getPostImageUrlAttribute()
    {
        return $this->image
            ? Storage::disk($this->profileImageDisk())->url($this->image)
            : $this->defaultPostImageUrl();
    }

    protected function profileImageDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
    }
}
