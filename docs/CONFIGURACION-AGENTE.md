# Configuración del agente — Movimiento, avance y avatar

Versión 0.5 · 2026-09-21 · Especificación para implementar; no funcionalidad entregada.

## Experiencia

El agente tiene identidad visible desde que se crea el borrador. Su avatar acompaña el asistente junto a su nombre, porcentaje de configuración y siguiente tarea pendiente. Las transiciones responden a acciones reales del usuario y resultados del sistema, manteniendo el lenguaje empresarial One UI + Bento Grid.

En escritorio, una tarjeta lateral muestra avatar, nombre, barra de avance, checklist y “Continuar configuración”. En móvil se convierte en un encabezado compacto con checklist desplegable. El listado de agentes muestra el avance del borrador y permite retomarlo. Si existe una versión activa y otra en edición, distinguir “Agente activo” de “Borrador: 65 %”; el progreso no describe el estado operativo.

## Porcentaje de configuración

La fuente de verdad es el backend. El porcentaje es la suma de pesos de hitos completos, válidos y guardados; los pesos suman 100. Abrir una pantalla o esperar no aumenta el avance. Los hitos son independientes de la cantidad de pantallas del asistente.

| Hito | Peso | Condición para completarlo |
|---|---:|---|
| Identidad | 10 % | Nombre válido y avatar asignado; el avatar predeterminado cuenta |
| Modalidad y propósito | 10 % | Importación y plantilla válida; en API, modalidad elegida e intención confirmada después de ver el análisis |
| Fuente y datos | 25 % | Importación confirmada con al menos una fila válida; en API, URL guardada, snapshot JSON persistido y análisis compatible mostrado con alcance explícito |
| Comportamiento | 15 % | Instrucciones y variables válidas; en API, recomendaciones revisadas y plan de acción/batch confirmado |
| Canal y acción | 15 % | Canal, referencia de credencial y contenido/guion configurados; validación del adaptador satisfactoria sin contacto real |
| Reglas y límites | 10 % | Disparador permitido, horario/zona, cuota y permisos definidos; en API, modalidad ciclo/batch y endpoint de retorno configurados con contrato validado |
| Simulación | 10 % | Simulación satisfactoria para la configuración funcional vigente |
| Revisión | 5 % | Resumen de la revisión vigente confirmado y sin bloqueos de configuración |

Ejemplo: identidad + modalidad + datos = **45 %**. Completar además comportamiento = **60 %**. Personalizar el avatar es opcional y no otorga puntos extra. Campos opcionales no afectan el denominador.

En API el orden de hitos no obliga al usuario a decidir propósito antes de consultar: identidad + datos analizados puede sumar 35 %, y confirmar intención lo lleva a 45 %. Ver [Ciclo API](CICLO-API.md). El porcentaje del asistente no es el avance del ciclo ni la entrega del informe. Cambiar endpoint o programación invalida revisión y las validaciones dependientes.

**100 % significa configuración completa, pendiente de publicación.** No publica ni ejecuta automáticamente y no garantiza que el proveedor esté disponible o que un contacto tenga permiso. La publicación requiere rol administrador y validaciones actuales; cada ejecución sigue comprobando permisos, cuotas y disponibilidad. Un editor puede completar la revisión y ver “Configuración completa; un administrador debe publicar”.

El porcentaje puede disminuir si cambia una dependencia o pierde validez una prueba. Explicar el motivo: “Cambiaste la fuente; vuelve a validar los datos y la simulación”. Navegar hacia atrás sin editar no invalida nada. Cambiar solo nombre/avatar conserva la simulación funcional, pero invalida la revisión final; cambiar modalidad, mapeo, instrucciones, canal o reglas invalida los hitos afectados, simulación y revisión. Una desconexión operativa de un agente publicado se muestra como alerta operativa y no reescribe su snapshot histórico.

## Guardado y reanudación

Autoguardar cambios de borrador tras una pausa breve de edición —propuesta: 700 ms— y al continuar. Diferenciar “Guardando…”, “Guardado” y “No se pudo guardar; reintentar”. El porcentaje confirmado se actualiza solo cuando responde el servidor; cambios locales pendientes no se presentan como persistidos. No almacenar credenciales en almacenamiento del navegador.

Al volver, cargar la revisión guardada, su checklist y último paso visitado si sigue siendo aplicable; ofrecer el primer hito incompleto como próximo paso. Cambiar de dispositivo conserva el avance guardado. Avisar al salir con cambios sin guardar. Si dos sesiones editan la misma revisión, responder conflicto y permitir revisar/recargar sin sobrescribir silenciosamente.

Las pruebas asíncronas se asocian a la revisión/hash de configuración que probaron. Si terminan después de otra edición, su resultado queda histórico y no acredita el borrador nuevo. Guardar contenido incompleto es válido; completar un hito exige validación.

## Movimiento natural

