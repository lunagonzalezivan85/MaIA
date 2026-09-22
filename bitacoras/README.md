# Bitácoras de los agentes desarrolladores

Cada rol mantiene su archivo: `PROYECTO.md`, `FULLSTACK.md` o `QA.md`. Anexar una entrada por sesión y por transferencia relevante. Los registros iniciales solo acreditan la preparación documental; no representan sesiones ejecutadas por agentes independientes.

Usar identificador `<ROL>-<AAAAMMDD>-<secuencia>`, fecha ISO 8601 con zona horaria si se conoce la hora, tarea y requisitos. No inventar timestamps, comandos ejecutados, commits o resultados. Referenciar rutas relativas al repositorio para portabilidad. Nunca pegar secretos ni datos personales reales.

## Plantilla de entrada

```markdown
## <ROL>-<AAAAMMDD>-<secuencia>
- Fecha / zona horaria:
- Autor o rol ejecutor:
- Tarea y requisitos RF/RNF/AT:
- Estado: pendiente | en curso | bloqueada | en revisión | terminada
- Objetivo:
- Entradas y versión/commit revisado, si existe:
- Trabajo realizado:
- Archivos modificados:
- Decisiones y supuestos:
- Verificaciones: comando o procedimiento, entorno, resultado y evidencia.
- Fallos o bloqueos:
- Riesgos y limitaciones:
- Siguiente paso y responsable sugerido:
```

En QA, añadir casos aprobados/fallidos/no ejecutados y referencias BUG. En Fullstack, añadir migraciones, configuración y rollback si aplica. En Proyecto, añadir decisiones DEC y dependencias. Si no hubo pruebas, escribir “No ejecutadas” y explicar por qué.

