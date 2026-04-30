# Soccer Management - Roadmap de Implementacion Segura

## 1. Proposito del documento

Este roadmap define una secuencia recomendada para implementar el proyecto de forma controlada, trazable y alineada con buenas practicas de Laravel, Filament y criterios de calidad inspirados en ISO.

El objetivo es:

- Reducir reprocesos.
- Evitar decisiones prematuras en la base de datos.
- Asegurar consistencia entre analisis, desarrollo, validacion y documentacion.
- Servir como guia de ejecucion incremental.

## 2. Principios del roadmap

La implementacion debe seguir estos principios:

- Primero cerrar decisiones de dominio, luego codificar.
- No crear migraciones funcionales con ambiguedades de naming.
- Toda regla importante debe quedar documentada antes de implementarse.
- Cada iteracion debe dejar evidencia tecnica actualizada.
- Validaciones, permisos y pruebas no deben dejarse para el final.

## 3. Fases recomendadas

## Fase 0. Consolidacion documental y analitica

### Objetivo

Cerrar la base conceptual del proyecto antes de tocar el dominio en codigo.

### Entregables

- Documento tecnico base.
- Diccionario de datos.
- Roadmap de implementacion.
- Lista de riesgos y debilidades.

### Tareas

1. Confirmar nombres finales de tablas y campos.
2. Confirmar restricciones de unicidad.
3. Confirmar estrategia de direcciones.
4. Confirmar manejo de `gender`.
5. Confirmar reglas de borrado y dependencias.
6. Confirmar requerimientos de auditoria.

Nota:

Estas decisiones quedaron inicialmente formalizadas en `docs/pre-development-decisions.md` y deben usarse como base antes de migrar el dominio.

### Criterio de salida

No iniciar migraciones del dominio hasta que estas decisiones esten cerradas.

## Fase 1. Modelado relacional final

### Objetivo

Traducir el analisis funcional a un modelo relacional final, sin ambiguedades.

### Tareas

1. Aprobar tablas definitivas:
   - `countries`
   - `subdivisions`
   - `federations`
   - `teams`
   - `players`
2. Definir tipos de datos y longitudes.
3. Definir llaves foraneas.
4. Definir indices.
5. Definir restricciones unicas.
6. Definir estrategia de borrado:
   - restringido
   - cascada
   - nulo

### Entregables

- Version aprobada del modelo relacional.
- Actualizacion del diccionario de datos.

### Riesgos si se omite

- Migraciones incorrectas.
- Reprocesos estructurales.
- Inconsistencia entre documentacion y codigo.

## Fase 2. Preparacion de catalogos y datos maestros

### Objetivo

Establecer los catalogos base sobre los que dependera el dominio.

### Tareas

1. Crear migraciones de `countries` y `subdivisions`.
2. Crear seeders para catalogos territoriales.
3. Definir fuente de datos oficial para estos catalogos.
4. Validar reglas de unicidad y formato.

### Entregables

- Catalogo base de paises.
- Catalogo base de subdivisiones.
- Seeders documentados.

### Criterios de calidad

- Datos consistentes.
- Sin duplicados.
- Codigos ISO normalizados.

## Fase 3. Implementacion del nucleo del dominio

### Objetivo

Crear las entidades principales del negocio.

### Tareas

1. Crear migraciones de:
   - `federations`
   - `teams`
   - `players`
2. Crear modelos Eloquent.
3. Definir relaciones entre modelos.
4. Definir casts.
5. Definir fillable o guardado explicito.
6. Evaluar integracion con activity log.

Nota:

La tabla `federations` debe implementarse con `address_line`, no con `address`.

### Entregables

- Modelo de dominio persistente.
- Relaciones Eloquent definidas.

### Criterios de calidad

- Relaciones correctas.
- Naming consistente.
- Sin logica de negocio dispersa en vistas.

## Fase 4. Validaciones y reglas del dominio

### Objetivo

