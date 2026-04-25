# Soccer Management - Lineamientos de Filament v4

## 1. Proposito del documento

Este documento establece como debe usarse Filament v4 dentro del proyecto `soccer-management`, tomando como referencia oficial la documentacion de Filament 4.x:

- https://filamentphp.com/docs/4.x/introduction/overview

Su objetivo es evitar perdida de foco en:

- Los componentes correctos a utilizar.
- La estructura recomendada del panel.
- Los patrones idiomaticos de Filament.
- La consistencia entre backend, UI administrativa y documentacion.

## 2. Fuente oficial de referencia

La documentacion oficial de Filament v4 debe considerarse la fuente principal para:

- Recursos administrativos.
- Formularios.
- Tablas.
- Esquemas.
- Infolists.
- Actions.
- Widgets.
- Navegacion.
- Configuracion de panel.
- Testing.

## 3. Enfoque arquitectonico adoptado para este proyecto

Filament v4 debe usarse como framework principal para la capa administrativa del sistema.

### 3.1 Principio general

La interfaz administrativa debe construirse principalmente mediante configuracion declarativa en PHP usando los componentes de Filament, evitando:

- HTML manual innecesario.
- JavaScript personalizado innecesario.
- CRUDs artesanales fuera del ecosistema Filament sin una razon clara.

### 3.2 Estructura esperada

La estructura del panel administrativo debe apoyarse principalmente en:

- `Resources` para entidades CRUD del dominio.
- `Forms` para captura y validacion de datos.
- `Tables` para listados y acciones operativas.
- `Schemas` para composicion de layouts.
- `Infolists` para vistas de solo lectura cuando aplique.
- `Actions` para operaciones puntuales.
- `Widgets` para tableros y metricas.

## 4. Componentes y estructuras a priorizar

### 4.1 Resources

Para este proyecto, las entidades principales del dominio deben implementarse como `Resource` de Filament:

- CountryResource
- SubdivisionResource
- FederationResource
- TeamResource
- PlayerResource

### 4.2 Forms

Los formularios deben construirse con componentes nativos de Filament.

Componentes esperados para este proyecto:

- `TextInput`
- `Select`
- `DatePicker` o el selector de fecha equivalente documentado por Filament v4
- `Textarea` si se requiere detalle adicional
- `Repeater` solo si aparece una relacion embebida que realmente lo justifique

Lineamientos:

- No usar `TextInput` para relaciones.
- No usar `TextInput` para campos catalogados cuando corresponda `Select`.
- `gender` debe representarse como `Select`.
- Las relaciones `country`, `subdivision`, `federation` y `team` deben resolverse con selects o relaciones propias de Filament.

### 4.3 Tables

Los listados deben implementarse con `Tables` de Filament.

Deben contemplar, segun el modulo:

- Columnas de texto.
- Ordenamiento.
- Busqueda.
- Filtros.
- Acciones por fila.
- Acciones masivas cuando tengan sentido operativo.

Aplicacion inicial esperada:

- Busqueda por nombre en federaciones, equipos y jugadores.
- Orden por fecha de creacion o nombre, segun el caso.
- Filtros por federacion y equipo donde aplique.

### 4.4 Schemas y layout

La composicion de formularios y pantallas debe apoyarse en componentes estructurales de Filament, especialmente:

- `Section`
- `Grid`
- `Tabs` si la complejidad lo amerita
- `Wizard` solo si un flujo realmente necesita pasos

Lineamiento:

Para esta primera etapa del proyecto, se prioriza simplicidad y claridad. Por defecto:

- usar `Section`
- usar `Grid`
- evitar `Wizard` si un formulario simple resuelve mejor la necesidad

### 4.5 Infolists

Cuando se requiera una vista de detalle de un registro, se recomienda usar `Infolists` en lugar de construir vistas manuales.

Aplicacion sugerida:

- Vista de detalle de federaciones.
- Vista de detalle de equipos.
- Vista de detalle de jugadores.

