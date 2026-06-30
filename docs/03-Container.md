# 03 – Le Container

## Objectif

Le Container est le registre central des services du Framework.

Il permet :

- d'enregistrer les composants du Framework ;
- de résoudre leurs dépendances ;
- de partager une même instance entre plusieurs composants.

Le Container constitue le point d'accès unique aux services techniques.

---

# Pourquoi un Container ?

Sans Container, chaque classe devrait créer elle-même ses dépendances.

Exemple :

```php
$logger = new Logger();

$config = new ConfigManager();

$cache = new Cache();
```

Cette approche entraîne un fort couplage entre les classes.

Avec le Container :

```php
$logger = $container->get('logger');

$config = $container->get('config');

$cache = $container->get('cache');
```

Les classes ne connaissent plus les implémentations concrètes.

---

# Fonctionnement

Le Container repose sur deux opérations :

## Enregistrement

```php
$container->set(
    'logger',
    fn () => new Logger()
);
```

ou

```php
$container->set(
    'config',
    fn () => new ConfigManager($config)
);
```

---

## Résolution

```php
$logger = $container->get('logger');
```

Si le service existe déjà, la même instance est retournée.

Sinon, le Container l'instancie puis la mémorise.

---

# Cycle de vie

```text
Provider

↓

Container::set()

↓

Container

↓

Container::get()

↓

Service disponible
```

---

# Services enregistrés

Le Framework enregistre notamment :

- app
- config
- logger
- cache
- events
- hooks
- settings
- modules

Cette liste est amenée à évoluer.

---

# Bonnes pratiques

Toujours récupérer les services via le Container.

Ne jamais créer directement un Logger, un Cache ou un ConfigManager dans le code métier.

Utiliser les méthodes fournies par AbstractModule lorsque cela est possible.

Exemple :

```php
$this->logger();

$this->cache();

$this->config();

$this->settings();
```

Ces méthodes améliorent la lisibilité et réduisent le couplage.

---

# Ce qu'il ne faut pas faire

Ne jamais utiliser le Container comme un espace de stockage de données métier.

Le Container ne contient que des services.

Les données métier appartiennent aux modules.

---

# Évolutions prévues

Les prochaines versions pourront introduire :

- des identifiants de services centralisés ;
- l'autowiring de certaines dépendances ;
- une résolution automatique basée sur les types.

Ces évolutions devront rester compatibles avec les principes d'architecture du Framework.

---

# Conclusion

Le Container constitue le cœur de l'injection de dépendances.

Il favorise :

- un faible couplage ;
- une meilleure testabilité ;
- une architecture évolutive ;
- une maintenance simplifiée.

Toutes les nouvelles briques techniques du Framework doivent être enregistrées dans le Container par l'intermédiaire d'un Service Provider.