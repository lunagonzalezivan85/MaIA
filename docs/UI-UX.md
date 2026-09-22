# UI/UX — Experiencia de administración

Versión 0.5 · 2026-09-21. Especificación funcional y dirección visual; no contiene una interfaz implementada.

## Dirección visual obligatoria: One UI + Bento Grid

Todo el sitio tendrá una estética empresarial inspirada en Samsung One UI: títulos claros, controles cómodos, esquinas redondeadas, secciones agrupadas y superficies sólidas. Bento Grid organiza resúmenes y módulos en una retícula alineada con tamaños según importancia. Esta decisión aplica a registro, acceso, bienvenida, paneles, asistentes, tablas, configuración y estados de error.

El objetivo es una interfaz sobria, limpia y reconocible como una misma familia visual. No usar glassmorphism, blur decorativo, paneles transparentes, degradados multicolor, neón, brillos ni una tarjeta de distinto color por módulo. La profundidad se comunica mediante superficie, borde y una sombra discreta. Tampoco usar neumorfismo que desdibuje los límites de controles.

One UI es la referencia de lenguaje visual y Bento Grid es el patrón de composición; no son dos temas alternativos. No hace falta incorporar otra estética de moda. Se complementan con patrones empresariales de navegación lateral, tablas de datos, formularios agrupados y paneles de detalle. La marca, textos e iconos serán propios; no se requiere reproducir logotipos ni recursos propietarios de Samsung.

### Tokens iniciales del producto

Estos valores son una propuesta propia para implementación, no tokens oficiales de Samsung. El tema claro es el inicial; el oscuro se implementa usando los mismos roles si se incorpora, sin retrasar el MVP por ese motivo.

| Rol | Tema claro | Tema oscuro propuesto |
|---|---|---|
| Fondo general | `#F5F6F8` | `#111318` |
| Superficie de tarjeta | `#FFFFFF` | `#1B1E25` |
| Superficie secundaria | `#ECEFF3` | `#252A34` |
| Texto principal | `#171A21` | `#F3F4F6` |
| Texto secundario | `#596273` | `#B7BFCC` |
| Borde decorativo | `#DDE2E9` | `#363D49` |
| Borde de control | `#7B8493` | `#7F8A9C` |
| Acento y foco | `#2457C5` | `#9BB8FF` |
| Texto sobre botón primario | `#FFFFFF` | `#111318` |

Usar un único acento azul para acción principal, selección y foco. Éxito, advertencia y error admiten colores semánticos discretos, siempre con texto e icono; no convierten tarjetas enteras en superficies saturadas. Gráficos usan grises y azul, etiquetas directas y patrones de línea; distinguir series sin depender solo del color. Validar contraste de cada combinación realmente utilizada, incluidos estados interactivos.

### Tipografía, geometría y densidad

- Fuente inicial: `system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif`; no depender de SamsungOne.
- Título de página: 32 px/40 px en escritorio y 28 px/36 px en móvil, peso 700. Sección: 20 px/28 px, peso 600. Cuerpo: 16 px/24 px; datos de tabla: 14 px/20 px; ayudas: 12 px/18 px como mínimo.
- Escala de espaciado: 4, 8, 12, 16, 24, 32 y 48 px. Padding de tarjetas: 24 px en escritorio y 16 px en móvil.
- Radio: tarjetas principales 24 px, grupos secundarios 16 px, campos y botones 12 px. Píldoras solo para estados y filtros breves.
- Controles de formulario y botones principales: altura mínima 44 px. Iconos de línea coherentes de 20–24 px, sin emojis decorativos como sistema de navegación.
- Sombra opcional única: `0 2px 8px rgb(17 24 39 / 4%)`; sin sombras volumétricas ni efectos luminosos.
- Densidad cómoda por defecto; tablas pueden ofrecer modo compacto manteniendo controles accesibles. Encabezados amplios sin ocupar media pantalla de trabajo.

### Composición responsive

Escritorio desde 1200 px: navegación lateral de 240 px y contenido con máximo de 1440 px, retícula de 12 columnas y separación de 24 px. Tableta de 768 a 1199 px: navegación plegable, 8 columnas y separación de 16 px. Móvil por debajo de 768 px: menú en cajón, 4 columnas y tarjetas apiladas, márgenes de 16 px. El ancho disponible del contenido determina el ajuste final.

