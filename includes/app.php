<?php
define('TEMPLATES_URL', 'includes/templates/');

function incluirTemplate(string $nombre)
{
    include TEMPLATES_URL . "$nombre.php";
}