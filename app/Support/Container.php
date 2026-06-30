<?php

declare(strict_types=1);

namespace CDGStudio\Support;

use InvalidArgumentException;

/**
 * Conteneur de services simple pour CDG Studio.
 */
final class Container
{
    /**
     * Services enregistrés.
     *
     * @var array<string, callable|object>
     */
    private array $bindings = [];

    /**
     * Instances déjà résolues.
     *
     * @var array<string, object>
     */
    private array $instances = [];

    /**
     * Enregistre un service.
     */
    public function set(string $id, callable|object $resolver): void
    {
        $this->bindings[$id] = $resolver;
    }

    /**
     * Récupère un service.
     */
    public function get(string $id): object
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (!isset($this->bindings[$id])) {
            throw new InvalidArgumentException("Service non enregistré : {$id}");
        }

        $resolver = $this->bindings[$id];

        $instance = is_callable($resolver)
            ? $resolver($this)
            : $resolver;

        if (!is_object($instance)) {
            throw new InvalidArgumentException("Le service {$id} doit retourner un objet.");
        }

        $this->instances[$id] = $instance;

        return $instance;
    }

    /**
     * Vérifie si un service est enregistré.
     */
    public function has(string $id): bool
    {
        return isset($this->bindings[$id]);
    }
}