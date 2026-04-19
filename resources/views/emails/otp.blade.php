<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP SIM-LAB</title>
</head>
<body style="font-family: 'Courier New', Courier, Arial, sans-serif; background-color: #02040a; margin: 0; padding: 40px 20px; line-height: 1.6;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #02040a;">
        <tr>
            <td align="center">
                <div style="max-width: 500px; margin: 0 auto; background-color: #0a1016; border-top: 4px solid #00d9ff; border-bottom: 4px solid #9333ea; padding: 40px 30px; text-align: center;">
                    
                    <h2 style="margin: 0 0 5px 0; font-size: 24px; font-weight: 900; letter-spacing: 2px; color: #ffffff; text-transform: uppercase;">
                        <span style="color: #00d9ff;">System</span> Notification
                    </h2>
                    <p style="margin: 0 0 30px 0; font-size: 11px; font-weight: bold; letter-spacing: 3px; color: #94a3b8; text-transform: uppercase;">
                        AUTHENTICATION REQUIRED
                    </p>

                    <p style="color: #94a3b8; font-size: 13px; font-family: Arial, sans-serif;">
                        A request to authenticate your account has been received. Please use the following <strong>Authorization Code</strong> to complete your verification sequence.
                    </p>

                    <table border="0" cellspacing="0" cellpadding="0" style="margin: 30px auto;">
                        <tr>
                            <td align="center" style="background-color: #05080f; border: 2px solid #00d9ff; border-radius: 8px; padding: 20px 30px;">
                                <div style="font-size: 32px; font-weight: bold; letter-spacing: 12px; color: #00d9ff; margin-right: -12px;">
                                    {{ $otp }}
                                </div>
                            </td>
                        </tr>
                    </table>

                    <p style="color: #ef4444; font-size: 11px; font-weight: bold; letter-spacing: 2px; margin-top: 25px;">
                        ⚠️ CODE EXPIRES IN 90 SECONDS
                    </p>

                    <hr style="border: none; border-top: 1px solid #1e293b; margin: 30px 0;">
                    
                    <p style="font-size: 10px; color: #64748b; letter-spacing: 1px; font-family: Arial, sans-serif; text-transform: uppercase;">
                        &copy; {{ date('Y') }} SIM-LAB UNESA.<br>If you did not request this code, please immediately ignore this transmission.
                    </p>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
