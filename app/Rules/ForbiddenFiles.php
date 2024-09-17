<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class ForbiddenFiles implements ValidationRule
{
    public $types;
    public function __construct(...$types)
    {
        return $this->types = $types;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $type = $value->getMimeType();
        if (in_array($type, $this->types)) {
            $fail('not allowed this file type');
        }
    }
}
