# Bitácora — Fullstack

## FULLSTACK-20260921-001
- Fecha: 2026-09-21; zona de referencia America/Managua.
- Autor: asistente principal, inicialización del registro; no sesión de implementación.
- Tarea: preparación para T-002.
- Estado: pendiente.
- Trabajo realizado: creado el archivo de rol y esta bitácora para futuras sesiones.
- Referencias: `agents/FULLSTACK.md`, `docs/TRN.md` y `docs/PLAN-ENTREGA.md`.
- Implementación y pruebas: no ejecutadas; esta entrega es documental.
- Pendientes: elegir stack, identidad, infraestructura y proveedores.
- Siguiente paso: recibir una tarea delimitada con criterios de aceptación.

## FULLSTACK-20260921-002
- Fecha: 2026-09-21 18:00 -06:00; zona de referencia America/Managua.
- Autor o rol ejecutor: Fullstack (asistente Devin).
- Tarea y requisitos RF/RNF/AT: preparación del entorno de desarrollo; soporte a T-002 (base técnica). Sin RF/AT directos.
- Estado: terminada (entorno local verificado).
- Objetivo: dejar operativo PHP + CodeIgniter 4 sobre XAMPP para iniciar el desarrollo.
- Entradas y versión/commit revisado: `README.md`, `docs/TRN.md`, `docs/PLAN-ENTREGA.md` v0.5; repositorio sin código previo.
- Trabajo realizado:
  - Verificado PHP 8.2.12 (ZTS x64) en `C:\xampp\php\php.exe`; extensiones requeridas presentes: intl, mbstring, curl, mysqli, mysqlnd, openssl, json.
  - Instalado Composer 2.10.3 en `C:\xampp\php\composer.phar` con wrapper `C:\xampp\php\composer.bat`; añadido `C:\xampp\php` al PATH de usuario.
  - Creado proyecto CodeIgniter 4.7.4 (appstarter) en `platform/` para no mezclar el esqueleto con la documentación raíz.
  - Creado `platform/.env` (no versionado): `CI_ENVIRONMENT=development`, `app.baseURL=http://localhost:8080/`, conexión MySQLi a `maia` y `maia_test` (root sin contraseña, default XAMPP).
  - Iniciado MySQL de XAMPP (`mysql_start.bat`); creadas bases `maia` y `maia_test` en utf8mb4.
- Archivos modificados: `platform/` (esqueleto completo), `platform/.env`, `C:\xampp\php\composer.phar`, `C:\xampp\php\composer.bat`, PATH de usuario.
- Decisiones y supuestos: el usuario indicó PHP + CodeIgniter 4; se registra como propuesta de stack para DEC-05 (pendiente de confirmación formal por Proyecto). Se usa MariaDB/MySQL de XAMPP aunque TRN sugiere PostgreSQL como candidata; diferencia por resolver en DEC-05. La app vive en `platform/`; el front controller queda en `platform/public/`.
- Verificaciones: `php -v` → 8.2.12; `composer --version` → 2.10.3; `php spark serve` + `Invoke-WebRequest http://localhost:8080` → HTTP 200, "Welcome to CodeIgniter 4.7.4", Environment: development. Evidencia: salida del servidor de desarrollo.
- Fallos o bloqueos: PHP y Composer no estaban en PATH; resuelto. Apache no se inició; se verificó con `spark serve` en puerto 8080.
- Riesgos y limitaciones: MariaDB ≠ PostgreSQL del TRN (DEC-05 abierta); credenciales root vacías solo para desarrollo local, nunca producción; Apache de XAMPP requiere vhost/DocumentRoot a `platform/public/` si se prefiere sobre `spark serve`.
- Siguiente paso y responsable sugerido: Proyecto confirma DEC-05 (stack y BD); Fullstack inicia T-002 (base técnica, migraciones, empresa/roles) una vez confirmado.

