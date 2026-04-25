# Soccer Management - Diccionario de Datos Inicial

## 1. Proposito del documento

Este documento define el diccionario de datos inicial del proyecto `soccer-management` con base en el analisis funcional y el modelo relacional propuesto.

Su objetivo es:

- Formalizar las entidades del sistema.
- Establecer el significado funcional de cada campo.
- Documentar reglas preliminares de integridad.
- Identificar campos que requieren refinamiento antes de implementarse.
- Servir como insumo para migraciones, modelos, validaciones, formularios y pruebas.

Este documento es evolutivo y debera actualizarse en cada cambio relevante del modelo de datos.

## 2. Convenciones de documentacion

Para este diccionario:

- `PK` significa llave primaria.
- `FK` significa llave foranea.
- `NN` significa no nulo.
- `UQ` significa unico.
- `IDX` significa indexado.
- `Pendiente` indica una decision tecnica aun no cerrada.

## 3. Entidades del dominio

Las entidades base del dominio identificadas en la etapa inicial son:

- `countries`
- `subdivisions`
- `federations`
- `teams`
- `players`
- `users`

## 4. Diccionario por tabla

### 4.1 Tabla `countries`

#### Proposito

Almacena el catalogo de paises disponibles para soportar federaciones de distintos paises.

#### Campos

| Campo | Tipo sugerido | Restricciones sugeridas | Descripcion |
| --- | --- | --- | --- |
| `id` | `bigint` | PK, NN | Identificador interno del pais. |
| `iso_name` | `string(100)` | NN | Nombre oficial ISO o nombre tecnico de referencia. |
| `iso` | `string(2)` | NN, UQ, IDX | Codigo ISO alfa-2 del pais. |
| `iso3` | `string(3)` | NN, UQ, IDX | Codigo ISO alfa-3 del pais. |
| `name` | `string(150)` | NN, UQ o IDX | Nombre comun del pais para visualizacion. |
| `created_at` | `timestamp` | nullable segun convencion Laravel | Fecha de creacion del registro. |
| `updated_at` | `timestamp` | nullable segun convencion Laravel | Fecha de actualizacion del registro. |

#### Reglas iniciales recomendadas

- `iso` debe almacenarse en mayusculas.
- `iso3` debe almacenarse en mayusculas.
- El catalogo debe provenir de una fuente consistente y verificable.
- No deberian existir paises duplicados por `iso`, `iso3` o nombre.

#### Riesgos abiertos

- Definir si `name` sera unico o si solo se indexara.
- Definir si `iso_name` es realmente necesario o si duplica informacion con `name`.

### 4.2 Tabla `subdivisions`

#### Proposito

Almacena subdivisiones territoriales por pais, tales como departamentos, estados o provincias.

#### Campos

| Campo | Tipo sugerido | Restricciones sugeridas | Descripcion |
| --- | --- | --- | --- |
| `id` | `bigint` | PK, NN | Identificador interno de la subdivision. |
| `country_id` | `bigint` | FK, NN, IDX | Pais al que pertenece la subdivision. |
| `code` | `string(20)` | NN, IDX | Codigo interno o territorial de la subdivision. |
| `name` | `string(150)` | NN, IDX | Nombre visible de la subdivision. |
| `created_at` | `timestamp` | nullable segun convencion Laravel | Fecha de creacion del registro. |
| `updated_at` | `timestamp` | nullable segun convencion Laravel | Fecha de actualizacion del registro. |

#### Relaciones

- `subdivisions.country_id -> countries.id`

#### Reglas iniciales recomendadas

- Debe existir restriccion unica compuesta `country_id + code`.
- Evaluar si tambien se requiere unicidad compuesta `country_id + name`.
- La eliminacion de un pais con subdivisiones asociadas no debe permitirse sin una estrategia clara.

#### Riesgos abiertos

- Definir si se necesitara un campo `type` para distinguir `department`, `state`, `province`, etc.
- Definir si el municipio tambien debe normalizarse en una tabla futura.

### 4.3 Tabla `federations`

#### Proposito

Representa la entidad principal del negocio: una federacion de futbol.

