# Ciclo API — Análisis, acciones por lote e informe de retorno

Versión 0.5 · 2026-09-21 · Requisito documental; pendiente de implementación.

## Alcance y vocabulario

El usuario pone nombre al agente, elige API, proporciona su URL de consumo y las credenciales necesarias. La plataforma consulta esa API, guarda su respuesta en archivo JSON, analiza los datos y presenta el resultado. Después pregunta “¿Qué quieres hacer con estos datos?” y propone acciones justificadas. El usuario selecciona o ajusta el plan y decide cuándo ejecutar una acción o un batch.

El ciclo es: **Consumir API → Analizar → Preparar acciones → Ejecutar acciones → Generar informe → Entregar JSON de resultados a la empresa**.

- **API de consumo:** endpoint de la empresa que entrega los datos de entrada; URL y configuración versionada en BD.
- **API de respuesta:** interpretación de la solicitud: endpoint receptor de la empresa, al que la plataforma envía el JSON de resultado por POST. No es otro origen de datos. Método/contrato diferente puede añadirse como adaptador; la propuesta MVP es webhook POST.
- **Ciclo:** una ejecución completa del proceso, con uno o varios registros y acciones; tiene un `run_id`.
- **Batch:** conjunto finito de acciones preparadas, con límites y resultados individuales; no habilita workflows arbitrarios ni recursivos.
- **Informe:** resumen legible y JSON versionado del resultado del ciclo, incluidos fallos y acciones omitidas.

Se conserva la ruta de importación y sus plantillas. Este documento amplía y precisa la ruta API; no elimina requisitos previos de aislamiento, límites, simulación o permisos.

## 1. Configuración guiada

1. **Identidad:** nombre y avatar del agente.
2. **Origen:** elegir API; pedir URL obligatoria, GET/POST, autenticación, headers y parámetros. Guardar URL en BD, secretos por referencia. No incrustar tokens en la URL.
3. **Consultar y analizar:** una acción explícita consulta el servicio. Mostrar fases “Consultando”, “Guardando JSON” y “Analizando”. No ejecutar llamadas ni mensajes. Una prueba de conexión que consume datos también genera snapshot.
4. **Presentar datos:** cantidad de registros obtenidos, paginación/completitud, campos y tipos detectados, muestra tabular redactada, nulos, duplicados, errores y fecha de consulta. Permitir consultar el JSON autorizado y corregir el mapeo. Distinguir “Analizamos una muestra de 100 de 5 000 registros” de un análisis completo.
5. **Elegir intención:** preguntar qué desea hacer después de mostrar el análisis. Ofrecer recomendaciones como recordatorio de cobro, promoción o seguimiento solo cuando haya evidencia suficiente. Mostrar campos que sustentan cada propuesta, datos faltantes y requisitos de canal/permiso. Permitir escribir un objetivo propio, editar o rechazar sugerencias.
6. **Preparar acción o batch:** seleccionar acción/canal, contenido, filtros, destinatarios, orden, límites y comportamiento ante fallo. Vista previa muestra cuántas acciones se prepararán y qué registros se excluirán; ningún envío ocurre aquí.
7. **Programación y retorno:** elegir ejecución manual, fecha única o recurrencia, zona horaria y ventana; configurar URL receptora, autenticación y campos permitidos del informe. Probar entrega exclusivamente con JSON sintético identificado como prueba.
8. **Simular, revisar y publicar:** validar el plan con datos de prueba. Publicar la configuración no ejecuta inmediatamente salvo que el usuario haya seleccionado explícitamente una activación programada aplicable. La ejecución manual sigue siendo una acción diferenciada.

Una URL GET o POST se prueba solo por acción explícita; para POST, el usuario debe confirmar que se trata de una consulta de datos sin efectos de negocio. Autoguardado no consume la API. Un resultado vacío no produce recomendaciones inventadas ni acciones; permite ajustar consulta y muestra claramente la ausencia de datos.

## 2. Análisis y recomendaciones