## FULLSTACK-20260921-003
- Fecha: 2026-09-21 18:10 -06:00; zona de referencia America/Managua.
- Autor o rol ejecutor: Fullstack (asistente Devin).
- Tarea y requisitos RF/RNF/AT: estructura inicial de base de datos; avance parcial de T-002. Cubre modelo de datos TRN §2, entidades CICLO-API §6 y campos de borrador de CONFIGURACION-AGENTE.
- Estado: en curso (estructura creada y verificada; sin lógica de aplicación ni endpoints).
- Objetivo: materializar el modelo de datos documental como migraciones CodeIgniter 4 ejecutables y revertibles.
- Entradas y versión/commit revisado: `docs/TRN.md` §2/§5, `docs/CICLO-API.md` §6, `docs/CONFIGURACION-AGENTE.md` (contrato técnico), `docs/PRD.md` §1/§2 (roles y plantillas).
- Trabajo realizado:
  - 9 migraciones en `platform/app/Database/Migrations/` creando 34 tablas: identidad (tenants, users, memberships, auth_tokens), catálogos (agent_avatars, templates, template_versions), fuentes (secret_references, data_sources, connectors, connector_versions, import_jobs), agentes (agents, agent_versions, agent_source_bindings, action_plans, action_plan_versions, result_endpoint_versions), ciclo (cycle_runs, api_snapshots, analysis_results, analysis_result_snapshots, action_batches, schedules), ingesta (ingestion_batches, source_records), ejecución (executions, actions, action_attempts, provider_events, outbox_events), informes (run_reports, report_deliveries) y gobierno (contact_permissions, usage_ledger, audit_events).
  - Restricciones únicas del TRN implementadas: (tenant_id, source, ingestion_key), (tenant_id, source, external_id, event_version), (tenant_id, execution_dedupe_key), (tenant_id, provider, provider_event_id) y dedupe de acciones.
  - Seeder `CatalogSeeder`: 6 avatares de catálogo y plantillas de sistema Cobro/Promoción con campos propuestos del PRD (versión 1 publicada).
- Archivos modificados: `platform/app/Database/Migrations/2026-09-21-180001..180009_*.php`, `platform/app/Database/Seeds/CatalogSeeder.php`.
- Decisiones y supuestos:
  - PK interna BIGINT + `public_id` CHAR(36) para ID opaco por recurso.
  - Estados como VARCHAR validados en aplicación (no ENUM) para evolución sin ALTER.
  - `schedules.target_id` polimórfico sin FK (target_type cycle|batch|binding); `agents.published_version_id` y `connectors.published_version_id` sin FK por referencia circular, se resuelven en código.
  - `actions.recipient_protected`/`contact_hash` reservan protección del destinatario; cifrado concreto pendiente del gestor de secretos.
- Verificaciones: `php spark migrate --all` → 9 migraciones OK; `SHOW TABLES` en `maia` → 34 tablas; `php spark db:seed CatalogSeeder` → 6 avatares y 2 plantillas system publicadas con versiones. Comando reproducible: `cd platform && php spark migrate --all && php spark db:seed CatalogSeeder`.
- Fallos o bloqueos: ninguno.
- Riesgos y limitaciones: esquema sobre MariaDB (DEC-05 pendiente; TRN sugiere PostgreSQL). FKs entre empresas se refuerzan con tenant_id, pero la autorización real es responsabilidad del backend (RNF-01). Campos exactos de plantillas son propuesta (DEC-09).
- Siguiente paso y responsable sugerido: Fullstack continúa T-002 con modelos/entidades y controles de empresa/roles; QA puede preparar matriz de aislamiento (T-003) sobre este esquema.

## FULLSTACK-20260921-004
- Fecha: 2026-09-21 18:15 -06:00; zona de referencia America/Managua.
- Autor o rol ejecutor: Fullstack (asistente Devin).
- Tarea y requisitos RF/RNF/AT: internacionalización por empresa; soporte a T-002 y al endpoint `/tenant-settings` del TRN §3.
- Estado: terminada (estructura verificada; resolución de locale por tenant pendiente de implementar en middleware).
- Objetivo: cada empresa define su zona horaria e idioma; la aplicación dispone de archivos de idioma PHP.
- Entradas: `docs/TRN.md` §2/§3 (Tenant: zona horaria; tenant-settings), solicitud del usuario.
- Trabajo realizado:
  - Migración `2026-09-21-180010_AddLocaleToTenants`: columna `locale` VARCHAR(10) default 'es' en `tenants` (timezone ya existía).
  - `app/Config/App.php`: `defaultLocale='es'`, `supportedLocales=['es','en']`.
  - Archivos de idioma `app/Language/es/` y `app/Language/en/`: App, Auth, Agents, Imports, Api, Executions, Settings, Errors; claves alineadas al vocabulario del dominio (estados de TRN §5, hitos de CONFIGURACION-AGENTE, códigos de error del contrato).
