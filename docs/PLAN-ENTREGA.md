# Plan de entrega y trazabilidad

Versión 0.5 · 2026-09-21. Orden propuesto; no constituye estimación de fechas.

## Etapas

| Etapa | Entregable | Dependencias y salida |
|---|---|---|
| E0 — Definición | Caso de uso, países, canales, volumen, stack y proveedores | Decisiones DEC-01 a DEC-06 documentadas para estimar piloto |
| E1 — Base | Registro, verificación, recuperación, empresa, roles, migraciones y auditoría | QA prueba onboarding idempotente, accesos cruzados y permisos |
| E2 — Datos | Fuentes, secretos, archivos con vista previa/confirmación, ingesta, mapeo y outbox | Archivo/JSON válido, parcial y duplicado; confirmación sin envíos; bloqueo de destinos no permitidos |
| E3 — Agentes | Elección de modalidad, catálogo/constructor de plantillas, editor, versiones, simulación y políticas | Cobro, Promoción y plantilla propia; no se producen efectos externos al simular |
| E4 — Ejecución | Cola, programador, adaptadores, callbacks y cuotas | Pruebas sandbox de mensaje y llamada; recuperación de timeout |
| E5 — Piloto | Observabilidad, runbooks, restauración y usabilidad | Evidencia de aceptación completa y decisión de salida |

## Backlog inicial

| Tarea | Responsable | Resultado verificable |
|---|---|---|
| T-001 | Proyecto | Resolver alcance del primer caso y decisiones abiertas |
| T-002 | Fullstack | Crear base técnica y controles de empresa/roles |
| T-003 | QA | Preparar matriz de aislamiento y permisos con datos sintéticos |
| T-004 | Fullstack | Implementar conectores e ingesta idempotente |
| T-005 | QA | Verificar errores de datos, SSRF y deduplicación |
| T-006 | Fullstack | Implementar editor, versionado y simulación |
| T-007 | Fullstack | Implementar workers, cuotas y canales seleccionados |
| T-008 | QA | Validar callbacks, fallos, concurrencia y recuperación |
| T-009 | Proyecto | Consolidar evidencia, alcance y decisión de piloto |
| T-010 | Fullstack | Registro, verificación, recuperación y creación idempotente del espacio en E1 |
| T-011 | Fullstack | Catálogo Cobro/Promoción, constructor privado y copias versionadas; definir esquema antes de cerrar E2 |
| T-012 | Fullstack | Importación con staging, mapeo, vista previa, confirmación y reimportación segura en E2 |
| T-013 | Fullstack | Asistente ramificado Importación/API y cambio de modalidad en borrador en E3 |
| T-014 | QA | Verificar RF-17 a RF-22 con AT-14 a AT-18 antes del piloto |
| T-015 | Fullstack | Crear tokens y componentes One UI + Bento Grid en E1; aplicarlos a todas las pantallas conforme UX-01 a UX-06 |
| T-016 | QA | Verificar consistencia visual, responsive, contraste, estados y teclado con AT-19 antes del piloto |

Todos estos elementos empiezan en estado **pendiente**. La documentación creada no implica implementación ni pruebas ejecutadas.

Incremento E3 — configuración acompañada (v0.4):

| Tarea | Responsable | Resultado verificable |
|---|---|---|
| T-017 | Fullstack | Progreso calculado, autoguardado con revisiones, checklist y reanudación conforme RF-23/RF-24 |
| T-018 | Fullstack | Catálogo de avatares y motion del asistente conforme RF-25/RF-26 y UX-07 a UX-09 |
| T-019 | QA | Ejecutar AT-20 a AT-22 en ambas modalidades, con fallos de red, concurrencia y movimiento reducido |

Trazabilidad: RF-23 → AT-20; RF-24 → AT-21; RF-25/RF-26 y UX-07 a UX-09 → AT-22. Definiciones y aceptación en [Configuración del agente](CONFIGURACION-AGENTE.md). Las tres tareas están pendientes; verificar antes del piloto.

## Matriz de trazabilidad y aceptación

Incremento v0.5 pendiente de implementación:

| Tarea | Responsable | Entregable y aceptación |
|---|---|---|
| T-020 | Fullstack | Snapshots JSON privados, URL en BD y perfil de datos en E2; RF-27/RF-28, AT-23 |
| T-021 | Fullstack | Análisis visible, intención posterior y recomendaciones confirmables en E3; RF-28/RF-29, AT-24 |
| T-022 | Fullstack | Planes, ciclos y batches programables en E4; RF-30, AT-25 |
| T-023 | Fullstack | Informe versionado y entrega independiente al endpoint de empresa en E4; RF-31/RF-32, AT-26/AT-27 |
| T-024 | QA | Verificar AT-23 a AT-27, fallos parciales, recuperación y cero repetición de acciones al reenviar informes |

Detalles y criterios en [Ciclo API](CICLO-API.md). E5 requiere además demo del ciclo completo y retorno, archivos consultables y flujo de recomendaciones confirmado; revisar estimación por este aumento de alcance.

