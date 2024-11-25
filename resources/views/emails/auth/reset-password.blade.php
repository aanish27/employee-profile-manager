<x-mail::message>
# Please Take Action

You are receiving this email because we received a password reset request for your account.

<x-mail::button :url="$resetUrl">
Reset Link
</x-mail::button>

**This password reset link will expire in 60 minutes From the time You received.**

If you did not request a password reset, no further action is required.

Thanks,<br>
**Support Team**

<hr>

If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:<{{ $resetUrl }}>

</x-mail::message>