- Archivos modificados: migración indicada, `platform/app/Config/App.php`, 16 archivos en `platform/app/Language/{es,en}/`.
- Decisiones y supuestos: español como idioma por defecto (documentación del producto en español); `negotiateLocale` sigue en false — el locale debe resolverse desde `tenants.locale` en middleware/filtro, no desde Accept-Language, para respetar la configuración de la empresa.
- Verificaciones: `php spark migrate` → columna `locale` creada (verificado con `SHOW COLUMNS FROM tenants`); `php -l` sobre los 16 archivos de idioma → sin errores de sintaxis.
- Fallos o bloqueos: ninguno.
- Riesgos y limitaciones: las cadenas cubren el vocabulario del MVP; nuevas pantallas deben agregar claves en ambos locales.
- Siguiente paso y responsable sugerido: Fullstack implementa resolución de locale por tenant y endpoints `/tenant-settings` (GET/PATCH) dentro de T-002.

## FULLSTACK-20260921-005
- Fecha: 2026-09-21 18:20 -06:00; zona de referencia America/Managua.
- Autor o rol ejecutor: Fullstack (asistente Devin).
- Tarea y requisitos RF/RNF/AT: archivo de menús de navegación; soporte a T-002 y UX-01 (navegación del sitio).
- Estado: terminada.
- Objetivo: definir menús por contexto en `app/Config/Menu.php`.
- Trabajo realizado: creada clase `Config\Menu` con tres menús — `admin` (administrador de empresa: panel, agentes, plantillas, fuentes, ejecuciones, configuración, miembros, credenciales, auditoría), `tenant` (miembros con roles editor/operator/auditor; cada ítem declara `roles` para filtrado en backend) y `public` (login, registro, recuperación). Los `label` referencian claves de idioma existentes (`App.nav.*`, `Auth.*`, `Settings.*`).
- Archivos modificados: `platform/app/Config/Menu.php`.
- Decisiones y supuestos: se interpretó "Menu admin" como administrador de empresa y "Menu Tenant" como miembros no administradores; no existe rol de soporte interno en el MVP (PRD §2). Si se quería un menú de plataforma global, ajustar `Menu::$admin`. Las rutas son propuestas pendientes de las pantallas UI-UX; los iconos refieren a un catálogo por definir.
- Verificaciones: `php -l` sin errores; las 12 claves de idioma referenciadas existen en `app/Language/es/` (paridad en `en/`).
- Fallos o bloqueos: ninguno.
- Riesgos y limitaciones: el filtrado por rol en `tenant` es declarativo; la autorización real sigue siendo responsabilidad del backend (RNF-01).
- Siguiente paso y responsable sugerido: Fullstack integra los menús al layout/base controller cuando se construyan las pantallas.

## FULLSTACK-20260921-006
- Fecha: 2026-09-21 18:25 -06:00; zona de referencia America/Managua.
- Autor o rol ejecutor: Fullstack (asistente Devin).
- Tarea y requisitos RF/RNF/AT: dos layouts con separación público/privado; soporte a T-002 y UX-01.
- Estado: terminada (separación verificada con servidor en ejecución).
- Objetivo: crear versión admin con dos layouts garantizando que el área pública y la privada no se crucen.
- Trabajo realizado:
  - Layouts `app/Views/layouts/public.php` y `app/Views/layouts/admin.php` con estética neutra (superficies sólidas, acento azul; base One UI + Bento Grid provisional).
  - Filtros `AuthFilter` (sin sesión → /login), `GuestFilter` (con sesión → /dashboard) y `RoleFilter` (`role:admin,editor` → 403); registrados en `Filters.php`.
  - Rutas en dos grupos: público con filtro `guest` (/, login, register, recovery + POST stub) y privado con filtro `auth` (dashboard, secciones del menú, `/settings/*` además con `role:admin`).
  - Controladores `Site\Home`, `Site\Auth`, `Admin\Dashboard`, `Admin\Placeholder`; helper `menu_helper` con `menu_items()` y `private_menu_items()` (admin o tenant filtrado por rol de sesión).
  - `indexPage` vacío para URLs limpias; helpers `menu`, `url`, `form` en BaseController; claves `Auth.pending`, `App.public.tagline`, `App.msg.sectionWip` en es/en.
