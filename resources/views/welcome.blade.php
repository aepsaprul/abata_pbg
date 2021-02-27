<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Styles -->
        <style>
            /* http://meyerweb.com/eric/tools/css/reset/ 
            v2.0 | 20110126
            License: none (public domain)
            */

            html, body, div, span, applet, object, iframe,
            h1, h2, h3, h4, h5, h6, p, blockquote, pre,
            a, abbr, acronym, address, big, cite, code,
            del, dfn, em, img, ins, kbd, q, s, samp,
            small, strike, strong, sub, sup, tt, var,
            b, u, i, center,
            dl, dt, dd, ol, ul, li,
            fieldset, form, label, legend,
            table, caption, tbody, tfoot, thead, tr, th, td,
            article, aside, canvas, details, embed, 
            figure, figcaption, footer, header, hgroup, 
            menu, nav, output, ruby, section, summary,
            time, mark, audio, video {
                margin: 0;
                padding: 0;
                border: 0;
                font-size: 100%;
                font: inherit;
                vertical-align: baseline;
            }
            /* HTML5 display-role reset for older browsers */
            article, aside, details, figcaption, figure, 
            footer, header, hgroup, menu, nav, section {
                display: block;
            }
            body {
                line-height: 1;
            }
            ol, ul {
                list-style: none;
            }
            blockquote, q {
                quotes: none;
            }
            blockquote:before, blockquote:after,
            q:before, q:after {
                content: '';
                content: none;
            }
            table {
                border-collapse: collapse;
                border-spacing: 0;
            }
            /**
            * For modern browsers
            * 1. The space content is one way to avoid an Opera bug when the
            *    contenteditable attribute is included anywhere else in the document.
            *    Otherwise it causes space to appear at the top and bottom of elements
            *    that are clearfixed.
            * 2. The use of `table` rather than `block` is only necessary if using
            *    `:before` to contain the top-margins of child elements.
            */
            .cf:before,
            .cf:after {
                content: " "; /* 1 */
                display: table; /* 2 */
            }

            .cf:after {
                clear: both;
            }

            /**
            * For IE 6/7 only
            * Include this rule to trigger hasLayout and contain floats.
            */
            .cf {
                *zoom: 1;
            }
        </style>

        <style>
            body {
                font-family: 'Nunito';
                background-color: #FFDD00;
            }
            .header {
                width: 100%;
                height: 60px;
                background-color: #176BB3;
            }
            .header .container {
                width: 1300px;
                height: 60px;
                margin: auto;
            }
            .header .container .logo,
            .header .container .nav,
            .header .container .medsos {
                float: left;
            }
            /*  header logo  */
            .header .container .logo {
                width: 250px;
                box-sizing: border-box;
            }
            .header .container .logo img {
                line-height: 60px;
                max-width: 100px;
                padding: 5px;
            }

            /* header nav  */
            .header .container .nav {
                width: 800px;
                box-sizing: border-box;
                text-align: center;
            }
            .header .container .nav a {
                color: #FFDD00;
                text-decoration: none;
                line-height: 60px;
                text-transform: uppercase;
                font-weight: bold;
            }

            /* header medsos  */
            .header .container .medsos {
                width: 250px;
                line-height: 60px;
                padding: 13px;
                box-sizing: border-box;
                text-align: right;
            }
            .header .container .medsos img {
                max-width: 35px;
                padding-left: 10px;
            }
            .content {
                width: 100%;
            }
            .content .container {
                width: 1300px;
                margin: auto;
            }
            .content .container .maskot {
                float: left;
                width: 500px;
                text-align: right;
            }
            .content .container .welcome {
                float: right;
                width: 800px;
                text-align: center;
            }
            .content .container .welcome p {
                padding: 200px 0;
            }
            .content .container .welcome p .satu {
                background-color: #176BB3;
                padding: 10px 20px;
                text-transform: uppercase;
                font-weight: bold;
                font-family: Arial, Helvetica, sans-serif;
                color: #FFF;
                font-size: 1cm;
            }
            .content .container .welcome p .dua {
                font-size: 1cm;
                text-transform: uppercase;
                color: #176BB3;
                font-family: Arial, Helvetica, sans-serif;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div class="container">
                <div class="logo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="logo abata">
                </div>
                <div class="nav">
                    <a href="#">Home</a>
                </div>
                <div class="medsos">
                    <img src="{{ asset('assets/img/youtube.png') }}" alt="youtube">
                    <img src="{{ asset('assets/img/instagram.png') }}" alt="instagram">
                    <img src="{{ asset('assets/img/facebook.png') }}" alt="facebook">
                </div>
            </div>
        </div>
        <div class="content cf">
            <div class="container">
                <div class="maskot">
                    <img src="{{ asset('assets/img/maskot.png') }}" alt="maskot">
                </div>
                <div class="welcome">
                    <p>
                        <span class="satu"> selamat datang </span>
                        <br><br><br>
                        <span class="dua">abata cabang purbalingga</span>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