#### Campos

| Campo | Tipo sugerido | Restricciones sugeridas | Descripcion |
| --- | --- | --- | --- |
| `id` | `bigint` | PK, NN | Identificador interno de la federacion. |
| `name` | `string(200)` | NN, IDX, posible UQ | Nombre oficial de la federacion. |
| `foundation_date` | `date` | NN | Fecha de fundacion. |
| `subdivision_id` | `bigint` | FK, NN, IDX | Subdivision donde se ubica la federacion. |
| `municipality` | `string(150)` | NN | Municipio o localidad. |
| `address_line` | `string(255)` | NN | Complemento o detalle de direccion. |
| `created_at` | `timestamp` | nullable segun convencion Laravel | Fecha de creacion del registro. |
| `updated_at` | `timestamp` | nullable segun convencion Laravel | Fecha de actualizacion del registro. |

#### Relaciones

- `federations.subdivision_id -> subdivisions.id`

#### Reglas iniciales recomendadas

- `foundation_date` no debe ser futura.
- `name` debe validarse contra duplicidad segun la regla de negocio definida.
- `address_line` se adopta como nombre explicito del detalle de direccion.

#### Restricciones de negocio pendientes

- Definir si el nombre de la federacion es unico globalmente.
- Definir si el nombre es unico por pais.
- Cerrar la regla final de unicidad funcional para `name`.
- Definir si el municipio sera texto libre o catalogo.

#### Riesgos abiertos

- Posible inconsistencia en `municipality` si no se normaliza o valida.

### 4.4 Tabla `teams`

#### Proposito

Almacena los equipos adscritos a una federacion.

#### Campos

| Campo | Tipo sugerido | Restricciones sugeridas | Descripcion |
| --- | --- | --- | --- |
| `id` | `bigint` | PK, NN | Identificador interno del equipo. |
| `federation_id` | `bigint` | FK, NN, IDX | Federacion a la que pertenece el equipo. |
| `name` | `string(150)` | NN, IDX | Nombre oficial del equipo. |
| `created_at` | `timestamp` | nullable segun convencion Laravel | Fecha de creacion del registro. |
| `updated_at` | `timestamp` | nullable segun convencion Laravel | Fecha de actualizacion del registro. |

#### Relaciones

- `teams.federation_id -> federations.id`

#### Reglas iniciales recomendadas

- El nombre del equipo debe ser unico dentro de una misma federacion.
- Debe existir una restriccion unica compuesta `federation_id + name`.

#### Riesgos abiertos

- Definir si a futuro el equipo necesitara codigo interno, siglas, escudo o estado.
- Definir si habra categorias, ramas o divisiones competitivas.

### 4.5 Tabla `players`

#### Proposito

Almacena jugadores registrados y asociados a un equipo.

#### Campos

| Campo | Tipo sugerido | Restricciones sugeridas | Descripcion |
| --- | --- | --- | --- |
| `id` | `bigint` | PK, NN | Identificador interno del jugador. |
| `team_id` | `bigint` | FK, NN, IDX | Equipo al que pertenece el jugador. |
| `name` | `string(150)` | NN, IDX | Nombre completo del jugador. |
| `birth_date` | `date` | NN | Fecha de nacimiento. |
| `gender` | `string(20)` | NN, IDX opcional | Genero controlado por enum de aplicacion. |
| `created_at` | `timestamp` | nullable segun convencion Laravel | Fecha de creacion del registro. |
| `updated_at` | `timestamp` | nullable segun convencion Laravel | Fecha de actualizacion del registro. |

#### Relaciones

- `players.team_id -> teams.id`

#### Reglas iniciales recomendadas

- `birth_date` no debe ser futura.
- `gender` debe validarse con enum de aplicacion.
- Debe definirse si el sistema necesitara otro identificador unico del jugador en el futuro.

#### Riesgos abiertos

- El nombre por si solo no es suficiente para identificar un jugador de manera unica.
- Si luego se requiere historial deportivo, la relacion directa `player -> team` podria evolucionar a una relacion historica.

### 4.6 Tabla `users`

#### Proposito

Almacena usuarios del sistema administrativo.

