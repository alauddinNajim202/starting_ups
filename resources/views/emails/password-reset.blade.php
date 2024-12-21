<!DOCTYPE html>
<html>

<head>
    <title>Password Reset</title>
</head>

<body>
    <tr>
        <td align="left" valign="center">
    <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px">

        <!--begin:Email content-->
        <div style="padding-bottom: 30px; font-size: 17px;">
            <strong>Hello!</strong>
        </div>

        <div style="padding-bottom: 30px">
            You are receiving this email because we received a password reset request for your account. To
            proceed
            with the password reset please click on the button below:
        </div>

        <div style="padding-bottom: 40px; text-align:center;">
            <a href="{{ url('password/reset/' . $token) }}" rel="noopener"
                target="_blank"
                style="text-decoration:none;display:inline-block;text-align:center;padding:0.75575rem 1.3rem;font-size:0.925rem;line-height:1.5;border-radius:0.35rem;color:#ffffff;background-color:#00A3FF;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle">
                Reset Password
            </a>
        </div>

        <div style="padding-bottom: 30px">
            This password reset link will expire in 60 minutes.
            If you did not request a password reset, no further action is required.
        </div>

        <div style="border-bottom: 1px solid #eeeeee; margin: 15px 0"></div>

        <div style="padding-bottom: 50px; word-wrap: break-all;">
            <p style="margin-bottom: 10px;">
                Button not working? Try pasting this URL into your browser:
            </p>

            {{-- <a href="{{ url('password/reset/' . $token) }}" rel="noopener" target="_blank" style="text-decoration:none;color: #00A3FF"> {{ url('password/reset/' . $token) }} </a> --}}
        </div>
        <!--end:Email content-->

        <div style="padding-bottom: 10px">
            Kind regards,<br>
            The SOKO-ROAM Team.
        </div>
    </div>
</td>

    </tr>
</body>

</html>
