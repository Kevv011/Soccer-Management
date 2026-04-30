# country-subdivision-import

## Proposito

Esta skill documenta el flujo tecnico para importar `countries` y `subdivisions` desde endpoints externos paginados hacia el proyecto `soccer-management`.

Su objetivo es dejar claro:

- el orden de importacion,
- la estrategia de Command + Job,
- el manejo de paginacion,
- la estrategia de persistencia,
- los riesgos actuales del modelo,
- el resultado esperado.

## Contexto funcional

Los modulos `Countries` y `Subdivisions` no se poblaran manualmente desde Filament como fuente principal.

La carga inicial y sincronizacion se hara consumiendo endpoints externos de solo lectura:

- `https://admatik.app/api/countries-noauth`
- `https://admatik.app/api/subdivisions-noauth`

La relacion entre datos ya viene alineada desde el sistema origen:

- `countries.id` del origen corresponde a `subdivisions.country_id` del origen.

Por lo tanto, la importacion debe preservar esos identificadores.

## Estructura de datos esperada

### Countries

Cada pagina devuelve:

- `data`
- `links`
- `meta`

Cada registro trae:

- `id`
- `iso_name`
- `iso`
- `iso3`
- `name`
- `created_at`
- `updated_at`

### Subdivisions

Cada pagina devuelve:

- `data`
- `links`
- `meta`

Cada registro trae:

- `code`
- `name`
- `country_id`
- `created_at`
- `updated_at`

Nota:

El payload de subdivisiones no trae `id`, por lo que la clave natural de importacion debe ser al menos:

- `code`

o mas seguro:

- `country_id + code`

## Orden obligatorio de importacion

El flujo correcto siempre debe ser:

1. Importar `countries`
2. Importar `subdivisions`

Razon:

- `subdivisions.country_id` depende de que el pais ya exista localmente con el mismo `id` del sistema origen.

## Observaciones del modelo actual

### Country

Modelo actual:

- [app/Models/Country.php](/home/kevinarevalo/Documentos/projects/soccer-management/app/Models/Country.php)

Observacion:

- Es compatible con una importacion por `id` siempre que el proceso inserte o actualice preservando el `id` remoto.

### Subdivision

Modelo actual:

- [app/Models/Subdivision.php](/home/kevinarevalo/Documentos/projects/soccer-management/app/Models/Subdivision.php)

Observacion importante:

- La implementacion final debe quedar alineada con la migracion real de la tabla, que usa `id` autoincremental como primary key.

### Decision tecnica aplicada

La recomendacion aplicada es:

- mantener `id` como primary key real de la tabla,
- usar `code` como identificador funcional,
- hacer upsert por `country_id + code` o por `code` si se confirma unicidad global.

## Arquitectura recomendada

## Opcion recomendada

Usar:

- un `Command` de orquestacion,
- uno o mas `Jobs` para la descarga y persistencia,
- una clase de servicio o accion para encapsular la logica de importacion si el flujo crece.

## Responsabilidades sugeridas

### Command

Responsable de:

- iniciar la importacion,
- permitir opciones como:
  - solo countries,
  - solo subdivisions,
  - importacion completa,
- despachar jobs,
- informar progreso inicial.

Nombre sugerido:

- `ImportGeographyDataCommand`

o mas explicito:

- `ImportCountriesAndSubdivisionsCommand`

### Job de countries

Responsable de:

- recorrer todas las paginas de `countries-noauth`,
- validar la respuesta,
- hacer `upsert`,
- preservar el `id` remoto.

Nombre sugerido:

- `ImportCountriesJob`

### Job de subdivisions

Responsable de:

- recorrer todas las paginas de `subdivisions-noauth`,
- validar la respuesta,
- verificar que `country_id` exista,
- hacer `upsert`.

Nombre sugerido:

- `ImportSubdivisionsJob`

## Estrategia de paginacion

La paginacion debe manejarse leyendo:

- `links.next`

o alternativamente:

- `meta.current_page`
- `meta.last_page`

### Recomendacion principal

Usar `links.next` como fuente de continuidad.

Ventajas:

- sigue el contrato del endpoint,
- evita reconstruir URLs manualmente,
- reduce acoplamiento con la forma exacta del paginador.

### Flujo sugerido

1. Llamar al endpoint base.
2. Procesar `data`.
3. Leer `links.next`.
4. Mientras `links.next` tenga valor:
   - llamar la siguiente pagina,
   - procesar `data`,
   - repetir.

## Estrategia de persistencia

## Countries

Para `countries`, el import debe preservar:

- `id`
- `iso_name`
- `iso`
- `iso3`
- `name`
- timestamps si se decide conservarlos

### Recomendacion

Usar `upsert` por:

- `id`

Esto garantiza que:

- los `id` locales coincidan con el sistema origen,
- las subdivisiones puedan referenciar correctamente a los paises.

## Subdivisions

Para `subdivisions`, el import debe persistir:

- `country_id`
- `code`
- `name`
- timestamps si se decide conservarlos

### Recomendacion

Usar `upsert` por:

- `country_id + code`

Esto es mas seguro que solo `code` si existe la posibilidad de codigos repetidos entre paises.

## Estrategia de timestamps

Debe definirse uno de estos dos enfoques:

### Opcion A

Preservar los timestamps remotos:

- `created_at`
- `updated_at`

### Opcion B

Usar timestamps locales del sistema importador.

### Recomendacion actual

Preservar timestamps remotos si el objetivo es mantener trazabilidad del dato origen.

## Validaciones tecnicas recomendadas

Antes de persistir cada pagina:

- verificar que la respuesta sea exitosa,
- verificar que exista `data`,
- verificar que `data` sea un arreglo,
- registrar errores de red o payload invalido,
- abortar o marcar fallo si countries no existe antes de subdivisions.

## Comportamiento esperado del command

El command idealmente debe permitir una experiencia como:

- importar solo countries,
- importar solo subdivisions,
- importar ambos,
- opcionalmente correr subdivisions solo si countries ya fue completado.

Tambien debe poder ejecutarse sin interaccion:

- compatible con `--no-interaction`

## Consideraciones de Laravel

Segun las reglas del proyecto:

- usar `vendor/bin/sail artisan ...`
- crear clases nuevas con `artisan make:command` y `artisan make:job`
- preferir HTTP Client de Laravel
- definir `timeout`, `connectTimeout` y `retry()`
- documentar la decision tecnica en `docs/` si cambia arquitectura o flujo

## Riesgos actuales a tener en cuenta

### Riesgo 1

Si no se preserva `countries.id`, las subdivisiones importadas no apuntaran al pais correcto.

### Riesgo 2

Si el proceso no usa upsert, repetir la importacion puede duplicar registros o fallar por restricciones unicas.

### Riesgo 3

Si no se controla la paginacion completa, quedaran catalogos incompletos.

## Resultado esperado

Al finalizar una implementacion correcta de este flujo:

- `countries` queda poblada completamente desde el endpoint remoto,
- `subdivisions` queda poblada completamente desde el endpoint remoto,
- las relaciones `subdivisions.country_id -> countries.id` quedan consistentes,
- el proceso puede ejecutarse multiples veces sin duplicar informacion,
- el proceso queda trazable y reutilizable desde un command,
- la paginacion remota queda soportada de forma completa.

## Implementacion actual esperada

La implementacion concreta debe dejar:

- una configuracion central de endpoints,
- acciones reutilizables de importacion,
- jobs separados para countries y subdivisions,
- un command orquestador con opcion sincronica o en cola.
