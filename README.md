# Soccer Management

Plataforma administrativa desarrollada con Laravel y Filament para la gestión de federaciones de fútbol, equipos, jugadores y procesos de reportería. El sistema está diseñado para ser reutilizable entre distintas federaciones y mantener trazabilidad, control de acceso y soporte documental.

## Propósito

La plataforma permite:

- administrar federaciones, equipos y jugadores,
- gestionar catálogos geográficos por país,
- controlar acceso mediante roles y permisos,
- auditar acciones relevantes del sistema,
- generar reportes PDF y registrar su historial de generación.

## Stack técnico

- PHP 8.3
- Laravel 13
- Filament 4
- MySQL
- Laravel Sail
- PHPUnit 12
- Tailwind CSS 4
- DomPDF
- Spatie Laravel Permission
- Spatie Laravel Media Library
- Spatie Laravel Activitylog

## Base de datos

El proyecto utiliza MySQL como motor principal. La configuración local por defecto se encuentra en `.env` y el entorno de desarrollo está preparado para ejecutarse mediante Laravel Sail.

Entidades principales del dominio:

- `countries`
- `subdivisions`
- `federations`
- `teams`
- `players`
- `users`
- `report_generations`

## Levantar el proyecto con Sail

1. Instalar dependencias PHP:

```bash
composer install
```

2. Crear archivo de entorno si aún no existe:

```bash
cp .env.example .env
```

3. Levantar contenedores:

```bash
vendor/bin/sail up -d
```

4. Generar la clave de la aplicación:

```bash
vendor/bin/sail artisan key:generate
```

5. Ejecutar migraciones:

```bash
vendor/bin/sail artisan migrate
```

6. Sembrar roles, permisos y usuario administrador:

```bash
vendor/bin/sail artisan db:seed --class=RolesAndPermissionsSeeder
vendor/bin/sail artisan db:seed --class=DatabaseSeeder
```

7. Crear el enlace público para archivos:

```bash
vendor/bin/sail artisan storage:link
```

8. Instalar dependencias frontend y compilar assets:

```bash
vendor/bin/sail npm install
vendor/bin/sail npm run dev
```

9. Ejecutar el worker de cola para reportería y procesos en segundo plano:

```bash
vendor/bin/sail artisan queue:work
```

## Carga inicial recomendada

Para poblar catálogos geográficos:

```bash
vendor/bin/sail artisan geography:import
```

Para poblar datos demo del dominio:

```bash
vendor/bin/sail artisan db:seed --class=FederationTeamPlayerSeeder
```

## Acceso local

- Panel administrativo: `http://localhost/admin`
- Usuario inicial: `admin@admin.com`
- Contraseña inicial: `password`

## Documentación técnica

La documentación detallada del proyecto se mantiene en `docs/`:

- [Technical Foundation](docs/technical-foundation.md)
- [Data Dictionary](docs/data-dictionary.md)
- [Implementation Roadmap](docs/implementation-roadmap.md)
- [Pre-Development Decisions](docs/pre-development-decisions.md)
- [Filament v4 Guidelines](docs/filament-v4-guidelines.md)
- [Filament Resource Blueprint](docs/filament-resource-blueprint.md)

## Consideraciones operativas

- El sistema usa colas para generación de reportes en segundo plano.
- Las notificaciones de reportes se entregan como database notifications en Filament.
- El historial de reportes generados queda auditado en `report_generations`.
- El desarrollo sigue lineamientos de calidad, seguridad y trazabilidad alineados al enfoque ISO documentado en el proyecto.
