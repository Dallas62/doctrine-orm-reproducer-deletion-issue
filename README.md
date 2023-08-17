# Reproducer

Create database:

```bash
bin/console doctrine:database:create
bin/console doctrine:schema:update --force --complete
```

Run tests:

```bash
bin/console reproduce
```