Asegurar integridad funcional y experiencia de usuario consistente.

### Tareas

1. Definir reglas de validacion por entidad.
2. Implementar Form Requests o reglas equivalentes segun convencion adoptada.
3. Validar:
   - nombres requeridos
   - fechas validas
   - unicidad
   - llaves foraneas existentes
   - restricciones de formato
4. Definir mensajes de error claros.

### Reglas minimas recomendadas

- `foundation_date` no futura.
- `birth_date` no futura.
- `gender` restringido a valores aprobados.
- `team.name` unico dentro de su federacion.
- `country.iso` y `country.iso3` unicos.

### Entregables

- Matriz de validaciones.
- Implementacion en backend.

## Fase 5. Panel administrativo en Filament

### Objetivo

Construir la capa operativa para gestion del dominio.

### Tareas

1. Crear Resources para:
   - Countries
   - Subdivisions
   - Federations
   - Teams
   - Players
2. Diseñar formularios usables.
3. Diseñar tablas con filtros y busquedas.
4. Implementar selects dependientes donde aplique.
5. Garantizar una experiencia administrativa clara.

Referencia documental obligatoria:

- `docs/filament-v4-guidelines.md`
- Documentacion oficial de Filament v4: https://filamentphp.com/docs/4.x/introduction/overview

### Recomendaciones UX iniciales

- Formularios por secciones.
- Campos obligatorios claramente marcados.
- Selects para relaciones.
- Validacion inmediata donde aporte valor.
- Etiquetas consistentes con lenguaje del negocio.

### Entregables

- CRUD administrativo funcional.

## Fase 6. Roles, permisos y acceso seguro

### Objetivo

Asegurar control de acceso desde etapas tempranas.

### Tareas

1. Definir roles iniciales del panel.
2. Definir permisos por modulo.
3. Integrar `spatie/laravel-permission`.
4. Aplicar autorizacion a recursos y acciones.
5. Revisar politica de acceso al panel.

### Roles candidatos iniciales

- Super Admin
- Administrador de Federacion
- Operador
- Consulta

### Entregables

- Matriz de roles y permisos.
- Politicas o reglas de acceso implementadas.

## Fase 7. Auditoria y trazabilidad

### Objetivo

Alinear el proyecto con necesidades de seguimiento y cumplimiento.

### Tareas

1. Definir eventos que deben auditarse.
2. Integrar `spatie/laravel-activitylog` en entidades clave.
3. Documentar que cambios deben registrarse.
4. Establecer criterio minimo de trazabilidad.

### Alcance minimo recomendado

- Creacion de federaciones.
- Edicion de federaciones.
- Creacion de equipos.
- Edicion de equipos.
- Creacion de jugadores.
- Edicion de jugadores.
- Cambios de estado cuando existan.

### Entregables

- Auditoria funcional minima activa.

## Fase 8. Testing funcional y tecnico

### Objetivo

Garantizar estabilidad y reducir regresiones.

### Tareas

1. Crear tests feature para flujos principales.
2. Crear tests de validacion.
3. Crear tests de relaciones y restricciones.
4. Crear tests de autorizacion.
5. Integrar ejecucion recurrente en flujo de trabajo.

### Cobertura minima recomendada

- Crear federacion valida.
- Rechazar federacion con fecha futura.
- Crear equipo asociado a federacion.
- Evitar equipo duplicado dentro de la misma federacion.
- Crear jugador asociado a equipo.
- Rechazar jugador con datos invalidos.
- Restringir acceso segun permisos.

### Entregables

- Suite minima de pruebas del dominio.

## Fase 9. Reportes, adjuntos y capacidades extendidas

### Objetivo

Extender el sistema sin comprometer la base ya estabilizada.

### Lineas futuras recomendadas

1. Escudos o logotipos con Medialibrary.
2. Exportes o reportes PDF.
3. Filtros avanzados con Query Builder.
4. API publica o interna si en una fase futura se vuelve necesaria.
5. Dashboard con metricas.

