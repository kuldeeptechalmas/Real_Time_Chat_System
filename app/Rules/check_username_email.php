<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class check_username_email implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user_data = User::where('name', $value)
            ->orWhere('email', $value)
            ->get();

        if ($user_data->isEmpty()) {
            $fail('User is Not Found');
        }
    }
}
