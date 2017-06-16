# Système de badge

- Ajouter le comportement bageable au model user `use Badgeable;`
- Créer une migration qui étend de `BadgeMigration`
- Ajouter le subscriber dans `EventServiceProvider` : 
```php
 protected $subscribe = [
    BadgeSubscriber::class
 ];
```