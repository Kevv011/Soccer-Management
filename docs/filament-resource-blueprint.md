# Soccer Management - Blueprint de Resources en Filament v4

## 1. Proposito del documento

Este documento define la estructura objetivo que deben seguir los `Resources` de Filament v4 dentro del proyecto `soccer-management`.

Su finalidad es:

- Estandarizar implementacion.
- Reducir decisiones improvisadas por modulo.
- Mantener coherencia entre formularios, tablas, acciones y validaciones.
- Facilitar mantenimiento, testing y evolucion del panel administrativo.

Este blueprint debe usarse como plantilla conceptual para todos los modulos del dominio.

## 2. Alcance inicial

Los Resources previstos para la primera etapa son:

- `CountryResource`
- `SubdivisionResource`
- `FederationResource`
- `TeamResource`
- `PlayerResource`

## 3. Estructura objetivo por Resource

Cada `Resource` debe pensarse como un modulo administrativo completo y coherente.

### 3.1 Elementos base esperados

Todo `Resource` deberia contemplar, segun aplique:

- Modelo asociado.
- Etiquetas claras de navegacion.
- Formularios.
- Tabla de listado.
- Paginas base:
  - List
  - Create
  - Edit
- Vista de detalle si aporta valor operativo.
- Acciones autorizadas segun permisos.

### 3.2 Convencion general

Cada `Resource` debe responder estas preguntas antes de implementarse:

1. Que datos captura.
2. Que datos muestra.
3. Que relaciones administra.
4. Que validaciones aplica.
5. Que acciones expone.
6. Que permisos lo gobiernan.

## 4. Blueprint de formulario

Los formularios deben construirse con un enfoque de claridad, validacion y estructura predecible.

### 4.1 Estructura recomendada

Por defecto, todo formulario debe organizarse con:

- `Section`
- `Grid`

Distribucion recomendada:

- Una seccion principal para informacion general.
- Secciones adicionales solo si existe un grupo funcional claro.

### 4.2 Reglas de construccion

- No mezclar demasiados campos sin agrupacion visual.
- Usar `Select` para relaciones.
- Usar componentes de fecha para campos temporales.
- Evitar componentes avanzados si no agregan valor real.
- Mantener etiquetas y helper text consistentes con el lenguaje del negocio.

### 4.3 Blueprint comun de validacion visual

Cada formulario debe reflejar claramente:

- campos requeridos,
- relaciones obligatorias,
- restricciones de formato,
- errores de validacion comprensibles.

### 4.4 Campos por tipo

Uso esperado por tipo de dato:

- nombres: `TextInput`
- relaciones: `Select`
- fechas: componente de fecha soportado por Filament v4
- texto complementario: `Textarea` solo si realmente se necesita multilinea

## 5. Blueprint de tabla

La tabla de cada `Resource` debe ser operativa y no solo descriptiva.

### 5.1 Estructura minima

Cada tabla debe contemplar segun el caso:

- columnas principales del negocio,
- busqueda,
- ordenamiento,
- filtros,
- acciones por registro,
- acciones masivas cuando tengan sentido.

### 5.2 Reglas de diseño

- No saturar con columnas irrelevantes.
- Priorizar informacion que ayude a operar.
- Mostrar relaciones importantes con nombres legibles.
- Orden por defecto orientado a uso real.

### 5.3 Columnas sugeridas

Por defecto, considerar:

- nombre
- relacion padre relevante
- fechas de creacion o actualizacion cuando aporten valor

## 6. Blueprint de acciones

Las acciones deben ser pocas, claras y alineadas al flujo real del modulo.

### 6.1 Acciones base recomendadas

- crear
- editar
- eliminar, si la regla de negocio lo permite

### 6.2 Acciones futuras posibles

- ver detalle
- restaurar
- acciones de negocio adicionales

### 6.3 Regla de control

No agregar acciones solo porque Filament las soporta. Cada accion debe responder a una necesidad real del dominio.

