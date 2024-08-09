@php
    use App\Helpers\Providers;
@endphp
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <title> {{ $subject }} </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css">
        #outlook a {
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        p {
            display: block;
            margin: 13px 0;
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet" type="text/css" />
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Lato:300,400,700);
    </style>
    <!--<![endif]-->
    <style type="text/css">
        @media only screen and (min-width:480px) {
            .mj-column-per-100 {
                width: 100% !important;
                max-width: 100%;
            }
        }
    </style>
    <style type="text/css">
        @media only screen and (max-width:480px) {
            table.mj-full-width-mobile {
                width: 100% !important;
            }

            td.mj-full-width-mobile {
                width: auto !important;
            }
        }
    </style>
    <style type="text/css">
        a,
        span,
        td,
        th {
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
        }
    </style>
</head>

<body style="background-color:#ffffff;" data-new-gr-c-s-check-loaded="14.1167.0" data-gr-ext-installed="">
    <div
        style="display:none;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">
        {{ str(collect($lines)->filter(fn($l) => is_string($l))->join(' '))->limit(100) ?: $subject }} </div>
    <div style="background-color:#ffffff;">
        <div style="margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="width:100%;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    style="vertical-align:top;" width="100%">
                                    <tbody>
                                        <tr>
                                            <td align="left"
                                                style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                <table border="0" cellpadding="0" cellspacing="0"
                                                    role="presentation"
                                                    style="border-collapse:collapse;border-spacing:0px;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:100px;"> <img alt="Logo" height="auto"
                                                                    src="{{ asset('logo.png') }}?v=2"
                                                                    style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;"
                                                                    width="100" /> </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:0px;word-break:break-word;">
                                                <div style="height:20px;">   </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="font-size:0px;padding:0;word-break:break-word;">
                                                <table border="0" cellpadding="0" cellspacing="0"
                                                    role="presentation"
                                                    style="border-collapse:collapse;border-spacing:0px;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:600px;">
                                                                <a href="https://app.5minutes.ng" target="_blank"
                                                                    style="color: #2e58ff; text-decoration: none;"> <img
                                                                        alt="image description" height="200"
                                                                        src="{{ $banner ?? asset('hero.jpg') }}?v=2"
                                                                        style="border:0;display:block;outline:none;text-decoration:none;height:200px;width:100%;font-size:13px;object-fit:cover;"
                                                                        width="auto" /> </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="width:100%;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    style="vertical-align:top;" width="100%">
                                    <tbody>
                                        <tr>
                                            <td align="center"
                                                style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                <div
                                                    style="font-family:Lato,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:24px;font-weight:700;line-height:32px;text-align:center;color:#434245;">
                                                    <h1
                                                        style="margin: 0; font-size: 24px; line-height: normal; font-weight: bold;">
                                                        {{ $subject }}
                                                    </h1>
                                                </div>
                                            </td>
                                        </tr>
                                        @foreach ($lines as $line)
                                            @if (is_string($line))
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                        <div
                                                            style="font-family:Lato,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:18px;font-weight:400;line-height:24px;text-align:left;color:#434245;">
                                                            {!! str($line)->replace('<a ', '<a style="color: #ff8800; text-decoration: none"') !!}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @elseif (is_array($line) && isset($line['link']))
                                                <tr>
                                                    <td align="center" vertical-align="middle"
                                                        style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            role="presentation"
                                                            style="border-collapse:separate;line-height:100%;">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" bgcolor="#2e58ff"
                                                                        role="presentation"
                                                                        style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px;background:#ff8800;"
                                                                        valign="middle">
                                                                        <a href="{{ $line['link'] }}"
                                                                            style="display: inline-block; background: #ff8800; color: white; font-family: Lato,'Helvetica Neue ',Helvetica,Arial,sans-serif; font-size: 14px; font-weight: bold; line-height: 40px; margin: 0; text-decoration: none; text-transform: uppercase; padding: 10px 25px; mso-padding-alt: 0px; border-radius: 3px;"
                                                                            target="_blank"> {{ $line['title'] }}
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            @else
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
            style="background:#fafafa;background-color:#fafafa;width:100%;">
            <tbody>
                <tr>
                    <td>
                        <div style="margin:0px auto;max-width:600px;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                                            <div style="margin:0px auto;max-width:600px;">
                                                <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                    role="presentation" style="width:100%;">
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                                                                <div class="mj-column-per-100 mj-outlook-group-fix"
                                                                    style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                                                    <table border="0" cellpadding="0"
                                                                        cellspacing="0" role="presentation"
                                                                        style="vertical-align:top;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center"
                                                                                    style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                                                    <table align="center"
                                                                                        border="0" cellpadding="0"
                                                                                        cellspacing="0"
                                                                                        role="presentation"
                                                                                        style="float:none;display:inline-table;">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td
                                                                                                    style="padding:4px;">
                                                                                                    <table
                                                                                                        border="0"
                                                                                                        cellpadding="0"
                                                                                                        cellspacing="0"
                                                                                                        role="presentation"
                                                                                                        style="border-radius:3px;width:32px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td
                                                                                                                    style="font-size:0;height:32px;vertical-align:middle;width:32px;">
                                                                                                                    <a href="https://twitter.com/greyhobb"
                                                                                                                        target="_blank"
                                                                                                                        style="color: #2e58ff; text-decoration: none;">
                                                                                                                        <img alt="twitter-logo"
                                                                                                                            height="32"
                                                                                                                            src="https://codedmails.com/images/social/color/twitter-logo-transparent.png"
                                                                                                                            style="border-radius:3px;display:block;"
                                                                                                                            width="32" />
                                                                                                                    </a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    <table align="center"
                                                                                        border="0" cellpadding="0"
                                                                                        cellspacing="0"
                                                                                        role="presentation"
                                                                                        style="float:none;display:inline-table;">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td
                                                                                                    style="padding:4px;">
                                                                                                    <table
                                                                                                        border="0"
                                                                                                        cellpadding="0"
                                                                                                        cellspacing="0"
                                                                                                        role="presentation"
                                                                                                        style="border-radius:3px;width:32px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td
                                                                                                                    style="font-size:0;height:32px;vertical-align:middle;width:32px;">
                                                                                                                    <a href="https://web.facebook.com/greysoftng"
                                                                                                                        target="_blank"
                                                                                                                        style="color: #2e58ff; text-decoration: none;">
                                                                                                                        <img alt="facebook-logo"
                                                                                                                            height="32"
                                                                                                                            src="https://codedmails.com/images/social/color/facebook-logo-transparent.png"
                                                                                                                            style="border-radius:3px;display:block;"
                                                                                                                            width="32" />
                                                                                                                    </a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    <table align="center"
                                                                                        border="0" cellpadding="0"
                                                                                        cellspacing="0"
                                                                                        role="presentation"
                                                                                        style="float:none;display:inline-table;">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td
                                                                                                    style="padding:4px;">
                                                                                                    <table
                                                                                                        border="0"
                                                                                                        cellpadding="0"
                                                                                                        cellspacing="0"
                                                                                                        role="presentation"
                                                                                                        style="border-radius:3px;width:32px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td
                                                                                                                    style="font-size:0;height:32px;vertical-align:middle;width:32px;">
                                                                                                                    <a href="https://www.instagram.com/greyhobb/"
                                                                                                                        target="_blank"
                                                                                                                        style="color: #2e58ff; text-decoration: none;">
                                                                                                                        <img alt="instagram-logo"
                                                                                                                            height="32"
                                                                                                                            src="https://codedmails.com/images/social/color/insta-logo-transparent.png"
                                                                                                                            style="border-radius:3px;display:block;"
                                                                                                                            width="32" />
                                                                                                                    </a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    <table align="center"
                                                                                        border="0" cellpadding="0"
                                                                                        cellspacing="0"
                                                                                        role="presentation"
                                                                                        style="float:none;display:inline-table;">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td
                                                                                                    style="padding:4px;">
                                                                                                    <table
                                                                                                        border="0"
                                                                                                        cellpadding="0"
                                                                                                        cellspacing="0"
                                                                                                        role="presentation"
                                                                                                        style="border-radius:3px;width:32px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td
                                                                                                                    style="font-size:0;height:32px;vertical-align:middle;width:32px;">
                                                                                                                    <a href="https://youtube.com/@greysoftTechnologies"
                                                                                                                        target="_blank"
                                                                                                                        style="color: #2e58ff; text-decoration: none;">
                                                                                                                        <img alt="youtube-logo"
                                                                                                                            height="32"
                                                                                                                            src="https://codedmails.com/images/social/color/youtube-logo-transparent.png"
                                                                                                                            style="border-radius:3px;display:block;"
                                                                                                                            width="32" />
                                                                                                                    </a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left"
                                                                                    style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                                                    <div
                                                                                        style="font-family:Lato,'Helvetica Neue ',Helvetica,Arial,sans-serif;font-size:18px;font-weight:400;line-height:24px;text-align:center;color:#434245;">
                                                                                        You are recieving this message
                                                                                        because you are registered on
                                                                                        {{ Providers::config('site_name') }}.
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="center"
                                                                                    style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                                                    <div
                                                                                        style="font-family:Lato,'Helvetica Neue ',Helvetica,Arial,sans-serif;font-size:15px;font-weight:400;line-height:20px;text-align:center;color:#bfbfbf;">
                                                                                        ©{{ now()->format('Y') }}
                                                                                        Greysoft Technologies
                                                                                        Limited., All Rights
                                                                                        Reserved.</div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td
                                                                                    style="font-size:0px;word-break:break-word;">
                                                                                    <div style="height:20px;">   </div>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
