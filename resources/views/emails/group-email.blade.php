<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <title>{{ $subject ?? 'Email' }}</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        /* Reset styles */
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            outline: none;
            text-decoration: none;
        }
        
        /* Email-safe fonts */
        body {
            margin: 0;
            padding: 0;
            width: 100% !important;
            height: 100% !important;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
        }
        
        /* Container */
        .email-wrapper {
            width: 100%;
            background-color: #f4f4f4;
            padding: 20px 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            text-align: center;
        }
        
        .email-header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 24px;
            font-weight: 600;
        }
        
        /* Content */
        .email-content {
            padding: 30px 20px;
        }
        
        .email-greeting {
            font-size: 16px;
            color: #333333;
            margin-bottom: 20px;
        }
        
        .email-body {
            font-size: 16px;
            color: #333333;
            line-height: 1.8;
        }
        
        .email-body h1, .email-body h2, .email-body h3 {
            color: #1a1a1a;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        
        .email-body h1 { font-size: 28px; }
        .email-body h2 { font-size: 24px; }
        .email-body h3 { font-size: 20px; }
        
        .email-body p {
            margin: 0 0 15px 0;
        }
        
        .email-body ul, .email-body ol {
            margin: 15px 0;
            padding-left: 30px;
        }
        
        .email-body a {
            color: #667eea;
            text-decoration: underline;
        }
        
        .email-body blockquote {
            border-left: 4px solid #667eea;
            padding-left: 15px;
            margin: 20px 0;
            color: #666666;
            font-style: italic;
        }
        
        .email-body img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 20px auto;
        }
        
        /* Footer */
        .email-footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .email-footer p {
            margin: 5px 0;
            font-size: 12px;
            color: #6b7280;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }
            .email-content {
                padding: 20px 15px !important;
            }
            .email-header {
                padding: 20px 15px !important;
            }
            .email-header h1 {
                font-size: 20px !important;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td align="center" style="padding: 20px 0;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container" style="max-width: 600px; width: 100%;">
                        <!-- Header -->
                        <!-- <tr>
                            <td class="email-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 20px; text-align: center;">
                                <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 600;">{{ $subject ?? 'Email' }}</h1>
                            </td>
                        </tr> -->
                        
                        <!-- Content -->
                        <tr>
                            <td class="email-content" style="padding: 30px 20px; background-color: #ffffff;">
                                <div class="email-greeting" style="font-size: 16px; color: #333333; margin-bottom: 20px;">
                                    @if($recipientName)
                                        Hello {{ $recipientName }},
                                    @else
                                        Hello,
                                    @endif
                                </div>
                                
                                <div class="email-body" style="font-size: 16px; color: #333333; line-height: 1.8;">
                                    {!! $body !!}
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td class="email-footer" style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
                                <p style="margin: 5px 0; font-size: 12px; color: #6b7280;">
                                    This email was sent to you as a member of a mailing list group.
                                </p>
                                <p style="margin: 5px 0; font-size: 12px; color: #6b7280;">
                                    NNK Sacco Limited
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