El perfil estructural y los conteos se calculan con código sobre el alcance declarado del snapshot. El modelo puede explicar los hallazgos y sugerir objetivos; sus inferencias se etiquetan como sugerencias. Un teléfono detectado no demuestra permiso de contacto ni autoriza enviar mensajes. Una fecha/importe no permite afirmar que existe una deuda sin significado confirmado por el usuario.

Las respuestas externas se tratan como datos no confiables, nunca como instrucciones para cambiar herramientas o URLs. El usuario confirma el mapeo semántico y el plan. En ejecuciones recurrentes, aplicar el plan publicado: las recomendaciones nuevas se presentan para revisión, no agregan acciones automáticamente. Si cambia un campo obligatorio o su tipo, bloquear las acciones afectadas y generar informe con el motivo.

Cada AnalysisResult referencia snapshot(s), versión de analizador, alcance completo/muestra, campos, conteos, advertencias y recomendaciones. Cada recomendación registra evidencia y confirmación/rechazo. Resultados de análisis de una revisión antigua no acreditan una configuración nueva.

## 3. Archivos JSON y BD

Cada intento de consumo deja un artefacto JSON duradero en almacenamiento privado de objetos/archivos; no se confunde con una columna JSON ni con un log temporal. Propuesta de clave interna: `tenants/{tenant_id}/runs/{run_id}/input/{request_id}.json`. Si ocurre durante configuración, usar `analysis/{analysis_id}/input/{request_id}.json`. Cada página e intento usa un ID distinto y no sobrescribe anteriores.

Para respuesta JSON válida, guardar un sobre con metadata de petición, fecha, status HTTP y `data` con el JSON recibido. No guardar headers de autorización ni credenciales. Para timeout, fallo de conexión, respuesta no JSON o truncamiento por límite, guardar un sobre JSON de error que identifique la falta de payload completo; no convertirlo en entrada válida ni afirmar que se conservaron datos no recibidos. Cuerpos no JSON se omiten del sobre; su diagnóstico se registra sin secretos.

En BD guardar URL configurada normalizada, método, parámetros no secretos, referencias de credenciales y versión del conector; por intento guardar clave del archivo, checksum, tamaño, fecha, status y completitud. Los archivos pueden contener datos sensibles: cifrado, permisos por empresa, accesos temporales autenticados y política de retención acordada en DEC-06. No publicarlos ni incorporarlos al repositorio.

Registrar primero intento pendiente, escribir archivo y después confirmar metadata. El análisis solo consume archivos confirmados. Recuperar intentos huérfanos mediante conciliación entre BD/almacenamiento; si falla la persistencia, bloquear ese ciclo antes de producir acciones. Mantener linaje archivo → análisis → plan → acción → informe. Los registros normalizados en BD continúan disponibles para deduplicación y operación.

## 4. Acción, batch y programación

El plan publicado contiene acciones declarativas de los canales soportados. Propuesta inicial: ejecución secuencial dentro de cada registro y concurrencia limitada entre registros. Cada paso declara si requiere éxito del anterior; pasos dependientes se omiten con motivo al fallar su precondición. Por defecto, un fallo de un registro no detiene los demás. La opción detener batch cancela solo pendientes, sin revertir envíos aceptados.

El usuario puede programar el ciclo completo o un batch preparado. **Ciclo completo:** consulta datos frescos en cada ventana y ejecuta el plan vigente fijado al comenzar. **Batch preparado:** conserva su snapshot/plan y no vuelve a consumir la API; muestra fecha de los datos y exige validación de vigencia según reglas del negocio antes de enviar. El informe declara la modalidad y procedencia. Cambios posteriores de configuración no alteran un batch ya fijado.

Schedule distingue `target_type=cycle|batch`, ejecución única/recurrencia, zona horaria, próxima ventana, límites y política de solapamiento. Propuesta: no superponer ciclos de un mismo agente; registrar ventana omitida por ejecución en curso. Ventanas perdidas se consolidan según TRN, sin reproducir envíos masivos. Una programación de batch no reenvía acciones completadas en ventanas siguientes.