## 7. Blueprint por Resource

## 7.1 `CountryResource`

### Objetivo

Administrar el catalogo maestro de paises.

### Formulario esperado

Campos:

- `iso_name`
- `iso`
- `iso3`
- `name`

### Tabla esperada

Columnas sugeridas:

- nombre
- codigo ISO 2
- codigo ISO 3

### Filtros sugeridos

- No obligatorios en etapa inicial.

### Observaciones

- Es un catalogo maestro.
- Debe priorizar integridad por encima de velocidad de captura.

## 7.2 `SubdivisionResource`

### Objetivo

Administrar subdivisiones territoriales por pais.

### Formulario esperado

Campos:

- `country_id`
- `code`
- `name`

### Tabla esperada

Columnas sugeridas:

- nombre
- codigo
- pais relacionado

### Filtros sugeridos

- por pais

### Observaciones

- Debe mostrar claramente la relacion con pais.
- La unicidad por pais y codigo debe validarse visual y funcionalmente.

## 7.3 `FederationResource`

### Objetivo

Administrar federaciones de futbol.

### Formulario esperado

Campos:

- `name`
- `foundation_date`
- `subdivision_id`
- `municipality`
- `address_line`

### Estructura sugerida

Seccion 1:

- Informacion general

Seccion 2:

- Ubicacion

### Tabla esperada

Columnas sugeridas:

- nombre
- subdivision
- municipio
- fecha de fundacion
- fecha de creacion, si aporta valor operativo

### Filtros sugeridos

- por subdivision
- por pais, si la relacion se muestra indirectamente

### Observaciones

- Es una entidad central del dominio.
- Debe tener UX clara por ser una pieza maestra del sistema.

## 7.4 `TeamResource`

### Objetivo

Administrar equipos asociados a una federacion.

### Formulario esperado

Campos:

- `federation_id`
- `name`

### Tabla esperada

Columnas sugeridas:

- nombre
- federacion
- fecha de creacion

### Filtros sugeridos

- por federacion

### Observaciones

- Debe reflejar claramente la relacion con federacion.
- La regla de unicidad por federacion debe ser visible en validacion.

## 7.5 `PlayerResource`

### Objetivo

Administrar jugadores asociados a un equipo.

### Formulario esperado

Campos:

- `team_id`
- `name`
- `birth_date`
- `gender`

### Tabla esperada

Columnas sugeridas:

- nombre
- equipo
- genero
- fecha de nacimiento

### Filtros sugeridos

- por equipo
- por federacion, si se resuelve de forma limpia
- por genero

### Observaciones

- `gender` debe implementarse como seleccion controlada.
- Debe priorizarse claridad sobre complejidad.

## 8. Blueprint de permisos por Resource

Cada Resource debe diseñarse considerando autorizacion desde el inicio.

### Operaciones a contemplar

- ver listado
- ver detalle
- crear
- editar
- eliminar

### Regla

No asumir acceso total por defecto. Cada modulo debe poder restringirse por rol o permiso cuando se implemente la capa de autorizacion.

## 9. Blueprint de testing por Resource

Cada Resource critico debe contemplar al menos pruebas para:

- carga del listado
- acceso autorizado
- acceso denegado cuando aplique
- creacion valida
- validaciones fallidas relevantes
- edicion valida

## 10. Checklist previo a implementacion de un Resource

Antes de crear cualquier Resource, validar:

1. La tabla y campos ya estan cerrados documentalmente.
2. La validacion del modulo esta definida.
3. La relacion con otras entidades esta clara.
4. El naming coincide con `docs/`.
5. El formulario esperado esta definido.
6. La tabla esperada esta definida.
7. Los permisos esperados estan claros.

## 11. Conclusion

Este blueprint establece una plantilla comun para que todos los Resources del proyecto se construyan con una misma logica de estructura, experiencia administrativa y calidad tecnica.

Debe utilizarse como referencia de implementacion una vez que inicie el desarrollo real de los modulos en Filament v4.