Bento usa filas de altura automática y tarjetas con spans previsibles; evitar masonry y reordenamientos visuales que contradigan la lectura o el teclado. No fijar alturas que corten texto. Mantener título y acción principal visibles, con orden lógico en el DOM. Las barras de acción fijas deben reservar espacio y no tapar foco ni contenido.

| Área | Aplicación del patrón |
|---|---|
| Registro y acceso | Una tarjeta de formulario; bloque de contexto sobrio en pantallas amplias, sin collage decorativo |
| Resumen | Indicadores compactos arriba; actividad ocupa 8 columnas y consumo/estado 4; avisos solo cuando requieren acción |
| Agentes y plantillas | Tarjetas homogéneas con nombre, propósito, estado y acción; tamaños distintos solo si comunican prioridad real |
| Elección Importación/API | Dos tarjetas seleccionables con icono, título y explicación; borde y control de selección visibles |
| Asistente | Formulario principal de 8 columnas y resumen de 4; una columna en móvil; cada sección agrupa campos relacionados |
| Ejecuciones y auditoría | Tabla de ancho completo dentro de una superficie; filtros agrupados y detalle lateral o página dedicada |
| Configuración | Listas de ajustes agrupadas, con títulos, descripción y controles alineados, inspiradas en One UI |

No fragmentar filas de auditoría ni matrices de importación en pequeñas tarjetas Bento. En móvil, mostrar resumen por registro con expansión; si la comparación entre columnas lo exige, usar desplazamiento horizontal dentro de la tabla con encabezados claros.

### Componentes y estados

Una biblioteca compartida define botones primario/secundario/texto/destructivo, campos, selector, tarjetas, grupos de ajustes, tabla, pestañas, pasos del asistente, diálogos, alertas y etiquetas de estado. Mostrar hover, foco, selección, carga, error y deshabilitado con reglas consistentes. Priorizar una acción principal por sección de trabajo. Las tarjetas seleccionables usan semántica de radio/checkbox y teclado; no depender de clic en un contenedor sin nombre accesible.

Animaciones discretas de 120–200 ms para feedback local; las transiciones de paso y avance tienen tiempos específicos de hasta 300 ms. Sin parallax ni entradas constantes. Respetar preferencia de movimiento reducido y conservar geometría durante carga. La especificación [Configuración del agente](CONFIGURACION-AGENTE.md) define movimiento natural, avatar, porcentaje persistente, hitos y reanudación; sus criterios UX-07 a UX-09 complementan esta guía.

### Aceptación visual

- UX-01: todas las rutas, incluido registro y errores, comparten tokens, tipografía y componentes.
- UX-02: neutros dominantes, un acento y color semántico puntual; cero glassmorphism, neón o degradados decorativos.
- UX-03: Bento mantiene alineación y orden de lectura; tablas y formularios conservan su estructura funcional.
- UX-04: verificar a 360, 768, 1280 y 1440 px; sin desbordamiento de página, texto truncado imprescindible ni acciones ocultas.
- UX-05: objetivos de contraste de 4.5:1 para texto normal y 3:1 para texto grande/controles relevantes; foco visible, teclado, zoom 200 % y movimiento reducido. Las combinaciones finales deben medirse, no darse por aprobadas por usar tokens.
- UX-06: revisar estados vacío, carga, error, parcial, seleccionado y bloqueado en las dos modalidades del asistente.

### Referencias

