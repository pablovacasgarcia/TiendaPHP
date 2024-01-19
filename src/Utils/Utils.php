<?php

namespace Utils;

/**
 * Clase Utils que contiene funciones útiles para la gestión de sesiones y la validación de roles.
 *
 * @package Utils
 */
class Utils
{
    /**
     * Elimina una variable de sesión.
     *
     * @param string $name Nombre de la variable de sesión a eliminar.
     * @return void
     */
    public static function deleteSession(string $name): void
    {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
    }

    /**
     * Verifica si un usuario está logeado. Si no lo está, redirige a la página principal.
     *
     * @return void
     */
    public static function logeado(): void
    {
        if (!isset($_SESSION['login']) || $_SESSION['login'] == "failed") {
            header('Location: ' . BASE_URL);
        }
    }

    /**
     * Verifica si el usuario tiene el rol de administrador. Si no lo tiene, redirige a la página principal.
     *
     * @return void
     */
    public static function admin(): void
    {
        if (!isset($_SESSION['login']) || $_SESSION['login'] == "failed" || $_SESSION['login']->rol != "admin") {
            header('Location: ' . BASE_URL);
        }
    }
}
