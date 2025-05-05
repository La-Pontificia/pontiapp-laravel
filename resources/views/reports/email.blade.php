<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" lang="en">

<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
    <meta name="x-apple-disable-message-reformatting" />
    <!--$-->
</head>

<body
    style='background-color:#ffffff;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif'>
    <div style="display:none;overflow:hidden;line-height:1px;opacity:0;max-height:0;max-width:0">
        Report message
        <div>
            ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏﻿ ‌​‍‎‏
        </div>
    </div>
    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="max-width:100%;margin:10px auto;width:600px;">
        <tbody>
            <tr style="width:100%">
                <td>
                    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                        role="presentation" style="padding:20px 24px;">
                        <tbody>
                            <tr>
                                <td>
                                    <img 
                                    width="150"
                                    height="40"
                                    alt="La Pontificia"
                                    src="http://res.cloudinary.com/dc0t90ahb/image/upload/v1738211374/pontiapp/qjrx3wnvimjuct523xb2.png">
                                    <hr style="opacity:0.5;">
                                    <h2>
                                        Hola {{ $user->firstNames ?? $user->displayName}},
                                    </h2>
                                    <p style="margin-bottom:18px">
                                        El reporte de {{ $description }} que solicitaste ya está disponible.
                                        Puedes descargarlo directamente desde este correo haciendo clic en "Descargar" o
                                        acceder a él a través del módulo {{ $module }} en Pontiapp.
                                    </p>
                                </td>
                            </tr>
                            <tr style="width:100%">
                                <td data-id="__react-email-column">
                                    <a href={{ $downloadLink }}
                                        style="color:#000;text-decoration-line:none;border:1px solid #929292;font-size:16px;text-decoration:none;padding:10px 0px;width:220px;display:block;text-align:center;font-weight:500;margin-bottom:10px"
                                        target="_blank">
                                        Descargar
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <hr>
                                    <p style="font-size:14px;margin-top:5px;margin-bottom:0; opacity:0.5">
                                        © 2025 La pontificia, Inc. All Rights Reserved.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="font-size:14px;margin-top:5px;margin-bottom:0; opacity:0.5">
                                        {{ now()->format('m/d/Y h:i:s A') }}
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <!--/$-->
</body>

</html>