Inspiración de consistencia y comodidad entre dispositivos: [Samsung Developer — One UI](https://developer.samsung.com/one-ui/index.html). Referencia de geometría redondeada: [Samsung — Iconography background](https://developer.samsung.com/one-ui/iconography/background.html). La adaptación web, retícula Bento, paleta y medidas anteriores son decisiones del producto; no pretenden reproducir una versión específica del sistema operativo.

## Principios

Permitir configurar un agente sin escribir código, explicar el efecto de activarlo y hacer visibles errores recuperables. Usar español claro, conservar borradores y separar la simulación de las acciones reales. Mostrar siempre empresa activa, estado del agente y zona horaria relevante.

## Navegación

Menú principal: Resumen, Agentes, Plantillas, Fuentes de datos, Ejecuciones, Permisos de contacto, Auditoría y Configuración. Selector de empresa solo para usuarios con varias membresías; al cambiar, limpiar cachés y selección de recursos. Configuración contiene miembros, credenciales, canales y límites según permisos.

| Pantalla | Contenido y acción principal |
|---|---|
| Acceso | Inicio de sesión y errores sin revelar existencia de cuentas |
| Registro y recuperación | Crear cuenta, verificar correo, reenviar verificación y recuperar acceso; después configurar nombre del espacio y zona horaria |
| Bienvenida | Explicar las dos modalidades y ofrecer “Crear mi primer agente” |
| Plantillas | Catálogo Cobro/Promoción y Mis plantillas; previsualizar campos, seleccionar, crear o editar una propia |
| Constructor de plantilla | Nombre, propósito, campos tipados, instrucciones y mensaje/guion con variables; validar y guardar |
| Importación | Cargar archivo, seleccionar hoja si aplica, mapear columnas, revisar filas y confirmar válidos o cancelar |
| Resumen | Agentes activos, ejecuciones por resultado, cola y consumo; crear agente |
| Agentes | Nombre, propósito, canal, estado, última ejecución; buscar, filtrar y crear |
| Editor de agente | Asistente con pasos, guardado de borrador y validación contextual |
| Detalle de agente | Versión publicada, borrador, fuentes y actividad; simular, publicar, pausar o archivar |
| Fuentes | Tipo archivo/API, estado, última carga o sincronización y conteos; integración JSON como opción avanzada |
| Editor de fuente | URL, autenticación, parámetros, mapeo y prueba de conectividad |
| Ejecuciones | Agente, disparador, fechas, estado, duración y costo; filtros y paginación |
| Detalle de ejecución | Línea de tiempo, datos redactados, versión, acciones, intentos y error |
| Permisos de contacto | Buscar identificador, consultar propósito/canal, registrar evidencia y revocar |
| Auditoría | Actor, fecha, recurso y operación; filtros según permisos |
| Configuración | Usuarios, metadatos de credenciales, canales, zona horaria y cuotas |

## Asistente de creación

1. **Nombre, avatar y origen:** nombre del agente, rostro predeterminado editable y pregunta “¿Cómo obtendrá los datos tu agente?”. Dos tarjetas: “Importar datos — carga un archivo” y “Consumir API — conecta tu sistema”. Mostrar porcentaje guardado y checklist desde el inicio.
2. **Ruta de importación:** elegir Cobro, Promoción, una plantilla propia o “Construir plantilla”. Mostrar propósito, campos y contenido de ejemplo antes de elegir. En el constructor definir campos con nombre, tipo y obligatoriedad, instrucciones y variables. Ofrecer descargar un archivo de ejemplo vacío.
3. **Datos según ruta:** en importación, cargar archivo, mapear y confirmar válidos. En API, solicitar URL, método y autenticación; “Consultar y analizar” consume, conserva archivo JSON y muestra campos, conteos, calidad y muestra antes de definir propósito. Mostrar si el análisis es parcial y permitir ver/descargar JSON autorizado.
4. **Intención, recomendaciones y acciones:** después del análisis API preguntar “¿Qué quieres hacer con estos datos?”. Mostrar sugerencias con explicación, requisitos faltantes y botones para elegir, editar o descartar; permitir objetivo propio. Preparar una acción o batch, ajustar instrucciones, contenido, canal, filtros y orden. Mostrar conteos y omisiones sin enviar nada. Importación conserva el propósito de su plantilla.
5. **Programación, retorno y límites:** configurar ejecución manual, fecha única o recurrencia; distinguir ciclo con datos nuevos de batch fijado. API también conserva disparador por ingesta explícito. Configurar ventana, zona, cuota y permisos. Pedir URL receptora del informe y autenticación; rotularla “API de respuesta de tu empresa”, separada de “API de consumo”. Prueba de entrega con datos sintéticos y acción explícita.
6. **Prueba:** usar datos sintéticos y revisar contenido/acción. Aviso persistente: “Simulación: no se enviarán mensajes ni se realizarán llamadas”.
7. **Revisión:** resumir modalidad, plantilla si aplica, fuente, destinatarios, permisos y límites. Publicar solo para administrador. Importar o seleccionar plantilla nunca equivale a activar envíos.

Cambiar modalidad conserva el agente como borrador y solicita rehacer la configuración dependiente; avisar qué mapeo se invalidará antes de cambiar. El historial y la versión publicada permanecen disponibles.

Una prueba real es una ejecución diferenciada: requiere agente publicado, contacto autorizado y confirmación con destinatario/canal visibles. El botón no se denomina “simular”.

### Pantallas del ciclo API

Especificación completa en [Ciclo API](CICLO-API.md). Añadir: panel Bento de análisis con métricas y tabla de campos; recomendaciones seleccionables con evidencia; vista previa de batch con filtros, pasos y omisiones; programación con próxima fecha local; configuración de retorno; detalle de ciclo con línea de tiempo “Consumir → Analizar → Preparar → Ejecutar → Informe”. Mostrar “Resultado del ciclo” y “Entrega a empresa” como estados diferentes. Una entrega fallida ofrece “Reintentar entrega del informe”, nunca un botón ambiguo que repita acciones. Avatar y porcentaje de configuración permanecen visibles; el avance del ciclo es un indicador distinto.

## Boceto estructural

```text
[Empresa de ejemplo ▼]                       [Usuario]
Resumen | Agentes | Plantillas | Fuentes | Ejecuciones

[Avatar] Cobro de facturas             Estado: Borrador
Configuración: 45 %                   Guardado
Siguiente: definir comportamiento     [Ver checklist]
Origen > Plantilla > Datos > Comportamiento > Límites > Prueba

¿Cómo obtendrá los datos tu agente?
[Importar datos]                      [Consumir API]

Plantilla: [Cobro] [Promoción] [Mis plantillas] [Construir]
Archivo: facturas.csv                 [Cargar archivo]
Filas: 95 válidas · 3 con errores · 2 duplicadas
[Ver errores]                        [Confirmar importación]

[Guardar borrador]                            [Continuar]
```

## Estados y mensajes

| Situación | Comportamiento |
|---|---|
| Lista vacía | Explicar qué es el recurso y ofrecer crearlo si tiene permiso |
| Carga | Indicador de progreso; impedir doble envío, conservar contexto |
| Sin permiso | Vista limitada y explicación del rol necesario |
| Error de campo | Mensaje junto al campo y foco en el primer error |
| Error de API externa | “La fuente no respondió. Revisa la conexión o vuelve a intentar”; incluir ID de referencia |
| Credencial inválida | “La credencial fue rechazada”; enlazar a rotación para administrador |
| Lote parcial | Mostrar aceptados/rechazados y errores por registro |
| Archivo inválido | Explicar formato o límite; conservar plantilla y permitir reemplazar archivo |
| Vista previa parcial | Mostrar filas válidas, rechazadas y duplicadas; confirmar solo las válidas o corregir antes de continuar |
| Registro sin verificar | Mostrar reenvío de verificación y no permitir acciones reales |
| Resultado ambiguo | “El proveedor puede haber recibido la acción. Estamos verificando el resultado”; deshabilitar reenvío inseguro |
| Cuota agotada | Mostrar límite alcanzado y acciones bloqueadas; no prometer reanudación automática |
| Pausa | Explicar que las acciones ya aceptadas continúan su seguimiento |
| Conflicto al guardar | Avisar de otra edición; permitir recargar sin sobrescribir silenciosamente |

Credenciales se muestran como “Configurada · actualizada el …”; jamás se revela el secreto guardado. Los errores técnicos completos van a observabilidad protegida, no al navegador.

## Accesibilidad y adaptación

Formularios con etiquetas, ayuda asociada, navegación por teclado y foco visible. Estados con texto e icono además de color; avisos de cambios accesibles. Tablas se convierten en tarjetas en móvil; detalles extensos se expanden. Confirmaciones muestran la acción específica y permiten cancelar. Mantener filtros en navegación y distinguir UTC de hora local cuando sea relevante.

## Validación de usabilidad

Probar con al menos tres usuarios representativos: registrarse, escoger modalidad, crear un agente de cobro desde catálogo, construir una plantilla de promoción propia, importar y corregir datos, y conectar una API. Después simular, encontrar un fallo y pausar. Registrar tiempo, errores y bloqueos. Criterio inicial: todos distinguen importación, simulación y ejecución real, y pueden identificar errores de filas o ejecución sin ayuda del desarrollador.
