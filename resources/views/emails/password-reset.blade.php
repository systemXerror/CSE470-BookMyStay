@component('mail::message')
# Reset Your Password

Hello {{ $user->name }}!

You are receiving this email because we received a password reset request for your BookMyStay account.

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Reset Password
@endcomponent

This password reset link will expire in **{{ $expire }} minutes**.

If you did not request a password reset, no further action is required.

**Security Tip:** If you didn't request this password reset, please contact our support team immediately.

Thanks,<br>
{{ config('app.name') }} Team

<hr>

<small>
If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: {{ $url }}
</small>
@endcomponent
