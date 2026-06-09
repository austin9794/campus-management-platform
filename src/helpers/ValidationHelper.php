<?php
namespace App\Helpers;

class ValidationHelper {
    /**
     * Validate $data against $rules.
     * Returns an array of errors keyed by field name, or [] if all pass.
     *
     * Supported rules: required, email, min:N, max:N, numeric, in:a,b,c
     */
    public static function validate(array $rules, array $data): array {
        $errors = [];
        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;
            foreach ($fieldRules as $rule) {
                $error = self::applyRule($field, $value, $rule, $data);
                if ($error) {
                    $errors[$field][] = $error;
                }
            }
        }
        return $errors;
    }

    private static function applyRule(string $field, mixed $value, string $rule, array $data): ?string {
        $label = ucfirst(str_replace('_', ' ', $field));

        if ($rule === 'required' && (is_null($value) || $value === '')) {
            return "$label is required.";
        }
        if ($rule === 'email' && $value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "$label must be a valid email address.";
        }
        if (str_starts_with($rule, 'min:')) {
            $min = (int) substr($rule, 4);
            if ($value !== null && strlen((string) $value) < $min) {
                return "$label must be at least $min characters.";
            }
        }
        if (str_starts_with($rule, 'max:')) {
            $max = (int) substr($rule, 4);
            if ($value !== null && strlen((string) $value) > $max) {
                return "$label may not exceed $max characters.";
            }
        }
        if ($rule === 'numeric' && $value !== null && !is_numeric($value)) {
            return "$label must be a number.";
        }
        if (str_starts_with($rule, 'in:')) {
            $allowed = explode(',', substr($rule, 3));
            if ($value !== null && !in_array($value, $allowed, true)) {
                return "$label must be one of: " . implode(', ', $allowed) . '.';
            }
        }
        return null;
    }
}