<?php
    function mailDesignTemplate($title, $message, $footer){
    if(!empty(trim(strip_tags($title)))){
        $mail_title = trim(strip_tags($title));
    }else{
        $mail_title = "No Title";
    }
    $mail_message = str_replace("\n", "<br/>", trim(strip_tags($message)));
    if(!empty(trim(strip_tags($footer)))){
        $mail_footer = trim(strip_tags($footer));
    }else{
        $mail_footer = $_SERVER["HTTP_HOST"]." &copy; ".date("Y");
    }
    return 
        '<!DOCTYPE html>
            <head>
                <title>'.$mail_title.'</title>
                <meta charset="UTF-8" />
                <meta name="description" content="" />
                <meta http-equiv="Content-Type" content="text/html; " />
                <meta name="theme-color" content="#5840bb" />
                <meta name="viewport" content="width=device-width, initial-scale=1"/>
                <style>
                    html, body{
                        margin: 0;
                        width: 100%;
                        height: 100%;
                    }

                    .mail-header{
                        display: block;
                        width: 96%;
                        min-height: 3%;
                        max-height: auto;
                        background-color: #5840bb;
                        margin: 0;
                        padding: 1.5% 2% 1.5% 2%;
                    }

                    .mail-title{
                        font-size: 18px;
                        color: #f5f5f5;
                        text-transform: uppercase;
                    }

                    .mail-content{
                        display: block;
                        width: 96%;
                        min-height: 86%;
                        max-height: auto;
                        background-color: whitesmoke;
                        margin: 0;
                        padding: 1.5% 2% 1.5% 2%;
                        white-space: pre-wrap;
                    }

                    .mail-message{
                        font-size: 16px;
                        color: #5c5b5b;
                        text-transform: initial;
                    }

                    .mail-footer{
                        display: block;
                        width: 96%;
                        min-height: 2%;
                        max-height: auto;
                        background-color: #5840bb;
                        margin: 0;
                        padding: 1.5% 2% 1.5% 2%;
                        text-align: center;
                    }

                    .mail-footer-text{
                        font-size: 18px;
                        color: #f5f5f5;
                        text-transform: capitalize;
                    }

                    .mail-footer-text a{
                        color: #f5f5f5 !important;
                    }
                </style>
            </head>
            <body>
                <div class="mail-header">
                    <span class="mail-title">'.$mail_title.'</span>
                </div>

                <div class="mail-content"><span class="mail-message">'.$mail_message.'</span></div>

                <div class="mail-footer">
                    <span class="mail-footer-text">'.$mail_footer.'</span>
                </div>
            </body>
        </html>';
    }
?>