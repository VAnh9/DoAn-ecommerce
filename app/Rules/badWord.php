<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class badWord implements ValidationRule
{
    protected $badWords = ['shoot', 'fuck', 'gun', 'punch'];
    protected $stringRepalce;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach($this->badWords as $badWord) {

          $pattern = '/\b' . preg_quote($badWord, '/') . '\b/i';

          $replacement = str_repeat('*', strlen($badWord));

          $value = preg_replace($pattern, $replacement, $value );
        }

        $this->stringRepalce = $value;
    }

    public function getData() {
      return $this->stringRepalce;
    }

}
