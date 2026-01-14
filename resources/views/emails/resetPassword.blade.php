@component('mail::message')

{{-- <div style="width: 100%; display: flex; justify-content: start">
    <img src="{{ asset('assets/home/beranda/BPS.jpg') }}" alt="Logoss" style="max-width: 100%; height: auto;">
</div> --}}

Halo, {{ $user->name }}. Lupa Password?

<p>Reset password kamu</p>

@component('mail::button', ['url' => url('reset/'.$user->remember_token)])
    Reset Password
@endcomponent

Terima Kasih, <br>
{{ config('app.name') }}
@endcomponent