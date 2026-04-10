<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 560px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%); padding: 32px 40px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 22px; }
        .header p { color: rgba(255,255,255,0.8); margin: 6px 0 0; font-size: 14px; }
        .body { padding: 32px 40px; }
        .body p { color: #444; font-size: 15px; line-height: 1.6; margin: 0 0 16px; }
        .credentials { background: #f9f6f0; border: 1px solid #e8d5a3; border-radius: 8px; padding: 20px 24px; margin: 24px 0; }
        .credentials table { width: 100%; border-collapse: collapse; }
        .credentials td { padding: 6px 0; font-size: 14px; color: #333; }
        .credentials td:first-child { font-weight: bold; color: #3D2914; width: 110px; }
        .credentials td:last-child { font-family: monospace; }
        .footer { background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 40px; text-align: center; }
        .footer p { color: #999; font-size: 12px; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Icon Venue & Suites</h1>
            <p>Inventory Management System</p>
        </div>
        <div class="body">
            <p>Hi {{ $user->name }},</p>
            <p>An account has been created for you on the Icon Venue & Suites Inventory Management System. Here are your login credentials:</p>

            <div class="credentials">
                <table>
                    <tr>
                        <td>Email:</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td>{{ $plainPassword }}</td>
                    </tr>
                    <tr>
                        <td>Role:</td>
                        <td>{{ ucfirst($user->role) }}</td>
                    </tr>
                </table>
            </div>

            <p>You can log in at: <a href="{{ url('/login') }}" style="color: #D4AF37;">{{ url('/login') }}</a></p>
            <p>For security, please change your password after your first login via your Profile Settings.</p>
        </div>
        <div class="footer">
            <p>This is an automated message from Icon Venue & Suites Inventory System. Please do not reply.</p>
        </div>
    </div>
</body>
</html>
