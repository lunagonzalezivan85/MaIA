# PRD — Generador de agentes GPT

Versión 0.5 · 2026-09-21 · Responsable funcional: por asignar.

## 1. Problema y propuesta

Una empresa necesita automatizar distintos procesos —seguimiento comercial, recordatorios, atención o cobranza— sin construir una integración diferente para cada agente. Actualmente la configuración de APIs, información, instrucciones y canales puede quedar dispersa, dificultando el control de ejecuciones y resultados.

El producto permitirá crear N agentes por empresa, definir qué información consumen y qué acciones pueden realizar, probarlos y publicarlos con trazabilidad. “N” significa una cantidad configurable dentro de cuotas; no capacidad ilimitada.

El usuario se registra, pone nombre al agente y elige importación o consumo de API. La primera ruta permite seleccionar una plantilla por propósito —inicialmente cobro y promoción— o construir una propia. En API se solicita primero URL y conexión, se consume y guarda la respuesta como archivo JSON y se presenta el análisis; después se pregunta qué desea hacer y se sugieren acciones. El usuario confirma el plan y configura ejecución manual/programada o por batch y la devolución del informe JSON a su empresa.

Ejemplo: una persona se registra, crea un agente de cobro, elige importar datos y selecciona la plantilla Cobro. Carga un archivo, relaciona sus columnas con cliente, teléfono, referencia, importe, moneda y vencimiento, revisa errores y confirma la importación. Luego ajusta el mensaje o guion, simula y publica. Subir el archivo no inicia contactos.

### Plantillas por propósito

Una plantilla reúne nombre, categoría, objetivo, campos requeridos/opcionales con sus tipos, instrucciones y mensaje o guion inicial. El usuario puede partir de una del catálogo o construir una desde cero mediante un formulario. Seleccionarla crea una copia editable para su agente; editarla no modifica otros agentes. Una plantilla reutilizable propia solo es visible en su empresa.

| Plantilla inicial | Campos propuestos | Comportamiento inicial |
|---|---|---|
| Cobro | ID de registro, cliente, teléfono, referencia de deuda, importe, moneda, vencimiento | Recordar un saldo informado y su vencimiento, sin inventar importes ni realizar cargos |
| Promoción | ID de registro, nombre, teléfono, promoción, vigencia | Comunicar la oferta proporcionada a contactos habilitados para ese propósito |
| Personalizada | ID de registro, destinatario y campos definidos por el usuario | Objetivo, instrucciones y contenido construidos por el usuario |

Los campos exactos son propuestas iniciales. La plantilla de propósito y el archivo de ejemplo para cargar datos son elementos diferentes; el archivo se genera a partir de los campos de la plantilla.

## 2. Usuarios y permisos

| Rol | Capacidades |
|---|---|
| Administrador de empresa | Usuarios, credenciales, fuentes, agentes, publicación, cuotas y auditoría de su empresa |
| Editor | Configurar borradores y ejecutar simulaciones; sin publicar ni revelar secretos |
| Operador | Consultar ejecuciones, iniciar ejecuciones de agentes publicados y cancelar pendientes |
| Auditor | Consultar configuración no sensible, ejecuciones y auditoría; sin modificaciones |

El acceso interno de soporte no forma parte del MVP. Si se incorpora, requerirá permisos explícitos y auditoría de acceso entre empresas.

El registro es autoservicio. Se propone verificar el correo y crear un espacio de empresa con el registrante como administrador; un usuario individual puede usar ese espacio sin invitar a nadie. Los demás roles conservan sus permisos. Registro, acceso y recuperación de cuenta forman parte del producto.

## 3. Objetivos y métricas

Requisito de experiencia: todo el sitio usará una estética empresarial inspirada en Samsung One UI y composición Bento Grid donde corresponda. Predominan neutros, superficies sólidas y un acento; se excluyen glassmorphism, neón y degradados decorativos. La especificación verificable UX-01 a UX-06 está en `UI-UX.md`; se aplica también a registro, errores, tablas y configuración.

Objetivos: reducir el esfuerzo de configurar automatizaciones, reutilizar conectores y disponer de evidencia de cada acción.

Metas iniciales de validación, no resultados observados:

- Un administrador configura y simula su primer agente en menos de 30 minutos con un conector soportado y datos preparados.
- El 100 % de las acciones externas tiene identificadores de empresa, agente, versión, ejecución y acción.
- Cero accesos entre empresas en la batería de pruebas de aislamiento.
- El 100 % de las ejecuciones muestra un estado y un motivo consultable cuando termina sin éxito.
- Medir tasa de importación válida, éxito por canal, latencia de cola y costo estimado/real; las metas comerciales se fijarán tras el piloto.

## 4. Alcance

### MVP