| Interacción | Movimiento propuesto | Límite funcional |
|---|---|---|
| Seleccionar Importación/API o plantilla | Borde/fondo y pequeña respuesta de presión, 120–160 ms | Selección inmediata, sin retrasar el clic |
| Avanzar o retroceder de paso | Desvanecimiento y desplazamiento horizontal de 8–12 px, 180–240 ms | Mantener orden y llevar foco al título del paso; sin secuencias en cola |
| Mostrar campos dependientes | Aparición suave de 160–200 ms | Reservar espacio cuando sea posible; no desplazar el campo enfocado |
| Completar un hito | Check y actualización de barra, 200–300 ms | Animar exclusivamente hacia el valor confirmado; sin avance ficticio |
| Guardado o validación | Icono y texto de estado discretos | No inventar porcentaje de operación cuando se desconoce el total |
| Error | Borde, mensaje y foco pertinente | Sin sacudidas, destellos ni gestos de alarma exagerados |

Usar desaceleración suave, propuesta `cubic-bezier(0.2, 0, 0, 1)`, sin rebotes. Priorizar transformaciones y opacidad; evitar animar toda la retícula o reiniciar animaciones al escribir. El siguiente paso no espera a que termine una animación. La barra de configuración es distinta al progreso de carga del archivo o de procesamiento del lote, que debe llevar etiqueta propia.

Con movimiento reducido, eliminar desplazamientos, escalados y gestos; mostrar estados estáticos o cambio de opacidad mínimo. No usar animaciones decorativas infinitas. Anunciar cambios de hito mediante un mensaje accesible sin leer cada frame ni cada pulsación. La barra expone nombre, mínimo 0, máximo 100 y valor actual.

## Rostro o avatar

Cada agente recibe por defecto un rostro abstracto de asistente, con geometría simple, fondo sólido y tonos neutros. Propuesta MVP: catálogo pequeño de avatares propios con variantes de rostro, sin necesitar generación de imágenes ni fotos personales. El usuario puede cambiarlo en Identidad y ver una previsualización. La carga de fotos, generación con IA y animación facial realista quedan como ampliaciones pendientes, no requisitos de este cambio.

Tamaños orientativos: 40 px en listado, 64 px en encabezado y 96 px en la tarjeta del asistente. Mantener contraste y silueta reconocible. Las variantes se diferencian por formas y rasgos, no por colores saturados. El avatar no cambia voz, instrucciones ni permisos.

| Estado de configuración | Representación |
|---|---|
| En edición | Rostro neutral y texto con siguiente paso |
| Validando | Indicador contiguo y “Validando datos…”; sin aparentar escucha o llamada |
| Hito completado | Un gesto mínimo de asentimiento o check, máximo 300 ms, una sola vez |
| Requiere corrección | Rostro neutral, icono y mensaje claro con vínculo al campo |
| Configuración completa | Avatar estable y check con “Listo para publicar” |

Un avatar de catálogo puede usar SVG local controlado por el producto; no aceptar SVG arbitrario de usuarios. Si el recurso falla, mostrar fallback de iniciales o silueta, conservando el espacio. Junto al nombre visible el avatar puede ser decorativo; si funciona como botón, debe tener etiqueta “Cambiar avatar de [nombre]”. El estado nunca depende de la expresión facial.

## Contrato técnico

El borrador conserva `draft_revision`, `input_mode`, `avatar_id` autorizado, `last_visited_step` y `configuration_schema_version`. El backend calcula `configuration_progress` con `percentage`, `milestones` (ID, peso, estado, motivo), `next_step`, `evaluated_revision` y `updated_at`. No aceptar porcentajes enviados por el cliente. Los hitos usan estados pending/validating/complete/invalid y evidencias de validación asociadas a hashes de sus dependencias.

Mantener pesos versionados para que un cambio de reglas no altere silenciosamente borradores existentes; una migración debe recalcular y explicar hitos nuevos. Las revisiones publicadas conservan identidad/avatar y snapshot de validación; editar el avatar crea cambio en borrador como los demás ajustes.

| Ruta propuesta | Contrato |
|---|---|
| GET /api/v1/agent-avatars | Catálogo de IDs y recursos controlados por el producto |
| GET /api/v1/agents/{id}/configuration-progress | Progreso calculado de su borrador, aislado por empresa |
| PATCH /api/v1/agents/{id} | Guardado parcial con revisión esperada; devuelve nueva revisión y progreso; `409` en conflicto |
| POST /api/v1/agents/{id}/review | Confirmar revisión exacta tras validar hitos previos; no publica ni envía acciones |

Pruebas API y de adaptador requeridas para hitos se ejecutan por acciones explícitas; el autoguardado no llama repetidamente a proveedores. `publish` vuelve a evaluar completitud y precondiciones, sin confiar en la barra ni el estado del navegador.

## Aceptación

- UX-07: transiciones naturales y breves, sin bloquear interacción, saltos de foco ni movimiento decorativo continuo; alternativa con movimiento reducido.
- UX-08: porcentaje y checklist persistentes, con cálculo reproducible y mismo resultado en las dos modalidades; 100 % no activa el agente.
- UX-09: avatar presente en creación, listado y detalle, editable desde catálogo y con fallback; estados accesibles mediante texto.
- AT-20: verificar 0 %, 45 %, 60 % y 100 % según hitos, campos opcionales, ambas rutas, regresión por cambio de fuente y publicación separada.
- AT-21: guardar/recargar, cambiar dispositivo, fallo de red, conflicto de sesiones y validación tardía; no incrementar avance por cambios sin guardar.
- AT-22: seleccionar avatar, persistir y publicar, probar recurso faltante, teclado y movimiento reducido; revisar transiciones y separación de porcentaje de configuración/carga.
