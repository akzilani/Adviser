<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Regulated Advice</title>
        <style type="text/css">
            @import url(http://fonts.googleapis.com/css?family=Lato:400);
            *{
                font-family: 'Lato', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
                font-size: 17px;
            }

            h3 {color: #21c5ba; font-size: 24px; }
            .mt-5{margin-top: 25px; }
            .mt-3{margin-top: 15px; }
            .mt-2{margin-top: 10px; }
            .pt-2{padding-top: 10px; }
            .mb-2{margin-bottom: 10px; }
            .pb-2{padding-bottom: 10px; }
            .template{background:#eee;}
            .layout{width: 75%; margin: 0px auto;background-color: #fff; padding: 10px 15px;}
            .text-center{text-align: center;}
            .footer{font-size: 12px;}
        </style>

        <style type="text/css" media="screen">
            @media screen {
                td, h1, h2, h3 {
                    font-family: 'Lato', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
                }
            }
        </style>

        
    </head>
    <body class="body template">
        <div class="pb-2 pt-2">
            <h3 class="text-center">  Regulated Advice</h3>
        </div>
        <div class="layout">
            <div class="mt-2 mb-2">
                {!! $mail_message ?? "" !!}
            </div>
        </div>
    </body>
</html>