| Requisitos | Pantallas / flujo | Prueba de aceptación |
|---|---|---|
| RF-01, RF-16 | Selector de empresa, auditoría | AT-01: modificar IDs y credenciales entre empresas; comprobar denegación y auditoría sin secretos |
| RF-02, RF-06, RF-07 | Editor y publicación | AT-02: dos agentes independientes; editar/publicar mientras existe una ejecución en curso |
| RF-03 | Fuentes | AT-03: conexión válida, token inválido, timeout, redirección a destino privado y límite de páginas |
| RF-04, RF-05 | Ingesta | AT-04: lote válido, parcial, malformado y excesivo; verificar persistencia y ausencia de acciones para rechazados |
| RF-08 | Simulación | AT-05: inspeccionar adaptadores y comprobar cero llamadas/envíos externos de canal |
| RF-09, RF-10 | Ejecución y detalle | AT-06: disparos manual/programado/ingesta, mensaje entregado y llamada completada en sandbox |
| RF-11, RF-12 | Recuperación | AT-07: duplicados simultáneos, caída de worker y timeout después de aceptación sin segundo envío |
| RF-13 | Historial | AT-08: filtros, paginación, zona horaria y motivo de error visibles |
| RF-14 | Permisos y envío | AT-09: exclusión antes y después de encolar; impedir contacto en ambos casos |
| RF-15 | Configuración y worker | AT-10: acciones concurrentes en límite de cuota; no superar reservas permitidas |
| RNF-02, RNF-03, RNF-06 | Operación | AT-11: carga acordada, métricas y alertas; dejar claro que disponibilidad mensual requiere observación real |
| RNF-04, RNF-05 | Recuperación | AT-12: caída entre commit/outbox y restauración documentada con RPO/RTO medidos |
| RNF-08 | Interfaz completa | AT-13: recorrido por teclado, foco y errores legibles; tareas de usabilidad |
| RF-17 | Registro y bienvenida | AT-14: cuenta nueva, verificación vencida/repetida, recuperación, onboarding repetido y aislamiento |
| RF-18 | Asistente | AT-15: recorrer ambas modalidades y cambiar una en borrador sin modificar versión activa |
| RF-19, RF-20 | Catálogo y constructor | AT-16: Cobro/Promoción, plantilla propia, campos inválidos, copia independiente y acceso cruzado denegado |
| RF-21 | Importación | AT-17: archivo válido/parcial, fórmulas, exceso de tamaño, selección de hoja, confirmación obsoleta, cancelación y cero envíos |
| RF-22 | Reimportación | AT-18: mismo archivo/IDs sin duplicados, IDs conflictivos, contenido actualizado, confirmación concurrente y caída antes de commit |
| UX-01 a UX-06, RNF-08 | Todas las pantallas | AT-19: capturas a 360/768/1280/1440 px, contraste medido, teclado y zoom 200 %; revisar paleta sobria, ausencia de efectos excluidos y estructura funcional de tablas |

RNF-01 se cubre en AT-01 y AT-07; RNF-07 en AT-10. QA debe descomponer cada AT en casos reproducibles antes de ejecutar.

## Registro de decisiones abiertas

| ID | Decisión | Propuesta / responsable |
|---|---|---|
| DEC-01 | Primer caso de uso y sector | Recordatorios como ejemplo; decide dueño del producto |
| DEC-02 | Canales, proveedores y países | Un canal de mensaje y voz saliente por guion; decide producto con Fullstack |
| DEC-03 | Llamada por guion o conversación | Guion en MVP; si se exige conversación, revisar PRD, arquitectura y estimación |
| DEC-04 | Volumen, cuotas y presupuesto | Medir registros/día, concurrencia y duración de llamadas; decide producto |
| DEC-05 | Stack, hosting e identidad | Monolito modular, BD relacional y workers; propone Fullstack |
| DEC-06 | Retención y política de contacto | Definir con responsables de negocio/privacidad según países |
| DEC-07 | Significado organizacional de TRN | Este documento usa “requisitos técnicos”; confirma producto |
| DEC-08 | Formatos y límites de importación | Propuesta CSV UTF-8 y XLSX, 10 MiB y 10 000 filas; confirma producto según volumen |
| DEC-09 | Campos definitivos de plantillas | Cobro y Promoción confirmados como categorías iniciales; campos del PRD son propuesta para validar |
| DEC-10 | Contrato API de respuesta | Propuesta POST al endpoint receptor; confirmar push/pull, autenticación, esquema, tamaño e idempotencia con la empresa |
| DEC-11 | Batches y snapshots | Confirmar vigencia de datos, límites de batch y retención de archivos JSON; coordinar DEC-04/DEC-06 |

## Cambio de requisitos v0.2

Solicitud incorporada: registro autoservicio, elección Importación/API y selección o construcción de plantillas por propósito en la ruta de importación. Se preservan el modelo multiempresa, las acciones y la integración JSON avanzada. Interpretación documentada: plantilla de configuración del agente con esquema de datos, no solo formato de archivo. La modalidad de registro, los formatos y los campos concretos son propuestas; las tareas nuevas siguen pendientes de implementación.

## Riesgos principales

Decisión visual confirmada por el usuario (v0.3): One UI + Bento Grid para todo el sitio, con patrones empresariales y colores sobrios. No es una decisión pendiente. Paleta exacta y medidas son la propuesta operativa de UI/UX; no cambian flujos ni reglas de negocio.

- Costos y límites de proveedores: cuotas, simulación y ledger de consumo.
- Doble contacto tras timeout: claves estables y conciliación obligatoria.
- Datos externos maliciosos: validación de esquemas, control de herramientas y destinos.
- Fuga entre empresas: autorización en backend, restricciones de datos y pruebas cruzadas.
- Crecimiento de alcance de voz: confirmar DEC-03 antes de comprometer el canal.
- Diferencias entre sandbox y producción: piloto restringido con contactos autorizados y observación.

## Definición de terminado

Una tarea termina con aceptación satisfecha, código/documentos revisables, pruebas pertinentes con evidencia, bitácora actualizada y riesgos registrados. Una funcionalidad no se declara verificada si solo existe un mock. Una salida a producción requiere además secretos configurados, políticas definidas, restauración probada, monitoreo operativo y un responsable de operación.
