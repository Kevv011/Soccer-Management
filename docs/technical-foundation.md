# Soccer Management - Documentacion Tecnica Base

## 1. Proposito del documento

Este documento establece la base tecnica inicial del proyecto `soccer-management`, con el objetivo de servir como referencia viva para:

- El contexto funcional del sistema.
- La arquitectura base del proyecto.
- El analisis del modelo de datos propuesto.
- Las decisiones tecnicas iniciales.
- Las debilidades y riesgos detectados.
- Los criterios de calidad y trazabilidad alineados a enfoques ISO.

Este archivo debera mantenerse actualizado conforme evolucione el sistema.

## 2. Contexto del proyecto

El proyecto consiste en una aplicacion administrativa desarrollada con Laravel 13 y Filament v4 para gestionar informacion de Federaciones de Futbol.

El sistema debe ser generico y adaptable a multiples federaciones de distintos paises. La estructura funcional inicial contempla:

- Federaciones.
- Equipos pertenecientes a una federacion.
- Jugadores pertenecientes a un equipo.

La necesidad principal es registrar esta informacion mediante formularios, almacenarla en base de datos y asegurar una buena experiencia de usuario, integridad de datos, trazabilidad y mantenibilidad.

## 3. Requerimiento funcional base

El problema planteado define las siguientes entidades y relaciones:

### 3.1 Federacion

Una federacion debe almacenar:

- ID
- Nombre
- Fecha de fundacion
- Direccion
  - Departamento
  - Municipio
  - Complemento

### 3.2 Equipo

Un equipo debe almacenar:

- ID
- Nombre

### 3.3 Jugador

Un jugador debe almacenar:

- ID
- Nombre
- Fecha de nacimiento
- Genero

### 3.4 Reglas del dominio

- Una federacion tiene muchos equipos.
- Un equipo pertenece a una sola federacion.
- Un equipo tiene muchos jugadores.
- Un jugador solo puede pertenecer a un equipo.

## 4. Stack tecnico actual confirmado

Segun el estado real del repositorio, el proyecto actualmente utiliza:

- PHP 8.3 en `composer.json` del proyecto actual.
- Laravel Framework 13.
- Filament 4.
- Laravel MCP.
- Laravel Boost.
- Laravel Sail.
- PHPUnit 12.
- Tailwind CSS 4.
- Spatie Laravel Permission.
- Spatie Laravel Activitylog.
- Spatie Laravel Medialibrary.
- Spatie Laravel Query Builder.
- Barryvdh DomPDF.

## 5. Estado actual del repositorio

Al momento de este analisis, el proyecto aun no tiene implementadas las entidades del dominio futbolistico.

### 5.1 Implementado actualmente

- Autenticacion base de usuarios.
- Panel administrativo Filament.
- Migraciones base de Laravel.
- Migraciones de permisos y roles.
- Migracion de media library.
- Migracion de activity log.

### 5.2 No implementado aun

- Resources de Filament del dominio.
- Validaciones funcionales del dominio.
- Politicas de acceso del dominio.
- Tests del dominio.

### 5.3 Implementado en la fase inicial del dominio

- Modelos del dominio:
  - Country
  - Subdivision
  - Federation
  - Team
  - Player
- Enum de dominio:
  - PlayerGender
- ApiResources del dominio.
- Migraciones del dominio funcional.
- Factories del dominio.
- Seeder base del dominio:
  - SoccerManagementSeeder
- Integracion base de paquetes transversales:
  - Spatie Laravel Permission
  - Spatie Laravel Media Library
  - Spatie Activity Log

### 5.4 Configuracion base transversal ya adoptada

- `User` usa roles y permisos con Spatie Laravel Permission.
- El acceso a Filament queda orientado a `panel.access`.
- Se registraron aliases de middleware:
  - `role`
  - `permission`
  - `role_or_permission`
