<?php
if(!function_exists('parse_message')) {
    function parse_message($message)
    {
        global $vbulletin;
        
        if (empty($message)) {
            $error = 'im_error_empty_message';
        }

        // check message length
        if (vbstrlen($message) > $vbulletin->options['im_max_chars']) {
            $error = 'im_error_message_too_long';
        }

        require_once(DIR . '/includes/functions_newpost.php');
        $message = convert_url_to_bbcode($message);

        $message = trim($message);

        // add # to color tags using hex if it's not there
        $message = preg_replace('#\[color=(&quot;|"|\'|)([a-f0-9]{6})\\1]#i', '[color=\1#\2\1]', $message);

        // strip alignment codes that are closed and then immediately reopened
        $message = preg_replace('#\[/(left|center|right)\]([\r\n]*)\[\\1\]#i', '\\2', $message);

        // remove [/list=x remnants
        if (stristr($message, '[/list=') != false) {
            $message = preg_replace('#\[/list=[a-z0-9]+\]#siU', '[/list]', $message);
        }

        if(isset($error)) {
            return array(
                'success' => false,
                'message' => $error
            );
        }

        return array(
            'success' => true,
            'message' => $message
        );
    }
}

if(!function_exists('json_response')) {
    function json_response($message = null, $code = 200)
    {
        header_remove();
        http_response_code($code);

        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header('Content-Type: application/json');

        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );

        header('Status: '.$status[$code]);

        return json_encode(array(
            'status' => $code < 300, // success or not?
            'message' => $message
        ));
    }
}