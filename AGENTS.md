# Reglas para agentes desarrolladores

Estas instrucciones aplican a todo el repositorio. Los agentes operativos del producto se especifican en `docs/`; los roles descritos aquí desarrollan la plataforma.

## Contexto y fuentes

Leer `README.md`, el documento relevante de `docs/` y el archivo de rol antes de trabajar. PRD define alcance; TRN contratos y arquitectura; UI/UX la experiencia; APPFLOW las transiciones. Si se contradicen, registrar el conflicto y resolverlo explícitamente; no cambiar silenciosamente el alcance.

Roles disponibles: `agents/PROYECTO.md`, `agents/FULLSTACK.md` y `agents/QA.md`. Son instrucciones reutilizables, no procesos ya instalados. No iniciar otros agentes ni trabajo paralelo automáticamente; usar el rol asignado y delegar solo cuando se solicite.

## Contrato de una tarea

Cada tarea debe indicar ID, objetivo, requisitos RF/RNF, alcance, entradas, criterios de aceptación y entregables. Cuando falte un detalle reversible, registrar el supuesto y avanzar; cuando falte una decisión que afecte contratos, gasto o alcance, documentar el bloqueo concreto.

Estados: pendiente, en curso, bloqueada, en revisión, terminada. No marcar terminada una tarea sin evidencia. Diferenciar implementado, probado con simulador y probado con proveedor.

## Reglas compartidas

### Reglas de desarrollo

- **Separación por tecnología:** PHP y HTML conviven en archivos `.php` (controladores, vistas, helpers). CSS vive en `public/assets/css/` y JavaScript en `public/assets/js/`; nunca en bloques `<style>`/`<script>` inline ni en atributos `style=""` dentro de vistas.
- **Nada de código espagueti:** la lógica de negocio va en servicios/modelos, no en vistas; las vistas solo presentan datos ya preparados. Funciones cortas con una sola responsabilidad; nombres descriptivos en inglés para código y español para el dominio visible.
- Seguir las convenciones de CodeIgniter 4 (PSR-4, filtros para autorización, migraciones para esquema) y las mejores prácticas de cada lenguaje antes que atajos.

- Preservar aislamiento por empresa y autorización del lado servidor.
- Nunca incluir secretos, tokens ni datos personales reales en repositorio, muestras o bitácoras.
- Mantener idempotencia y conciliación para acciones externas; no reenviar resultados ambiguos.
- La simulación no debe invocar adaptadores reales de mensajería o llamadas.
- No realizar llamadas/envíos reales, despliegues ni contratar servicios salvo que la tarea lo autorice.
- No sobrescribir trabajo ajeno; inspeccionar cambios existentes y limitar edición al alcance asignado.
- Mantener contratos y documentación alineados; justificar cambios de arquitectura en el registro de decisiones.
- Ejecutar verificaciones pertinentes y reportar resultados reales; no inventar pruebas ni ocultar fallos.
- Actualizar la bitácora del rol al final de cada sesión y antes de transferir una tarea. Solo anexar entradas; corregir con una nueva entrada referenciada.

## Transferencia

Entregar: tarea/estado, resumen, archivos afectados, requisitos cubiertos, evidencia y comando reproducible, pendientes/riesgos, entrada de bitácora y siguiente responsable sugerido. Una recomendación de transferencia no inicia automáticamente otro agente.

