# Plataforma generadora de agentes GPT

Base documental · Versión 0.5 · 2026-09-21 · Estado: propuesta para desarrollo.

Plataforma donde las personas se registran y configuran múltiples agentes de IA en su espacio de empresa. Al crear un agente, el asistente pregunta cómo obtendrá los datos: **importación de datos** o **consumo de API**. En la ruta de importación, el usuario selecciona una plantilla de cobro, promoción u otro propósito, o construye su propia plantilla; después carga, mapea y valida los datos. Los agentes ejecutan acciones como enviar mensajes o iniciar llamadas mediante proveedores externos.

Esta entrega define el producto y el trabajo de desarrollo; todavía no incluye una aplicación funcional ni integraciones conectadas.

Dirección visual acordada: **One UI + Bento Grid**, con estética empresarial, superficies sólidas, colores neutros y un acento azul. La guía [UI/UX](docs/UI-UX.md) define tokens, componentes, adaptación a pantallas y criterios de aceptación para todo el sitio.

## Documentos

| Documento | Contenido |
|---|---|
| [PRD](docs/PRD.md) | Objetivos, alcance, historias, requisitos y aceptación |
| [TRN](docs/TRN.md) | Arquitectura, datos, contratos, seguridad y requisitos técnicos |
| [UI/UX](docs/UI-UX.md) | Navegación, pantallas, componentes y estados |
| [Configuración del agente](docs/CONFIGURACION-AGENTE.md) | Animación natural, porcentaje persistente, autoguardado y rostro/avatar |
| [Ciclo API](docs/CICLO-API.md) | URL de consumo, archivos JSON, análisis, recomendaciones, batches, programación e informe de retorno |
| [APPFLOW](docs/APPFLOW.md) | Flujos de configuración, datos, ejecución y recuperación |
| [Plan de entrega](docs/PLAN-ENTREGA.md) | Etapas, dependencias, trazabilidad y pendientes |
| [Agentes desarrolladores](AGENTS.md) | Reglas comunes y protocolo de coordinación |
| [Proyecto](agents/PROYECTO.md) | Planificación, decisiones y seguimiento |
| [Fullstack](agents/FULLSTACK.md) | Implementación e integración |
| [QA](agents/QA.md) | Verificación, evidencia y defectos |
| [Bitácoras](bitacoras/README.md) | Formato, uso y registro por rol |

## Convenciones y supuestos

- **Empresa / tenant:** unidad de aislamiento de usuarios, agentes, datos, credenciales y consumo.
- **Agente operativo:** configuración versionada de propósito, instrucciones, fuentes, herramientas, canal y límites. No implica entrenar un modelo propio.
- **Agente desarrollador:** rol de trabajo que construye y valida esta plataforma. No atiende contactos de clientes.
- **TRN:** se interpreta aquí como documento de requisitos técnicos; confirmar si el equipo utiliza otra definición.
- El servicio web puede funcionar en ambas direcciones: recibir JSON de un sistema externo y consultar una API externa para importar datos.
- El registro autoservicio crea un espacio aislado y asigna al creador el rol administrador; es una propuesta de onboarding para conservar el modelo multiempresa.
- Una plantilla define propósito, campos y comportamiento inicial del agente. No es únicamente un archivo de datos. CSV y XLSX se proponen como formatos iniciales de importación, pendientes de validación.
- La recepción JSON sigue disponible como integración avanzada; no constituye una tercera opción principal del asistente.
- El MVP propone mensajería saliente y llamadas salientes mediante adaptadores; proveedores, países y canales concretos están pendientes de decisión.
- Las llamadas del MVP usan un guion generado y un proveedor de voz. Una conversación de voz bidireccional en tiempo real requiere una fase posterior.
- Las decisiones marcadas como propuestas deben validarse antes de contratar proveedores o comprometer fechas.

## Uso recomendado

Leer PRD → TRN → UI/UX → APPFLOW → plan de entrega. Para iniciar desarrollo, asignar una tarea delimitada al rol correspondiente usando su archivo en `agents/`. Cada rol agrega una entrada a su propia bitácora al terminar una sesión, incluso si queda bloqueado. Los archivos de rol no crean procesos ni automatizaciones por sí solos.
