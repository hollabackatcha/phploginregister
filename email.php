<?php
function sendEmail(string $subject, string $message, string $to)
{
    try {
        mail($to, $subject, $message);
        return TRUE;
    } catch (Exception $e) {
        return FALSE;
    }
}