Reservar cuotas y validar permisos, exclusiones, horarios y pausa al preparar y justo antes de enviar. Un `run_id` distinto no autoriza repetir contactos: deduplicar por empresa, agente, ID/versión de registro, paso y evento/ventana de negocio autorizada. Los reintentos técnicos reutilizan la misma identidad de acción. Contactos recurrentes solo cuando la regla publicada de frecuencia lo permite.

## 5. Informe y API de respuesta

Generar informe incluso si consumo, análisis o acciones fallan; incluir etapas no ejecutadas con motivo. Un ciclo vacío finaliza `no_data`, con cero acciones. Una acción de resultado ambiguo se refleja como `needs_review`; no inventar éxito. Esperar confirmaciones hasta el plazo del canal y después emitir informe con pendientes identificados. Si llega un resultado posterior, generar una nueva revisión del informe manteniendo anteriores.

Guardar el JSON completo en archivo privado, por ejemplo `.../runs/{run_id}/reports/{report_revision}.json`, y metadata en BD. La UI muestra resumen, estado de cada etapa, conteos, acciones, errores y entrega a la empresa. El cuerpo enviado excluye secretos y solo incorpora datos personales habilitados explícitamente en la configuración de retorno. Para informes grandes, enviar manifiesto con resumen y referencia de descarga autenticada del detalle; configurar límite de cuerpo y contrato con la empresa antes del piloto.

Propuesta de entrega: POST HTTPS al endpoint receptor con credencial por referencia o firma acordada. Aplicar controles de destinos de red del TRN también al retorno. Usar `delivery_id` y clave idempotente estables para cada `(run_id, report_revision, endpoint_version)`. La empresa debe deduplicar con esa clave. Registrar código HTTP, fecha e intentos; `2xx` acredita aceptación técnica, no procesamiento de negocio.

Un fallo de retorno no vuelve a ejecutar consumo ni acciones. Solo reintentar entrega del mismo informe con backoff, máximo propuesto de 3 intentos automáticos; errores permanentes requieren corrección, y timeout de retorno puede duplicar recepción si la empresa no deduplica. Estados separados: resultado del ciclo y estado de entrega. No esperar a que falle todo el ciclo por una URL receptora caída. El informe permanece consultable/descargable por la empresa autorizada y puede reenviarse después de corregir el endpoint.

Interpretación pendiente de confirmar: la devolución principal es push al endpoint de la empresa. También se define consulta autenticada en la plataforma para recuperación; si la empresa quiere exclusivamente consultar resultados (pull), registrar esa selección y ajustar la entrega, sin cambiar el procesamiento del ciclo.

### Ejemplo de resultado JSON

```json
{
  "schema_version": "1",
  "run_id": "run_demo_001",
  "agent_id": "agent_demo_001",
  "agent_version": 3,
  "report_revision": 1,
  "execution_mode": "cycle",
  "status": "partially_succeeded",
  "started_at": "2026-09-21T15:00:00Z",
  "finished_at": "2026-09-21T15:01:00Z",
  "source": {"connector_version_id": "cv_demo_1", "snapshot_ids": ["snap_demo_1"], "complete": true},
  "stages": [
    {"name": "consume", "status": "succeeded"},
    {"name": "analyze", "status": "succeeded"},
    {"name": "prepare", "status": "succeeded"},
    {"name": "execute", "status": "partially_succeeded"},
    {"name": "report", "status": "succeeded"}
  ],
  "summary": {"records_received": 2, "actions_planned": 2, "actions_succeeded": 1, "actions_failed": 1, "actions_skipped": 0, "actions_pending": 0},
  "results": [
    {"external_id": "demo_1", "action_id": "act_1", "type": "message", "status": "delivered", "provider_id": "msg_demo_1"},
    {"external_id": "demo_2", "action_id": "act_2", "type": "message", "status": "failed", "error": {"code": "INVALID_DESTINATION", "retryable": false}}
  ],
  "errors": [],
  "delivery": {"delivery_id": "del_demo_1", "status_at_generation": "pending"}
}
```

