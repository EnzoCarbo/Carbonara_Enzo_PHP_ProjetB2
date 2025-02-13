<?php

namespace App;

class Redirect {
    /**
     * Redirige vers une URL spécifiée
     *
     * @param string $url L'URL vers laquelle rediriger
     */
    public static function to(string $url) {
        header("Location: $url");
        exit();
    }
}