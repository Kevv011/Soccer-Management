# SKILL.md

## Desarrollo de Plataforma con Gestión de Calidad de Software (Laravel + Filament)

------------------------------------------------------------------------

# Propósito

Este documento define las **buenas prácticas, estándares y flujo de
trabajo** para el desarrollo de una plataforma basada en **Laravel +
Filament**, alineada con estándares internacionales de calidad de
software.

El objetivo es garantizar que el sistema sea:

-   Escalable\
-   Seguro\
-   Mantenible\
-   Testeable\
-   Auditable

------------------------------------------------------------------------

# Enfoque basado en estándares ISO

El desarrollo se rige por los siguientes estándares:

-   ISO/IEC 25010 → Modelo de calidad del software\
-   ISO/IEC 12207 → Ciclo de vida del software\
-   ISO/IEC/IEEE 29119 → Testing\
-   ISO/IEC 27001 → Seguridad\
-   ISO/IEC 15504 → Mejora continua

------------------------------------------------------------------------

# Flujo de trabajo por ISO

## ISO/IEC 25010 --- Calidad del Producto

### Propósito

Asegurar que el software cumpla atributos de calidad.

### Flujo de trabajo

1.  Definir requisitos funcionales y no funcionales\
2.  Aplicar arquitectura limpia\
3.  Implementar validaciones estrictas\
4.  Aplicar principios SOLID\
5.  Uso de DTOs\
6.  Implementar logs

### Requerimientos técnicos

-   Código limpio (PSR-12)
-   Análisis estático
-   Logging estructurado
-   Uso de caché

### Resultado esperado

-   Código mantenible\
-   Sistema estable

------------------------------------------------------------------------

## ISO/IEC 12207 --- Ciclo de Vida

### Propósito

Definir cómo se desarrolla el software.

### Flujo de trabajo

1.  Gestión de requerimientos\
2.  Git Flow\
3.  Pull Requests\
4.  CI/CD\
5.  Releases\
6.  Documentación

### Requerimientos técnicos

-   Repositorio Git\
-   Pipeline CI/CD\
-   Migraciones\
-   Seeders

### Resultado esperado

-   Desarrollo organizado\
-   Cambios controlados

------------------------------------------------------------------------

## ISO/IEC/IEEE 29119 --- Testing

### Propósito

Garantizar calidad mediante pruebas.

### Flujo de trabajo

1.  Plan de pruebas\
2.  Casos de prueba\
3.  Tests automatizados\
4.  Ejecución en CI/CD\
5.  Cobertura

### Requerimientos técnicos

-   Tests Unitarios\
-   Tests Feature\
-   Tests API\
-   Faker

### Resultado esperado

-   Código confiable\
-   Menos errores en producción

------------------------------------------------------------------------

## ISO/IEC 27001 --- Seguridad

### Propósito

Proteger información del sistema.

### Flujo de trabajo

1.  Autenticación\
2.  Roles y permisos\
3.  Validación de inputs\
4.  Protección contra ataques\
5.  Auditoría

### Requerimientos técnicos

-   Auth Laravel\
-   Policies\
-   HTTPS\
-   Logs

### Resultado esperado

-   Sistema seguro\
-   Accesos controlados

------------------------------------------------------------------------

## ISO/IEC 15504 --- Mejora Continua

### Propósito

Optimizar el proceso de desarrollo.

### Flujo de trabajo

1.  Medir calidad\
2.  Evaluar cobertura\
3.  Monitorear errores\
4.  Mejorar procesos

### Requerimientos técnicos

-   Métricas\
-   Logs\
-   Code reviews

### Resultado esperado

-   Mejora continua\
-   Mayor madurez del proceso

------------------------------------------------------------------------

# Flujo general del desarrollo

1.  Crear issue\
2.  Crear rama\
3.  Desarrollar\
4.  Testear\
5.  PR\
6.  Code Review\
7.  Merge\
8.  Deploy

------------------------------------------------------------------------

# Resultado esperado

Sistema:

-   Escalable\
-   Seguro\
-   Testeado\
-   Auditable\
-   Profesional

------------------------------------------------------------------------

# Nota final

Este documento traduce estándares ISO a prácticas reales en Laravel.