`delivery.status_at_generation` es el estado antes de transmitir, no una afirmación de entrega. El estado actual se consulta por separado; no modificar el cuerpo idempotente durante reintentos. Conteos de resultados individuales deben sumar el total de acciones planificadas; errores de etapa generales van en `errors`.

## 6. Contratos técnicos adicionales

| Entidad | Datos principales |
|---|---|
| ApiSnapshot | empresa, intento, conector/versión, run/analysis, archivo, checksum, completitud y error |
| AnalysisResult | snapshots, revisión de configuración, esquema inferido, métricas y recomendaciones |
| ActionPlan / ActionPlanVersion | agente, pasos permitidos, dependencias, filtros, límites y confirmación de usuario |
| CycleRun | disparador, ventana, snapshots, plan versionado, etapas y resultado agregado; agrupa Execution/Action existentes |
| ActionBatch | ciclo o snapshot preparado, plan fijado, vigencia y conjunto finito de acciones |
| ResultEndpointVersion | empresa, URL receptora, referencias de secreto, esquema y campos permitidos |
| RunReport | ciclo, revisión, archivo, resumen y checksum |
| ReportDelivery | informe/endpoint versionados, clave idempotente, intentos, código HTTP y estado |

Prefijo `/api/v1`; aplicar roles y aislamiento del TRN:

| Método/ruta | Uso |
|---|---|
| POST /agents/{id}/analyses | Editor/administrador solicita consumo, archivo y análisis explícitos; `202` con analysis_id |
| GET /analyses/{id} | Estado, alcance, muestra, errores y recomendaciones autorizadas |
| GET /api-snapshots/{id}/download | Descarga autenticada del archivo; nunca exponer claves de almacenamiento como URL pública |
| PUT /agents/{id}/action-plan | Guardar plan declarativo confirmado en borrador con control de revisión |
| PUT /agents/{id}/result-endpoint | Administrador configura URL de retorno versionada y campos permitidos |
| POST /agents/{id}/result-endpoint/test | Administrador envía prueba sintética explícita, sin usar datos reales |
| POST /agents/{id}/runs | Operador/administrador inicia ciclo de agente publicado con clave idempotente |
| GET /runs/{id} | Etapas, acciones agregadas y estado de entrega |
| POST /agents/{id}/batches | Preparar batch desde snapshot/plan autorizado; no envía acciones |
| POST /batches/{id}/execute | Ejecutar batch autorizado tras validar vigencia y publicación, con idempotencia |
| GET /runs/{id}/report | Informe actual o revisión específica autorizada |
| POST /report-deliveries/{id}/retry | Operador/administrador reintenta exclusivamente la entrega |

Schedule existente acepta ciclo o batch. Editor puede preparar y simular; solo administrador publica y configura retorno; operador ejecuta lo publicado. La API de ejecuciones individuales existente sigue disponible, pero no sustituye el run agregado del ciclo. No establecer atomicidad ficticia para envíos externos: el informe conserva efectos parciales.

## 7. Aceptación

- AT-23: URL guardada en BD y archivo JSON por página/intento en consulta de configuración y ejecución; probar timeout, respuesta no JSON, límite y fallo de almacenamiento sin acciones posteriores.
- AT-24: análisis visible antes de elegir propósito; campos, muestra y conteos verificables; sugerencias justificadas, editables y no ejecutadas automáticamente; rechazo de instrucciones dentro de datos.
- AT-25: ciclo y batch manual, fecha única y recurrente; probar plan fijado, cambio de esquema, dependencia entre pasos, pausa, vigencia y ventana solapada sin duplicados.
- AT-26: informe de éxito, parcial, error y sin datos; conteos consistentes, JSON válido, revisión tardía y separación entre ciclo y entrega.
- AT-27: endpoint de retorno autenticado, aislamiento, SSRF, recepción duplicada, timeout y reenvío; fallar entrega nunca repite llamadas/mensajes.

Pendientes concretos: contrato de recepción de la empresa (push/pull, autenticación, tamaño máximo, acuse e idempotencia), retención de snapshots, reglas de vigencia de batches y acciones iniciales del plan.
