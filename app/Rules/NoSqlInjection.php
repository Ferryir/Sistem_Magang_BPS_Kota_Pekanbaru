<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoSqlInjection implements ValidationRule
{
    /**
     * SQL injection patterns to detect
     */
    protected array $sqlPatterns = [
        '/\b(SELECT|INSERT|UPDATE|DELETE|DROP|TRUNCATE|ALTER|CREATE|REPLACE)\b/i',
        '/\b(UNION|JOIN|HAVING|GROUP BY|ORDER BY)\b/i',
        '/\b(AND|OR)\s+\d+\s*=\s*\d+/i',
        '/\b(AND|OR)\s+[\'"]?\w+[\'"]?\s*=\s*[\'"]?\w+[\'"]?/i',
        '/--\s*$/m',
        '/\/\*.*\*\//s',
        '/;\s*(DROP|DELETE|TRUNCATE|INSERT|UPDATE)/i',
        '/\bEXEC\s*\(/i',
        '/\bEXECUTE\s*\(/i',
        '/\bsp_\w+/i',
        '/\bxp_\w+/i',
        '/\bINTO\s+OUTFILE\b/i',
        '/\bLOAD_FILE\s*\(/i',
        '/\bBENCHMARK\s*\(/i',
        '/\bSLEEP\s*\(/i',
        '/\bWAITFOR\s+DELAY\b/i',
        '/0x[0-9a-fA-F]+/',
        '/\bCHAR\s*\(/i',
        '/\bCONCAT\s*\(/i',
        '/\bCONCAT_WS\s*\(/i',
        '/\'\s*(OR|AND)\s+/i',
        '/"\s*(OR|AND)\s+/i',
        '/\bINFORMATION_SCHEMA\b/i',
        '/\bSYS\.\w+/i',
        '/\bDUAL\b/i',
        '/\'\s*;\s*--/i',
        '/\bHAVING\s+\d+\s*=\s*\d+/i',
        '/\bGROUP\s+BY\s+\d+/i',
    ];

    /**
     * XSS patterns to detect
     */
    protected array $xssPatterns = [
        '/<script\b[^>]*>/i',
        '/<\/script>/i',
        '/javascript\s*:/i',
        '/on\w+\s*=/i',
        '/<iframe\b[^>]*>/i',
        '/<embed\b[^>]*>/i',
        '/<object\b[^>]*>/i',
        '/<svg\b[^>]*on/i',
    ];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            return;
        }

        // Check for SQL injection patterns
        foreach ($this->sqlPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                $fail('Input :attribute mengandung karakter yang tidak diperbolehkan untuk keamanan.');
                return;
            }
        }

        // Check for XSS patterns
        foreach ($this->xssPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                $fail('Input :attribute mengandung karakter yang tidak diperbolehkan untuk keamanan.');
                return;
            }
        }
    }

    /**
     * Static method to check if input is safe (for use outside validation)
     */
    public static function isSafe(mixed $value): bool
    {
        if (!is_string($value)) {
            return true;
        }

        $instance = new self();

        foreach ($instance->sqlPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return false;
            }
        }

        foreach ($instance->xssPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return false;
            }
        }

        return true;
    }
}
