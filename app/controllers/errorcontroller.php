<?php
class ErrorController
{
    public function notFound()
    {
        require_once 'app/views/errors/404.php';
    }
}