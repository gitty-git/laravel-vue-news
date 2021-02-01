<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class ImageRatio implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $image = $this->getImagePath($value);

//        $image_size = @getimagesize($image);
//        if ($image_size === false) {
//            return false;
//        }
//
//        $image_width = $image_size[0];
//        $image_height = $image_size[1];

        if (round(@getimagesize($image)[0] / @getimagesize($image)[1], 1) !== 3/2) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The aspect ratio of the image must be 3:2';
    }

    protected function getImagePath($value)
    {
        if ($value instanceof UploadedFile) {
            return $value->getPathname();
        }

        return $value;
    }
}
