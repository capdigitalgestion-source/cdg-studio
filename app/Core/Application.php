<?php

declare(strict_types=1);

namespace CDGStudio\Core;

/**
 * Application principale de CDG Studio.
 *
 * Cette classe représente le point d'entrée du noyau de l'application.
 * À terme, elle sera responsable de :
 * - charger les services ;
 * - enregistrer les modules ;
 * - démarrer le plugin.
 */
final class Application
{
    /**
     * Version du noyau.
     */
    public const VERSION = '1.0.0';

    /**
     * Démarre l'application.
     */
    public function boot(): void
    {
        // Le démarrage du plugin sera progressivement déplacé ici.
    }

    /**
     * Retourne la version du Core.
     */
    public function version(): string
    {
        return self::VERSION;
    }
}