1. Registro autoservicio, verificación de cuenta, acceso, recuperación y permisos por empresa.
2. CRUD de agentes con borrador, publicación, pausa y archivo.
3. Configuración de API REST JSON: método GET/POST, URL, autenticación por API key o bearer token, parámetros, timeout y mapeo.
4. Ingesta entrante autenticada y consulta saliente manual o programada.
5. Persistencia de registros validados y reporte de rechazados.
6. Instrucciones, variables, reglas, herramientas permitidas y límites por agente.
7. Simulación sin efectos externos y ejecución real autorizada.
8. Un adaptador de mensajería y uno de llamadas salientes, seleccionados durante descubrimiento.
9. Cola, deduplicación, reintentos seguros y recepción de callbacks de proveedores.
10. Historial de ejecuciones, auditoría, consumo y bitácoras del equipo.
11. Asistente con elección explícita entre importación y consumo de API.
12. Catálogo inicial de plantillas de cobro y promoción, creación de plantillas propias y copia editable por agente.
13. Importación de archivos con muestra, mapeo, validación por fila y confirmación previa a persistir datos utilizables. CSV y XLSX son formatos propuestos para el MVP.

### Fuera del MVP

Entrenamiento de modelos propios; marketplace; facturación SaaS; editor visual arbitrario de workflows; ejecución de código escrito por clientes; navegación autónoma; voz conversacional bidireccional; recepción de llamadas; omnicanalidad completa; conectores OAuth genéricos; campañas sin límites; decisiones sensibles autónomas sin revisión.

## 5. Requisitos funcionales

| ID | Requisito | Criterio de aceptación |
|---|---|---|
| RF-01 | Aislar empresas y aplicar roles | Un usuario de A no puede leer, modificar ni ejecutar recursos de B, incluso cambiando IDs |
| RF-02 | Gestionar varios agentes | Crear dos agentes con propósitos y fuentes distintos sin compartir configuración accidentalmente |
| RF-03 | Configurar fuentes API | Guardar credencial protegida, probar conexión y mostrar muestra redactada o error accionable |
| RF-04 | Recibir JSON | Solicitud válida devuelve recepción rastreable; datos inválidos no activan acciones |
| RF-05 | Mapear y almacenar | Cada registro conserva origen e ID externo; errores de campo se reportan sin perder el estado del lote |
| RF-06 | Versionar y publicar | Publicar exige configuración completa; una ejecución conserva la versión con la que empezó |
| RF-07 | Definir comportamiento | El administrador configura propósito, variables, instrucciones, canal y herramientas permitidas |
| RF-08 | Simular | La prueba muestra datos usados, contenido y acción propuesta; no llama ni envía mensajes reales |
| RF-09 | Ejecutar | Ejecución manual, programada o por ingesta produce estado y traza; respeta pausa y cuotas |
| RF-10 | Realizar acciones | El canal devuelve ID de proveedor o fallo/resultado desconocido; entrega se distingue de aceptación |
| RF-11 | Evitar duplicados | Repetir una ingesta o disparo con igual clave no genera una segunda acción del mismo propósito |
| RF-12 | Recuperar fallos | Solo se reintentan fallos transitorios seguros; resultados ambiguos pasan a conciliación |
| RF-13 | Consultar operación | Filtrar por agente, fecha y estado; ver motivo de bloqueo, intentos y resultado |
| RF-14 | Proteger contactos | Bloquear acciones sin permiso registrado para propósito/canal o con exclusión activa |
| RF-15 | Controlar consumo | Alcanzar el límite impide nuevas acciones y deja un motivo visible |
| RF-16 | Auditar cambios | Publicación, permisos, credenciales y acciones dejan evento con actor y fecha |
| RF-17 | Registro autoservicio | Crear cuenta, verificarla y acceder a un espacio aislado como administrador; un reintento de registro no duplica espacios |
| RF-18 | Elegir origen de datos | El asistente muestra Importar datos y Consumir API; solicita únicamente los campos de la ruta elegida |
| RF-19 | Seleccionar plantilla | El catálogo incluye Cobro y Promoción; aplicar una crea una copia editable sin afectar el catálogo ni otros agentes |
| RF-20 | Construir plantilla | Crear propósito, campos tipados, instrucciones y contenido; guardar para reutilizar solo dentro de su empresa |
| RF-21 | Importar archivo | Previsualizar filas, mapear columnas y ver errores; confirmar válidos o cancelar antes de incorporarlos a la fuente del agente |
| RF-22 | Reimportar de forma segura | Mismo ID y contenido no duplica registros ni acciones; cambios generan revisión de datos sin contactar automáticamente |

## 6. Historias principales

Requisitos adicionales v0.5, detallados en [Ciclo API](CICLO-API.md):

| ID | Requisito | Criterio de aceptación |
|---|---|---|
| RF-27 | Consultar y conservar API | Guardar URL/configuración versionada en BD y un archivo JSON por intento/página, también durante configuración; fallos quedan identificados sin simular datos válidos |
| RF-28 | Analizar y presentar | Mostrar campos, tipos, calidad, muestra y alcance antes de preguntar intención; análisis asociado a snapshot verificable |
| RF-29 | Recomendar acciones | Sugerir acciones según evidencia y permitir editar/rechazar/confirmar; no ejecutar sugerencias automáticamente |
| RF-30 | Preparar y programar ciclo/batch | Configurar pasos, destinatarios, límites y calendario; cada ejecución fija plan y datos y evita duplicados |
| RF-31 | Generar informe completo | Producir resumen y JSON del ciclo con etapas, acciones, fallos y resultados pendientes, incluso en fallo o sin datos |
| RF-32 | Devolver resultados a empresa | Configurar URL receptora y entregar informe autenticado; registrar aceptación y reintentar entrega sin repetir acciones |