#### Campos actuales observados

| Campo | Tipo observado | Restricciones actuales | Descripcion |
| --- | --- | --- | --- |
| `id` | `bigint` | PK | Identificador interno del usuario. |
| `name` | `string` | NN | Nombre del usuario. |
| `email` | `string` | NN, UQ | Correo electronico. |
| `email_verified_at` | `timestamp` | nullable | Fecha de verificacion del correo. |
| `password` | `string` | NN | Contrasena cifrada. |
| `remember_token` | `string` | nullable | Token de sesion persistente. |
| `created_at` | `timestamp` | nullable | Fecha de creacion del registro. |
| `updated_at` | `timestamp` | nullable | Fecha de actualizacion del registro. |

#### Observaciones

- Esta tabla ya existe y forma parte de la base del panel administrativo.
- El proyecto ya incluye `spatie/laravel-permission`, por lo que `users` sera el principal actor de autorizacion.

## 5. Relaciones principales del dominio

### 5.1 Relaciones aprobadas conceptualmente

- Un `country` tiene muchas `subdivisions`.
- Una `subdivision` pertenece a un `country`.
- Una `federation` pertenece a una `subdivision`.
- Una `federation` tiene muchos `teams`.
- Un `team` pertenece a una `federation`.
- Un `team` tiene muchos `players`.
- Un `player` pertenece a un `team`.

### 5.2 Cardinalidad simplificada

- `countries 1 -> N subdivisions`
- `subdivisions 1 -> N federations`
- `federations 1 -> N teams`
- `teams 1 -> N players`

## 6. Restricciones transversales recomendadas

Estas restricciones deben considerarse en migraciones, validaciones y pruebas.

### 6.1 Integridad referencial

- Todas las FK deben usar restricciones explicitas.
- Debe definirse estrategia de borrado:
  - `restrictOnDelete()` en catalogos maestros.
  - `cascadeOnDelete()` solo si la regla de negocio lo permite.

### 6.2 Integridad semantica

- No permitir fechas futuras donde no corresponda.
- Normalizar mayusculas o formato de codigos.
- Evitar strings libres en campos catalogables.

### 6.3 Integridad de negocio

- No permitir equipos duplicados dentro de la misma federacion.
- No permitir codigos ISO duplicados.
- No permitir subdivisiones duplicadas por codigo dentro del mismo pais.

## 7. Campos candidatos a refinamiento antes de implementacion

Los siguientes campos requieren decision formal antes de migrarse:

| Tabla | Campo actual | Observacion | Recomendacion inicial |
| --- | --- | --- | --- |
| `countries` | `iso_name` | Puede duplicar semantica de `name` | Confirmar necesidad real |
| `federations` | `municipality` | Texto libre | Definir validacion o futura normalizacion |
| `federations` | `name` | Unicidad funcional pendiente | Cerrar restriccion antes de migrar |
| `players` | `gender` | Valor controlado | Implementar enum de aplicacion |

## 8. Recomendaciones de implementacion del diccionario

- Cada tabla debe tener su migration propia y enfocada en una sola responsabilidad.
- Las decisiones de naming deben cerrarse antes de poblar datos.
- Cada restriccion del diccionario debe reflejarse en:
  - Migraciones
  - Reglas de validacion
  - Formularios Filament
  - Tests feature
- La documentacion funcional y tecnica debe usar los mismos nombres aprobados.

## 9. Pendientes para futuras versiones del diccionario

Este documento debera ampliarse mas adelante con:

- Longitudes finales de todos los campos.
- Valores exactos de enums.
- Catalogos adicionales.
- Campos de auditoria de dominio.
- Campos opcionales adicionales.
- Diccionario de tablas de permisos, activity log y media relacionadas al dominio.
- Reglas de borrado y archivado.

## 10. Conclusion

Este diccionario de datos representa la base estructural del dominio principal del sistema. Su objetivo no es solo documentar tablas, sino reducir ambiguedad, prevenir errores de modelado y servir como contrato tecnico entre analisis, implementacion y validacion.

Toda evolucion del modelo relacional debera reflejarse en este archivo.
