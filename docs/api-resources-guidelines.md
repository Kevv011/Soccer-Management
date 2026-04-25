# Soccer Management - Lineamientos de API Resources

## 1. Estado del documento

Este documento queda en estado de referencia futura.

Decision actual del proyecto:

- en la etapa inicial no se desarrollara una API del dominio,
- la capa principal de operacion sera Filament v4,
- los `ApiResources` dejan de ser prioridad inmediata.

## 2. Proposito del documento

Este documento formaliza el uso obligatorio de `ApiResources` de Laravel para los modelos principales del dominio.

Su objetivo es:

- Estandarizar la salida de datos.
- Separar persistencia de representacion.
- Preparar el proyecto para consumo de datos por API o integraciones futuras.
- Evitar exponer modelos Eloquent de forma directa.

## 3. Decision arquitectonica original adoptada

Todos los modelos principales del dominio deben contar con su correspondiente `ApiResource`.

Aplicacion inicial obligatoria:

- `Country` -> `CountryResource`
- `Subdivision` -> `SubdivisionResource`
- `Federation` -> `FederationResource`
- `Team` -> `TeamResource`
- `Player` -> `PlayerResource`

Si se requieren colecciones especializadas, podran agregarse recursos de coleccion o respuestas paginadas segun necesidad.

## 4. Decision vigente para la etapa actual

La implementacion real del proyecto se enfocara primero en:

- modelos Eloquent,
- reglas de dominio,
- permisos,
- recursos administrativos en Filament v4.

Los `ApiResources` quedan como capacidad futura opcional y no como requisito de arranque.

## 5. Principio de diseño

Los modelos Eloquent representan persistencia.

Los `ApiResources` representan la forma oficial en que el sistema expone datos estructurados.

Por tanto:

- No se debe retornar directamente el modelo Eloquent desde endpoints del dominio.
- La salida JSON debe quedar encapsulada en `ApiResources`.
- Las relaciones deben exponerse de forma intencional, no accidental.

## 6. Beneficios esperados

- Mayor control sobre atributos visibles.
- Menor acoplamiento entre DB y contrato de salida.
- Mejor trazabilidad de cambios de estructura.
- Preparacion para versionado de API.
- Mayor claridad para frontend, integraciones o exportaciones futuras.

## 7. Lineamientos de implementacion

### 5.1 Un Resource por modelo principal

Cada modelo del dominio debe tener al menos un `JsonResource` base.

### 5.2 Exposicion controlada

Cada `ApiResource` debe definir explicitamente:

- atributos base,
- relaciones permitidas,
- formatos de fecha,
- nombres de claves si requieren consistencia externa.

### 5.3 Relaciones

Las relaciones deben exponerse de forma condicional o explicita, no por reflejo automatico.

Ejemplos esperados:

- `SubdivisionResource` puede incluir `country` si fue cargado.
- `FederationResource` puede incluir `subdivision`.
- `TeamResource` puede incluir `federation`.
- `PlayerResource` puede incluir `team`.

### 5.4 Fechas

Las fechas deben serializarse con formato consistente en todos los recursos.

### 5.5 Nomenclatura

Los nombres de `ApiResources` deben seguir convencion Laravel y reflejar el nombre del modelo.

## 8. Aplicacion conjunta con Filament

Filament se utilizara para la capa administrativa.

`ApiResources` se utilizaran para la capa de exposicion de datos.

Ambas capas deben compartir:

- mismo lenguaje de dominio,
- mismas reglas de validacion de fondo,
- mismas decisiones de naming,
- misma semantica documental.

## 9. Consideraciones para futuras APIs

Aunque la API no sera prioridad en esta fase, el proyecto puede quedar preparado para:

- endpoints REST,
- integraciones con frontend desacoplado,
- exportaciones estructuradas,
- consumo por otros sistemas.

## 10. Regla documental

Cada vez que cambie la estructura de salida esperada de una entidad, debera revisarse este documento y el diccionario de datos asociado.

## 11. Conclusion

Los `ApiResources` pasan a ser parte del diseño base del proyecto y no una mejora posterior. Esto asegura que la representacion de datos quede controlada, documentada y alineada con una arquitectura mantenible.
