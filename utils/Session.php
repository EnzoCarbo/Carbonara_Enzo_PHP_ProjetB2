<?php

namespace App;

class Session {
    /**
     * Démarre la session si elle n'est pas déjà démarrée
     */
    private static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Définit un message flash
     *
     * @param string $type Le type de message (success, error, etc.)
     * @param string $message Le message à afficher
     */
    public static function setFlash(string $type, string $message) {
        self::start();
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    /**
     * Récupère le message flash et le supprime de la session
     *
     * @return array|null Le message flash ou null s'il n'y en a pas
     */
    public static function getFlash(): ?array {
        self::start();
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }

    /**
     * Vérifie si l'utilisateur est administrateur
     *
     * @return bool True si l'utilisateur est administrateur, sinon false
     */
    public static function isAdmin(): bool {
        self::start();
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
}