- Se definio `Super Admin` como bypass autorizado via `Gate::before`.
- Se publico configuracion de Media Library en `config/media-library.php`.
- Se definieron colecciones iniciales de media:
  - `avatar` en `User`
  - `logo` en `Federation`
  - `crest` en `Team`
- Se definio trazabilidad base con Activity Log para:
  - `User`
  - `Federation`
  - `Team`
  - `Player`

### 5.5 Decision de arquitectura vigente

Aunque existe una base inicial de `ApiResources`, la etapa actual del proyecto no se orientara a una API.

La prioridad de implementacion queda definida asi:

- modelos y dominio,
- permisos y trazabilidad,
- modulos administrativos en Filament v4.

Por tanto, la siguiente capa funcional del proyecto debe construirse directamente sobre Filament.

## 6. Skills y lineamientos internos del proyecto

La carpeta `.agents/skills` refleja que el proyecto esta orientado a un desarrollo estructurado y con enfoque de calidad.

### 6.1 Skills relevantes detectadas

- `laravel-best-practices`
- `iso-skill-development`
- `laravel-permission-development`
- `laravel-query-builder`
- `mcp-development`
- `medialibrary-development`
- `tailwindcss-development`

### 6.2 Implicaciones de estas skills

Estas skills indican que el proyecto esta pensado para:

- Seguir buenas practicas de Laravel.
- Mantener consistencia arquitectonica.
- Priorizar validacion, seguridad y testeo.
- Permitir trazabilidad y auditoria.
- Mantener documentacion tecnica y evolucion controlada.
- Alinearse a criterios de calidad cercanos a estandares ISO.

## 7. Analisis del modelo de datos propuesto

Con base en el diagrama proporcionado, el modelo contempla las siguientes tablas:

- `countries`
- `subdivisions`
- `federations`
- `teams`
- `players`
- `users`

### 7.1 Tabla `countries`

Campos observados:

- `id`
- `iso_name`
- `iso`
- `iso3`
- `name`
- `created_at`
- `updated_at`

#### Analisis

Esta tabla fortalece el caracter generico del sistema y permite soportar multiples paises. Es una buena decision de modelado para escalabilidad internacional.

### 7.2 Tabla `subdivisions`

Campos observados:

- `id`
- `code`
- `country_id`
- `name`
- `created_at`
- `updated_at`

#### Analisis

Permite representar divisiones territoriales como departamentos, provincias o estados. Esto es adecuado para mantener flexibilidad entre paises.

Relacion:

- Una subdivision pertenece a un pais.
- Un pais tiene muchas subdivisiones.

### 7.3 Tabla `federations`

Campos observados:

- `id`
- `name`
- `foundation_date`
- `subdivision_id`
- `municipality`
- `address`
- `created_at`
- `updated_at`

#### Analisis

La tabla representa correctamente la entidad principal del dominio. La estructura responde al requerimiento funcional, aunque hay aspectos a mejorar:

- `subdivision_id` resuelve bien el concepto de departamento/provincia/estado.
- `municipality` se encuentra como texto libre.
- `address` parece representar el complemento de direccion, pero el nombre del campo no lo deja totalmente explicito.

Relacion:

- Una federacion pertenece a una subdivision.
- Una federacion tiene muchos equipos.

### 7.4 Tabla `teams`

Campos observados:

- `id`
- `federation_id`
- `name`
- `created_at`
- `updated_at`

#### Analisis

La tabla es simple y responde al requerimiento funcional inicial.

Relacion:

- Un equipo pertenece a una federacion.
- Un equipo tiene muchos jugadores.

### 7.5 Tabla `players`

Campos observados:

- `id`
- `team_id`
- `name`
- `birth_date`
- `gender`
- `created_at`
- `updated_at`

#### Analisis

La tabla refleja bien la relacion requerida. Sin embargo, `gender` como string requiere reglas claras de validacion o un catalogo controlado para evitar inconsistencias.

