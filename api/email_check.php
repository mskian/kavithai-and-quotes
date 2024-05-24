<?php

$disposableEmailDomains = [
    'mailinator.com',
    'tempmail.com',
    '10minutemail.com',
    'example.com',
    'mcatag.com' ,
    'pelagius.net',
    'zlorkun.com',
    'gufum.com'
];

function isDisposableEmail($email, $disposableEmailDomains) {
    $domain = substr(strrchr($email, "@"), 1);
    return in_array($domain, $disposableEmailDomains);
}

function hasValidMX($email) {
    $domain = substr(strrchr($email, "@"), 1);
    return checkdnsrr($domain, 'MX');
}

function checkValidEmail($email, $disposableEmailDomains) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    if (isDisposableEmail($email, $disposableEmailDomains)) {
        return false;
    }

    if (!hasValidMX($email)) {
        return false;
    }

    return true;
}

?>