Estos requisitos amplían el MVP. La interpretación de API de respuesta como webhook POST es propuesta a confirmar con el contrato receptor. Se conserva consulta autenticada del informe para recuperación. La simulación permite consumo explícito de datos y genera snapshots, pero no realiza contactos ni entrega informes reales a la empresa; la prueba del endpoint receptor es una acción separada con datos sintéticos.

Requisitos adicionales v0.4 (reglas detalladas en [Configuración del agente](CONFIGURACION-AGENTE.md)):

| ID | Requisito | Criterio de aceptación |
|---|---|---|
| RF-23 | Porcentaje de configuración | Mostrar suma de hitos válidos guardados, checklist y siguiente paso; 100 % significa listo para publicar |
| RF-24 | Guardado y reanudación | Conservar borrador y avance al volver; señalar errores de guardado y conflictos sin pérdida silenciosa |
| RF-25 | Identidad visual del agente | Asignar avatar predeterminado y permitir cambiarlo desde catálogo; conservarlo por versión con fallback |
| RF-26 | Configuración con movimiento natural | Transiciones de pasos y feedback de validación discretos; respetar movimiento reducido sin perder información |

Estos requisitos son parte del MVP en ambas modalidades. El detalle de hitos y porcentajes es una propuesta de implementación; rostro/avatar y avance persistente son requisitos solicitados. La personalización del avatar es opcional y no bloquea completitud. Publicar sigue siendo una acción explícita del administrador.

- Como administrador, quiero definir un agente por proceso para administrar sus instrucciones y resultados por separado.
- Como nuevo usuario, quiero registrarme y crear mi primer agente sin necesitar que un administrador externo me dé de alta.
- Como usuario, quiero elegir importar un archivo o conectar mi API según dónde tengo la información.
- Como usuario que importa datos, quiero seleccionar una plantilla de cobro o promoción, o construir una propia, para definir qué datos y comportamiento necesita mi agente.
- Como editor, quiero probar el mapeo de una API para detectar campos faltantes antes de activar el agente.
- Como operador, quiero ver si una llamada fue aceptada, contestada o fallida para decidir el siguiente paso.
- Como auditor, quiero reconstruir qué configuración produjo una acción sin acceder a secretos.
- Como contacto, quiero que mi exclusión de un canal se respete antes del próximo envío.

## 7. Reglas de negocio

- Solo versiones publicadas de agentes activos pueden producir acciones reales.
- Cada versión del agente tiene una modalidad principal: importación o API. Cambiarla crea un borrador, exige volver a mapear y simular, y no altera ejecuciones previas.
- Cargar y confirmar un archivo solo incorpora datos: las acciones requieren publicación y ejecución manual o programación explícita. El disparo automático por ingesta se conserva para integraciones API configuradas.
- Construir plantillas utiliza campos declarativos, sin código arbitrario. Las plantillas no contienen credenciales, contactos reales ni permisos de contacto implícitos.
- Una importación no dispara agentes automáticamente salvo que exista un vínculo y disparador activos.
- Un registro puede alimentar varios agentes; la deduplicación distingue agente, propósito, registro y evento.
- Los datos recibidos y las respuestas de APIs son información no confiable, nunca instrucciones con permiso para habilitar herramientas.
- Horarios se interpretan en la zona horaria configurada; fuera de ventana, la acción se difiere y se valida otra vez al enviarla.
- Pausar bloquea nuevos envíos y ejecuciones pendientes; no promete detener una acción ya aceptada por un proveedor.
- Cancelar evita acciones aún no enviadas. Las ya enviadas conservan su seguimiento.
- Se registra permiso de contacto por propósito y canal, su origen y fecha. La política final depende de los países y del caso de uso elegidos.
- No se presupone que una acción aceptada por el proveedor fue entregada o contestada.

## 8. Condición de salida del MVP

Demo de registro y acceso de dos empresas aisladas, cada una con dos agentes distintos; ruta de importación con plantilla de catálogo y plantilla propia, y ruta de consumo de API; además una integración JSON entrante. Mensajería y llamada verificadas en entorno de prueba del proveedor. QA debe cubrir aislamiento de plantillas, archivo inválido/parcial, cancelación, reimportación, duplicados, credenciales inválidas, pausa, exclusiones, cuotas, callback duplicado y timeout ambiguo. No debe haber defectos críticos o altos abiertos sin una decisión explícita y documentada de alcance que retire la funcionalidad afectada.

## 9. Decisiones pendientes

Definir primer sector y caso de uso, canales y proveedores, países, volumen esperado, presupuesto, política de retención, modalidad de identidad y si las llamadas deberán ser conversacionales. Estas decisiones condicionan estimación y salida a producción, pero permiten comenzar con simuladores y contratos.
