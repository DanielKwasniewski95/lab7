<?php
    function getDetails($ip)
    {
        $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
        $details = json_decode($json);
        return $details;
    }