### Condicion

No avanzar a esta fase sin haber estabilizado dominio, permisos y pruebas.

## 4. Debilidades a corregir desde el inicio

Estas debilidades deben ser tratadas como acciones tempranas, no como mejoras opcionales.

### 4.1 Ambiguedad en campos de direccion

Accion aplicada:

- Se adopta `address_line` como nombre final recomendado para el detalle de direccion.

### 4.2 Falta de catalogacion de `gender`

Accion aplicada:

- Se aprueba `gender` como valor controlado por enum de aplicacion.

### 4.3 Falta de reglas de unicidad de negocio

Accion aplicada:

- Se aprueban unicidades minimas y se deja pendiente controlado el criterio final para `federations.name`.

### 4.4 Riesgo de baja trazabilidad

Accion aplicada:

- Se define auditoria minima obligatoria para `federations`, `teams` y `players`.

### 4.5 Riesgo de documentacion desactualizada

Accion aplicada:

- `docs/` pasa a ser criterio obligatorio de cierre para cambios estructurales.

## 5. Regla operativa para mantenimiento de documentacion

Cada vez que ocurra alguno de estos cambios, debera actualizarse la carpeta `docs/`:

- Cambio de estructura de base de datos.
- Nueva regla de negocio.
- Cambio de validaciones.
- Cambio de permisos.
- Inclusion de nuevas entidades.
- Cambio de arquitectura relevante.
- Nueva estrategia de auditoria o testing.

## 6. Criterios de aceptacion por iteracion

Toda iteracion relevante del proyecto deberia cerrar con:

- Codigo consistente con la documentacion.
- Validaciones implementadas.
- Permisos revisados si aplica.
- Tests minimos ejecutados.
- Documentacion actualizada.

## 7. Orden sugerido de ejecucion real

Secuencia recomendada para este proyecto:

1. Cerrar definiciones de campos y restricciones.
2. Crear catalogos territoriales.
3. Crear tablas del dominio.
4. Implementar modelos y relaciones.
5. Implementar validaciones.
6. Crear Resources de Filament.
7. Integrar permisos.
8. Integrar auditoria.
9. Crear tests.
10. Extender con reportes, media o APIs.

## 8. Conclusion

Este roadmap busca que el proyecto crezca de forma segura, sin improvisacion estructural y con una base documental suficiente para sostener mantenimiento, auditoria y evolucion funcional.

Su uso recomendado es como checklist de avance tecnico, revisandolo y actualizandolo en cada etapa importante del desarrollo.

## 9. Avance actual documentado

Actualmente ya se encuentra iniciada la implementacion real de la fase 3 con:

- migraciones del dominio,
- modelos Eloquent,
- enum `PlayerGender`,
- `ApiResources` base,
- factories del dominio,
- `SoccerManagementSeeder`.

Tambien quedaron iniciadas las configuraciones base de infraestructura transversal para:

- permisos y roles,
- media library,
- activity log.

Concretamente:

- seeding inicial de roles y permisos,
- middleware aliases de autorizacion,
- acceso al panel basado en permiso,
- colecciones de media iniciales,
- configuracion publicada de Media Library,
- `Super Admin` via `Gate::before`.

Decision de enfoque vigente:

- la implementacion continuara sin API de dominio,
- la siguiente capa principal sera Filament v4.

Avance adicional ya ejecutado:

- policies del dominio alineadas a permisos,
- estructura base de Resources de Filament v4,
- formularios y tablas iniciales de los cinco modulos principales,
- integracion inicial de Media Library en federaciones y equipos.

Avance adicional en catalogos:

- estructura de importacion remota para countries y subdivisions,
- command de orquestacion,
- jobs separados,
- manejo de paginacion remota por `links.next`.

Las siguientes capas pendientes naturales son:

- validaciones formales,
- endpoints o controladores de API,
- Resources de Filament,
- permisos y pruebas.