- Archivos modificados: `app/Config/Routes.php`, `app/Config/Filters.php`, `app/Config/App.php`, `app/Controllers/BaseController.php`, `app/Helpers/menu_helper.php`, `app/Filters/{Auth,Guest,Role}Filter.php`, `app/Controllers/Site/*`, `app/Controllers/Admin/*`, `app/Views/layouts/*`, `app/Views/site/*`, `app/Views/admin/*`, idiomas es/en.
- Decisiones y supuestos: los POST de autenticación devuelven el formulario con aviso `Auth.pending` — la verificación real queda para T-002/T-010; no se simula login. El rol se lee de `session('role')`; la fuente real será memberships.
- Verificaciones: `php -l` en todo `app/` sin errores. curl: `/` `/login` `/register` `/recovery` → 200; `/dashboard` `/agents` `/settings` `/settings/members` `/logout` → 302 → `/login`. HTML de /login renderiza layout público con menú público.
- Fallos o bloqueos: ninguno.
- Riesgos y limitaciones: separación visual/de rutas lista; la autenticación real aún no existe, por lo que el área admin solo es accesible tras implementar login. Revisar menú tenant por rol cuando existan sesiones reales.
- Siguiente paso y responsable sugerido: Fullstack implementa registro/login real (RF-17, T-010) sobre estos layouts y filtros.

