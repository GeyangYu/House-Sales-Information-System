<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>浏览器不再支持 | 浙江省房屋统计系统</title>
    <meta name="robots" content="noindex">
    <meta name="author" content="谢浩哲">
    <!-- Icon -->
    <link href="<?php echo base_url('/favicon.ico'); ?>" rel="shortcut icon" type="image/x-icon">
    <!-- StyleSheets -->
    <style type="text/css">
        body {
            margin: 50px;
            font: 13px arial,sans-serif;
        }

        a {
            color:#0152A6;
            cursor:pointer;
            outline:medium none;
            text-decoration:none;
        }

        a img {
            border: 0;
        }

        h1 {
            font-size: 17px;
        }

        .footer {
            font-size: 13px;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <img src="<?php echo base_url('assets/img/logo.jpg'); ?>" alt="Logo" width="289px" height="50px" />
    <h1><spring:message code="voj.misc.not-supported.browser-not-supported" text="Your Browser is no longer supported." /></h1>
    <p><spring:message code="voj.misc.not-supported.message" text="Verwandlung Online Judge no longer supports your browser. Please upgrade your browser." arguments="${websiteName}" /></p>
    <table width="650px" cellpadding="5">
        <tbody>
            <tr>
                <td align="center" valign="center" width="120px">
                    <a href="http://www.google.com/chrome/">
                        <img src="<?php echo base_url('assets/img/browsers/chrome.jpg'); ?>" width="120px" height="120px" />
                    </a>
                </td>
                <td align="center" valign="center" width="120px">
                    <a href="http://www.mozilla.com/firefox/">
                        <img src="<?php echo base_url('assets/img/browsers/firefox.jpg'); ?>" width="120px" height="120px" />
                    </a>
                </td>
                <td align="center" valign="center" width="120px">
                    <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx">
                        <img src="<?php echo base_url('assets/img/browsers/ie.jpg'); ?>" width="120px" height="120px" />
                    </a>
                </td>
                <td align="center" valign="center" width="120px">
                    <a href="http://www.opera.com/">
                        <img src="<?php echo base_url('assets/img/browsers/opera.jpg'); ?>" width="120px" height="120px" />
                    </a>
                </td>
                <td align="center" valign="center" width="120px">
                    <a href="http://www.apple.com/safari/download/">
                        <img src="<?php echo base_url('assets/img/browsers/safari.jpg'); ?>" width="120px" height="120px" />
                    </a>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top"><a href="http://www.google.com/chrome/">下载 Google Chrome</a></td>
                <td align="center" valign="top"><a href="http://www.mozilla.com/firefox/">下载 Firefox</a></td>
                <td align="center" valign="top"><a href="http://www.microsoft.com/windows/internet-explorer/default.aspx">下载 Internet Explorer</a></td>
                <td align="center" valign="top"><a href="http://www.opera.com/">下载 Opera</a></td>
                <td align="center" valign="top"><a href="http://www.apple.com/safari/download/">下载 Safari</a></td>
            </tr>
        </tbody>
    </table>
   <div class="footer">&copy;<?php echo date('Y'); ?> <a href="http://zjso.stats.gov.cn/" target="_blank">国家统计局浙江调查总队</a></div>
</body>
</html>