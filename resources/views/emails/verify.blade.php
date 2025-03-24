<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Your Email Address</title>
</head>
<body>
<h1>Hello, {{ $user->name }}!</h1>
<p>Please click the button below to verify your email address.</p>
<p>
    <a href="{{ url('/api/verify-email?token=' . $token) }}"
       style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
        Verify Email Address
    </a>
</p>
<p>If you did not create an account, no further action is required.</p>
<p>This verification link will expire in 60 minutes.</p>
<p>Regards,<br>Your Application</p>
</body>
</html>