## FULLSTACK-20260921-007
- Fecha: 2026-09-21 18:35 -06:00; zona de referencia America/Managua.
- Autor o rol ejecutor: Fullstack (asistente Devin).
- Tarea y requisitos RF/RNF/AT: landing pública con diseño futurista One UI; soporte a UX-01 (consistencia visual) y presentación del producto.
- Estado: terminada (verificada con servidor en ejecución).
- Objetivo: explicar qué es MaIA con hero futurista: icono robot y "universo" de servicios orbitando el agente.
- Trabajo realizado:
  - Rediseño de `app/Views/site/home.php`: hero espacial (superficie sólida oscura #0b1020, campo de estrellas por puntos), núcleo con robot SVG propio y dos órbitas con 6 servicios (Mensajería, Llamadas, Importación, Consumo API, Análisis, Informes) girando a distinta velocidad y contrarrotados para mantenerse legibles.
  - Secciones: características (4 tarjetas bento), cómo funciona (4 pasos numerados) y CTA final.
  - `app/Language/{es,en}/Landing.php` con todo el copy; layout público ahora expone `renderSection('head')` para estilos por página.
  - Animación con `prefers-reduced-motion: reduce` desactivada; responsive a 900px.
- Archivos modificados: `app/Views/site/home.php`, `app/Views/layouts/public.php`, `app/Language/es/Landing.php`, `app/Language/en/Landing.php`.
- Decisiones y supuestos: iconos SVG inline controlados por el producto (coherente con la política de avatares); el hero oscuro es superficie sólida, no glassmorphism ni degradados decorativos excluidos por UI-UX.
- Verificaciones: `php -l` sin errores; GET / → 200 con markup del universo, robot y textos en español renderizados.
- Fallos o bloqueos: ninguno.
- Riesgos y limitaciones: los tokens visuales finales vendrán de T-015; esta es una base provisional consistente con la dirección acordada.
- Siguiente paso y responsable sugerido: QA puede revisar responsive/contraste; Fullstack continúa con autenticación real (T-010).

## FULLSTACK-20260921-008
- Fecha: 2026-09-21 18:40 -06:00; zona de referencia America/Managua.
- Autor o rol ejecutor: Fullstack (asistente Devin).
- Tarea: menú público completo en la landing (Inicio, MaIA, Servicios, Planes, Iniciar sesión, Registrarse).
- Estado: terminada.
- Trabajo realizado: `Config\Menu::$public` ahora tiene los 6 ítems; secciones `id=inicio/maia/servicios/planes` en la landing; nuevas secciones Servicios (6 capacidades) y Planes (3 tarjetas referenciales por cuotas + nota de que precios se acuerdan, sin inventar precios — DEC-04 pendiente); claves `Landing.nav.*`, `services.*`, `plans.*`, `svc.*` en es/en; scroll suave desactivado con movimiento reducido.
- Verificaciones: GET / → 200; menú público renderiza los 6 enlaces con anclas correctas; `php -l` limpio.
- Supuestos: nombres de planes (Inicial/Crecimiento/Empresarial) son propuesta referencial; recuperación de contraseña quedó fuera del menú pero la ruta /recovery sigue activa.
- Siguiente paso: autenticación real (T-010); producto define planes y precios (DEC-04).

## FULLSTACK-20260921-009
- Fecha: 2026-09-21 18:50 -06:00; zona de referencia America/Managua.
- Autor o rol ejecutor: Fullstack (asistente Devin).
- Tarea: reglas de desarrollo documentadas y refactorización del código existente para cumplirlas.
- Estado: terminada.
- Trabajo realizado:
  - `AGENTS.md` §Reglas compartidas → "Reglas de desarrollo": PHP+HTML en `.php`; CSS en `public/assets/css/` y JS en `public/assets/js/`; prohibidos `<style>`/`<script>` inline y atributos `style=""`; sin código espagueti (lógica fuera de vistas, responsabilidad única).
  - Refactor: estilos extraídos a `public/assets/css/public.css`, `admin.css` y `landing.css`; layouts y `home.php` ahora usan `<link>` con `base_url()`. Ángulos de satélites resueltos con `.node:nth-child(n)` + variables CSS en vez de `style` inline; nota de planes usa clase `.plans-note`.
- Archivos modificados: `AGENTS.md`, `app/Views/layouts/{public,admin}.php`, `app/Views/site/home.php`, nuevos CSS en `public/assets/css/`.
- Verificaciones: GET / → 200; `public.css` y `landing.css` → 200; markup sin `<style>` ni `style=`; `php -l` limpio.
- Siguiente paso: futuras vistas deben seguir la regla; cuando haya JS irá a `public/assets/js/`.

## FULLSTACK-20260921-010
- Fecha: 2026-09-21 18:55 -06:00; zona de referencia America/Managua.
- Autor o rol ejecutor: Fullstack (asistente Devin).
- Tarea: publicar el trabajo en el repositorio remoto.
- Estado: terminada.
- Trabajo realizado: `git init` (rama main), remoto `origin` → github.com/lunagonzalezivan85/MaIA.git, commit inicial con documentación + plataforma completa (164 archivos), push a `main`. `.env` y `vendor/` excluidos por `platform/.gitignore`.
- Decisiones y supuestos: commit con identidad puntual por comando (`git -c user.name/email`) sin modificar la config git del usuario; las reglas de desarrollo quedan documentadas en `AGENTS.md` §Reglas compartidas → Reglas de desarrollo (PHP+HTML en .php; CSS en `public/assets/css/`; JS en `public/assets/js/`; sin inline ni espagueti).
- Verificaciones: `git push -u origin main` → `[new branch] main -> main`, tracking configurado.
- Siguiente paso: autenticación real (T-010) en nueva rama o commit directo según convenga al equipo.

## FULLSTACK-20260921-011
- Fecha: 2026-09-21 19:00 -06:00; zona de referencia America/Managua.
- Autor o rol ejecutor: Fullstack (asistente Devin).
- Tarea: convertir el plan de entrega en checklist de seguimiento.
- Estado: terminada.
- Trabajo realizado: `docs/PLAN-ENTREGA.md` — backlog T-001..T-016 e incrementos T-017..T-024 convertidos a `- [ ]` con anotaciones de "base creada"/"en curso" donde el esquema o componentes ya existen; T-002 marcado en curso con pendientes explícitos. Regla documentada: `[x]` solo con evidencia de aceptación.
- Verificaciones: estructura del documento revisada; commit e3d4518 empujado a origin/main.
- Siguiente paso: marcar `[x]` solo cuando QA acredite aceptación de cada tarea.