Relacion:

- Un jugador pertenece a un equipo.

## 8. Evaluacion general del diseno de base de datos

### 8.1 Fortalezas

- El dominio principal esta modelado con relaciones claras.
- La cardinalidad entre entidades esta bien definida.
- La inclusion de `countries` y `subdivisions` hace el sistema mas generico y reusable entre paises.
- La estructura es facil de mapear con Eloquent y Filament.
- El modelo es entendible, mantenible y adecuado para una primera iteracion.

### 8.2 Debilidades detectadas

Estas debilidades deben atenderse para cumplir mejor con criterios de calidad, trazabilidad, mantenibilidad e integridad de datos.

#### 8.2.1 Campos demasiado abiertos

- `municipality` como texto libre puede provocar duplicidad e inconsistencia ortografica.
- `address` es demasiado generico para un sistema documentable y auditable.
- `gender` como `string` permite valores inconsistentes si no se normaliza.

#### 8.2.2 Falta de restricciones de negocio

No se observan en el diagrama restricciones de unicidad de negocio, por ejemplo:

- `countries.iso` unico.
- `countries.iso3` unico.
- `subdivisions.country_id + code` unico.
- `teams.federation_id + name` unico.
- Definir si `federations.name` debe ser unico globalmente o por pais.

#### 8.2.3 Trazabilidad limitada en entidades del dominio

Para una implementacion alineada con calidad y auditoria, aun no se contempla claramente:

- Quien creo un registro.
- Quien actualizo un registro.
- Estados de negocio.
- Historial de cambios a nivel de dominio.

Nota: el proyecto ya incluye `spatie/laravel-activitylog`, lo cual ayuda a resolver auditoria, pero debe integrarse formalmente al dominio.

#### 8.2.4 Ambiguedad semantica en direccion

El requerimiento habla de:

- Departamento
- Municipio
- Complemento

El modelo actual usa:

- `subdivision_id`
- `municipality`
- `address`

Esto funciona, pero seria mejor hacer explicita la intencion de `address`, por ejemplo:

- `address_complement`
- `address_line`
- `address_details`

#### 8.2.5 Ausencia de catalogos controlados

Aun no se define si ciertos valores deben estar normalizados mediante:

- Enums
- Catalogos
- Tablas parametrizables

Esto aplica especialmente a:

- Genero
- Posibles estados de federacion
- Posibles estados de equipo
- Tipos de subdivision si en el futuro se requiere mayor precision

## 9. Riesgos tecnicos y funcionales iniciales

### 9.1 Riesgo de inconsistencias de datos

Si no se normalizan ciertos campos desde el inicio, el sistema puede acumular datos inconsistentes que luego dificulten reportes, filtros y validaciones.

### 9.2 Riesgo de redisenos tempranos

Si se implementan migraciones sin definir unicidades, enums, auditoria y nomenclatura clara, sera necesario crear migraciones correctivas rapidamente.

### 9.3 Riesgo de ambiguedad documental

Sin una nomenclatura explicita en DB y codigo, la documentacion tecnica y funcional puede divergir del modelo real.

### 9.4 Riesgo de insuficiencia para auditoria

Si la auditoria no se define desde el inicio, costara mas alinear el sistema con criterios de calidad, seguridad y trazabilidad.

## 10. Consideraciones ISO aplicadas al proyecto

Con base en la skill `iso-skill-development`, el proyecto debe considerar al menos estas dimensiones:

### 10.1 ISO/IEC 25010 - Calidad del producto

Debe buscarse:

- Mantenibilidad.
- Fiabilidad.
- Seguridad.
- Usabilidad.
- Compatibilidad.

Aplicacion practica al proyecto:

- Validaciones fuertes.
- Nombres consistentes.
- Bajo acoplamiento.
- Integridad de datos.
- UI administrativa clara y usable.

### 10.2 ISO/IEC 12207 - Ciclo de vida

