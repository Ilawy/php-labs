<?php

function generateSecurityCode()
{
    $code = substr(md5(uniqid(rand(), true)), 0, 6);
    $_SESSION['security_code'] = ($code);
    return $code;
}

function validateSecurityCode($code)
{
    $session_code = isset($_SESSION['security_code']) ? $_SESSION['security_code'] : "";
    return $code == $session_code;
}