### 4.6 Actions

Las operaciones recurrentes o modales deben implementarse con `Actions` de Filament.

Ejemplos futuros:

- Crear.
- Editar.
- Eliminar.
- Restaurar, si luego existe soft delete.
- Acciones de negocio especificas si aparecen en nuevas iteraciones.

### 4.7 Widgets

Los `Widgets` deben reservarse para necesidades reales de dashboard, no por decoracion.

Posibles usos futuros:

- Conteo de federaciones.
- Conteo de equipos.
- Conteo de jugadores.
- Distribucion por pais o subdivision.

## 5. Criterios de uso en este proyecto

### 5.1 Cuando usar un Resource

Se debe usar `Resource` cuando:

- La entidad tiene CRUD administrativo.
- La entidad requiere listado, formulario y acciones.
- La entidad forma parte estable del dominio.

### 5.2 Cuando no salir de Filament sin necesidad

No se debe crear una solucion custom fuera de Filament si:

- Filament ya resuelve el formulario.
- Filament ya resuelve la tabla.
- Filament ya resuelve la accion modal.
- Filament ya resuelve la navegacion del panel.

### 5.3 Cuando si considerar personalizacion adicional

Solo se justifica salir del flujo estandar cuando:

- Existe una necesidad funcional que Filament no cubre de forma limpia.
- El patron custom mejora claramente mantenibilidad o usabilidad.
- La decision queda documentada.

## 6. Aplicacion concreta al dominio futbolistico

### 6.1 FederationResource

Debe contemplar al menos:

- Formulario con nombre, fecha de fundacion, subdivision, municipio y `address_line`.
- Tabla con nombre, ubicacion y fechas.
- Filtros por subdivision o pais si la relacion lo permite.

### 6.2 TeamResource

Debe contemplar al menos:

- Relacion obligatoria con federacion.
- Restriccion visible de unicidad dentro de la federacion.
- Tabla con nombre y federacion.

### 6.3 PlayerResource

Debe contemplar al menos:

- Relacion obligatoria con equipo.
- Campo `birth_date`.
- Campo `gender` como seleccion controlada.
- Tabla con nombre, equipo y genero.

### 6.4 Catalogos maestros

`CountryResource` y `SubdivisionResource` deben pensarse como catalogos administrativos y no como modulos de alta volatilidad.

## 7. Lineamientos de consistencia

### 7.1 Naming

Los nombres de etiquetas, campos y secciones deben reflejar el lenguaje del negocio documentado en `docs/`.

### 7.2 Validacion

La validacion de negocio no debe depender solo del frontend de Filament. Debe existir respaldo en reglas del lado del servidor.

### 7.3 UX administrativa

La experiencia del panel debe priorizar:

- claridad
- baja friccion
- validaciones comprensibles
- navegacion simple

### 7.4 Seguridad

La visibilidad y acciones de los recursos deben alinearse con roles y permisos definidos en el proyecto.

## 8. Testing de Filament

La documentacion oficial de Filament v4 incluye una seccion de testing que debe considerarse referencia para pruebas del panel.

Lineamiento interno:

- Toda funcionalidad critica implementada en Resources debe tener al menos pruebas funcionales base.
- Deben probarse formularios, validaciones, acciones y restricciones de acceso relevantes.

## 9. Regla documental para Filament

Cada vez que se implemente o cambie un `Resource`, debe verificarse si corresponde actualizar:

- `docs/data-dictionary.md`
- `docs/implementation-roadmap.md`
- `docs/pre-development-decisions.md`
- este documento

## 10. Conclusion

Filament v4 no debe verse solo como una libreria de UI, sino como la estructura principal de la capa administrativa del proyecto. Por ello, sus patrones oficiales deben guiar las decisiones de componentes, layouts, acciones y recursos durante el desarrollo.

Este documento fija esa referencia para mantener consistencia tecnica y funcional mientras el sistema evoluciona.
