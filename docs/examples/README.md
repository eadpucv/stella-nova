# Ejemplos — logo de prueba

Assets para **validar el flujo de configuración del logo** (opción
`$wgStellaNovaIsotypePath` / `$wgStellaNovaIconPath`) antes de poner un logo
real. Cumplen el contrato del [README principal](../../README.md) → sección
*Logo / isotipo* (todo `currentColor`, fondo transparente, monocromo,
autocontenido) y son **a propósito distintos** del isotipo de Casiopea, para
que el cambio se note a simple vista.

| Archivo | Config a probar | Proporción |
|---|---|---|
| `logo-prueba.svg` | `$wgStellaNovaIsotypePath` (wordmark) | 4.5:1 (`viewBox 0 0 450 100`) |
| `logo-prueba-icono.svg` | `$wgStellaNovaIconPath` (glifo compacto) | 1:1 (`viewBox 0 0 100 100`) |

**No son logos de producción.** Sirven solo para confirmar que la cadena
config → SVG en disco → incrustado inline → tematizado claro/oscuro funciona en
el servidor. Tras validar, se quitan las líneas de config (vuelve el logo de
Casiopea del bundle) o se apuntan al logo real reubicado.
