<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication Code</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .code-box {
            background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin: 30px 0;
        }
        .code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            margin: 10px 0;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <div style="font-size: 20px; font-weight: bold; color: white; margin: 0; padding: 0; line-height: 1; display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">IV&S</div>
            </div>
            <h1 style="color: #3D2914; margin: 0;">Two-Factor Authentication</h1>
            <p style="color: #666; margin: 5px 0 0 0;">{{ config('app.name') }}</p>
        </div>

        <p>Hello <strong>{{ $user->name }}</strong>,</p>
        
        <p>You have requested to sign in to your account. Please use the verification code below to complete your login:</p>

        <div class="code-box">
            <div style="font-size: 14px; margin-bottom: 10px;">Your Verification Code</div>
            <div class="code">{{ $code }}</div>
            <div style="font-size: 12px; margin-top: 10px;">Valid for 10 minutes</div>
        </div>

        <div class="warning">
            <strong>Security Notice:</strong> If you didn't request this code, please ignore this email and consider changing your password. Never share this code with anyone.
        </div>

        <p>This code will expire in <strong>10 minutes</strong> for your security.</p>

        <p>If you're having trouble signing in, please contact your system administrator.</p>

        <div class="footer">
            <p>This is an automated message from {{ config('app.name') }}.<br>
            Please do not reply to this email.</p>
            <p style="margin-top: 15px; font-size: 12px;">
                Sent at {{ now()->format('F j, Y \a\t g:i A T') }}
            </p>
        </div>
    </div>
</body>
</html>