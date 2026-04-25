# Soccer Management - Decisiones Previas al Desarrollo

## 1. Proposito del documento

Este documento formaliza las decisiones tecnicas que corrigen las debilidades detectadas durante el analisis inicial del proyecto.

Su objetivo es cerrar criterios antes de iniciar el desarrollo funcional real del dominio, reduciendo reprocesos, ambiguedad y riesgos de calidad.

## 2. Debilidades identificadas y decision adoptada

### 2.1 Ambiguedad en direccion de la federacion

#### Debilidad detectada

En el modelo inicial, la tabla `federations` incluye:

- `subdivision_id`
- `municipality`
- `address`

El problema es que `address` es demasiado generico y no refleja claramente si representa direccion completa, linea principal o complemento.

#### Decision adoptada

Se adopta la siguiente estructura semantica para direccion:

- `subdivision_id`: division territorial principal.
- `municipality`: municipio o localidad.
- `address_line`: detalle de direccion o complemento.

#### Lineamiento

El campo `address` no debera implementarse con ese nombre en la version funcional final. Se recomienda usar `address_line`.

### 2.2 Campo `gender` sin control semantico

#### Debilidad detectada

`players.gender` como string libre puede producir datos inconsistentes.

#### Decision adoptada

El campo `gender` sera un valor controlado por enum de aplicacion.

Valores iniciales aprobados:

- `male`
- `female`

#### Lineamiento

- En base de datos puede almacenarse como `string(20)` con validacion estricta desde aplicacion.
- En capa de dominio se recomienda usar un enum PHP.
- En Filament debe presentarse como `Select`, no como `TextInput`.

### 2.3 Falta de restricciones de unicidad de negocio

#### Debilidad detectada

El modelo inicial no define explicitamente restricciones clave.

#### Decision adoptada

Se aprueban las siguientes unicidades minimas:

- `countries.iso` unico.
- `countries.iso3` unico.
- `subdivisions.country_id + code` unico.
- `teams.federation_id + name` unico.

#### Decision pendiente controlada

La unicidad de `federations.name` queda definida provisionalmente asi:

- Debe ser unica por combinacion geografica funcional.
- Antes de migrar, se evaluara si la combinacion sera:
  - `name + subdivision_id + municipality`
  - o un criterio mas simple segun negocio final.

#### Lineamiento

No se debe implementar la tabla `federations` sin cerrar la unicidad definitiva del nombre.

### 2.4 Baja trazabilidad del dominio

#### Debilidad detectada

Aunque el proyecto ya cuenta con `spatie/laravel-activitylog`, aun no existe una estrategia definida de auditoria del dominio.

#### Decision adoptada

Se adopta como obligatoria una trazabilidad minima sobre entidades principales del negocio:

- Federations
- Teams
- Players

Eventos minimos a registrar:

- Creacion
- Actualizacion
- Eliminacion, si aplica funcionalmente

#### Lineamiento

- Las entidades principales del dominio deben integrarse con `spatie/laravel-activitylog`.
- Debe registrarse al menos el cambio de atributos relevantes.
- La auditoria no se dejara para una fase indefinida.

### 2.5 Riesgo de inconsistencia documental

#### Debilidad detectada

Si la documentacion no se actualiza junto al codigo, el proyecto puede divergir rapidamente de su base analitica.

#### Decision adoptada

La actualizacion de `docs/` pasa a ser un criterio obligatorio de cierre para cambios estructurales.

#### Lineamiento

Todo cambio en:

- base de datos,
- naming de entidades,
- reglas de validacion,
- permisos,
- auditoria,
- testing del dominio

debe reflejarse en la documentacion antes de dar por cerrada la iteracion.

## 3. Decisiones tecnicas adicionales recomendadas

### 3.1 Estrategia de borrado

Se recomienda adoptar `restrictOnDelete()` en relaciones maestras del dominio:

- No permitir borrar `countries` con subdivisiones asociadas.
- No permitir borrar `subdivisions` con federaciones asociadas.
- No permitir borrar `federations` con equipos asociados.
- No permitir borrar `teams` con jugadores asociados.

### 3.2 Estrategia de validacion temporal

Se aprueban estas reglas minimas:

- `foundation_date` no puede ser futura.
- `birth_date` no puede ser futura.
- `birth_date` debe ser logicamente anterior a la fecha actual.

### 3.3 Estrategia de catalogos base

Se adopta que:

- `countries` y `subdivisions` seran catalogos maestros.
- Su carga inicial debe realizarse por seeders.
- No deben depender de carga manual improvisada en produccion.

### 3.4 Estrategia de exposicion de datos

La decision inicial contemplaba `ApiResources` para todos los modelos principales del dominio.

Sin embargo, la decision vigente para la etapa de arranque es:

- no desarrollar una API del dominio por ahora,
- priorizar Filament v4 como capa principal de operacion,
- dejar los `ApiResources` como opcion futura si el proyecto los necesita.

Aplicacion futura posible:

- Country
- Subdivision
- Federation
- Team
- Player

Lineamiento vigente:

- No se desarrollaran endpoints del dominio como prioridad en esta fase.
- La logica de negocio inicial se consumira desde modulos Filament.

## 4. Impacto directo en futuras migraciones

Las futuras migraciones del dominio deben salir de estas decisiones:

### 4.1 `federations`

Campos base aprobados:

- `id`
- `name`
- `foundation_date`
- `subdivision_id`
- `municipality`
- `address_line`
- timestamps

### 4.2 `players`

Campo aprobado:

- `gender` como string controlado por enum de aplicacion

### 4.3 Indices y restricciones

Deben contemplarse como minimo:

- indices para todas las FK
- restricciones unicas ya aprobadas
- restricciones de integridad relacional

## 5. Reglas previas obligatorias antes de empezar desarrollo funcional

Antes de crear migraciones del dominio, deben considerarse cerradas estas decisiones:

1. El nombre final `address_line`.
2. El enum inicial de `gender`.
3. Las unicidades minimas ya definidas.
4. La auditoria minima obligatoria para el dominio.
5. La decision de no priorizar API en la etapa inicial.
6. La actualizacion documental como parte del flujo de desarrollo.

## 6. Conclusion

Las debilidades detectadas ya no deben tratarse como observaciones abiertas, sino como decisiones tecnicas adoptadas para el inicio del proyecto.

Con esto, la base documental queda mejor preparada para iniciar el desarrollo real con mas control, menos ambiguedad y mayor alineacion con calidad, trazabilidad y mantenibilidad.
