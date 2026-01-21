<?php

namespace App\Http\Middleware;

use App\Rules\NoSqlInjection;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventSqlInjection
{
    /**
     * Fields that should be excluded from SQL injection check
     * (e.g., password fields, HTML editors, etc.)
     */
    protected array $excludedFields = [
        'password',
        'password_confirmation',
        'current_password',
        'new_password',
        '_token',
        '_method',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only check POST, PUT, PATCH requests
        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            return $next($request);
        }

        $input = $request->all();

        if ($this->containsSqlInjection($input)) {
            // Log the attempt
            \Log::warning('SQL Injection attempt detected', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'input' => $this->sanitizeForLog($input),
            ]);

            // If it's an AJAX/Livewire request
            if ($request->ajax() || $request->wantsJson() || $request->hasHeader('X-Livewire')) {
                return response()->json([
                    'message' => 'Input mengandung karakter yang tidak diperbolehkan untuk keamanan.',
                    'errors' => ['general' => ['Input mengandung karakter yang tidak diperbolehkan untuk keamanan.']]
                ], 422);
            }

            // For regular form submissions
            return back()->withErrors([
                'general' => 'Input mengandung karakter yang tidak diperbolehkan untuk keamanan.'
            ])->withInput($request->except($this->excludedFields));
        }

        return $next($request);
    }

    /**
     * Recursively check for SQL injection in input
     */
    protected function containsSqlInjection(array $input, string $prefix = ''): bool
    {
        foreach ($input as $key => $value) {
            $fieldName = $prefix ? "{$prefix}.{$key}" : $key;

            // Skip excluded fields
            if (in_array($key, $this->excludedFields)) {
                continue;
            }

            if (is_array($value)) {
                if ($this->containsSqlInjection($value, $fieldName)) {
                    return true;
                }
            } elseif (is_string($value)) {
                if (!NoSqlInjection::isSafe($value)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Sanitize input for logging (remove sensitive data)
     */
    protected function sanitizeForLog(array $input): array
    {
        $sanitized = [];

        foreach ($input as $key => $value) {
            if (in_array($key, $this->excludedFields)) {
                $sanitized[$key] = '[REDACTED]';
            } elseif (is_array($value)) {
                $sanitized[$key] = $this->sanitizeForLog($value);
            } else {
                $sanitized[$key] = is_string($value) ? substr($value, 0, 100) : $value;
            }
        }

        return $sanitized;
    }
}