Debe mantenerse:

- Gestion de requerimientos.
- Control de cambios.
- Documentacion evolutiva.
- Ramas y revisiones ordenadas.

### 10.3 ISO/IEC/IEEE 29119 - Testing

Debe planificarse:

- Tests unitarios.
- Tests feature.
- Casos de validacion.
- Casos de integridad relacional.

### 10.4 ISO/IEC 27001 - Seguridad

Debe contemplarse:

- Autenticacion.
- Roles y permisos.
- Control de acceso al panel.
- Validacion de entradas.
- Auditoria.

### 10.5 ISO/IEC 15504 - Mejora continua

Debe existir una practica continua de:

- Revision tecnica.
- Correccion incremental.
- Medicion de calidad.
- Actualizacion de documentacion.

## 11. Decision tecnica inicial recomendada

Con base en el analisis actual, se recomienda:

### 11.1 Mantener el modelo base del dominio

La estructura principal del diagrama es correcta y puede servir como base:

- `countries`
- `subdivisions`
- `federations`
- `teams`
- `players`

### 11.2 Refinar el modelo antes de implementar migraciones del dominio

Antes de crear las migraciones funcionales del dominio, se recomienda definir:

- Restricciones unicas.
- Longitudes maximas de campos.
- Reglas de borrado y cascada.
- Estrategia de auditoria.
- Estrategia de estados.
- Estrategia de enums o catalogos.
- Nombres finales de campos de direccion.

### 11.3 Integrar trazabilidad desde el inicio

Debe aprovecharse la existencia de:

- `spatie/laravel-activitylog`
- `spatie/laravel-permission`

Para que las entidades de negocio queden auditables y con control de acceso claro.

## 12. Observacion importante sobre permisos y semantica de "teams"

El proyecto ya incluye `spatie/laravel-permission`, y ese paquete usa el termino tecnico `teams` como una caracteristica opcional de segmentacion de permisos.

En el estado actual:

- La opcion `teams` del paquete esta desactivada.
- No existe conflicto tecnico inmediato con la tabla de equipos de futbol.

Sin embargo, debe mantenerse claridad semantica en:

- Documentacion.
- Variables.
- Codigo de autorizacion.
- Discusiones funcionales.

Para evitar confusion entre:

- `teams` del dominio futbolistico.
- `teams` del paquete de permisos.

## 13. Recomendaciones inmediatas para la siguiente fase

Antes de empezar implementacion del dominio, se recomienda documentar y decidir formalmente:

1. Nombre definitivo de cada entidad y campo.
2. Reglas de validacion por entidad.
3. Restricciones de unicidad.
4. Estrategia de auditoria y logging.
5. Estrategia de roles y permisos del panel.
6. Estrategia de testing funcional.
7. Convenciones de documentacion y actualizacion de este archivo.

## 14. Pendientes documentales abiertos

Este documento debera ampliarse con el tiempo para incluir:

- Modelo relacional final aprobado.
- Diccionario de datos.
- Reglas de negocio detalladas.
- Politicas de seguridad.
- Matriz de roles y permisos.
- Estrategia de testing.
- Arquitectura de Filament Resources.
- Flujos operativos del panel administrativo.
- Cambios relevantes por iteracion.

## 15. Conclusion

El proyecto tiene una base funcional y tecnologica adecuada para construir un sistema administrativo de federaciones de futbol. El diagrama propuesto resuelve correctamente el nucleo del dominio y aporta escalabilidad internacional al incluir paises y subdivisiones.

No obstante, antes de implementar el dominio en codigo, es importante fortalecer el diseno de datos en aspectos de:

- Integridad.
- Nomenclatura.
- Trazabilidad.
- Auditoria.
- Restricciones de negocio.
- Calidad documental.

Este documento queda establecido como referencia tecnica inicial y debera mantenerse actualizado durante toda la evolucion del proyecto.
