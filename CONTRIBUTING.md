# Contribuir a Stella Nova

Stella Nova es el skin de [Casiopea](https://wiki.ead.pucv.cl) (Semantic
MediaWiki de la e[ad] PUCV). Se escribe **desde cero** sobre `SkinMustache` de
MediaWiki 1.43, sin Bootstrap ni herencia de otros skins. Esta guía resume cómo
trabajar en el repo sin romper sus invariantes.

## Antes de tocar nada: lee la doctrina

1. **[`specs/stella-nova.allium`](specs/stella-nova.allium)** — la
   especificación de **comportamiento** es la fuente de verdad. Describe *qué*
   hace el skin y *por qué*, no *cómo*. Si cambias comportamiento, el spec se
   actualiza en el mismo PR.
2. **[`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md)** — la doctrina (PHP al
   mínimo, presentación en CSS/Mustache, todo declarativo).
3. **[`docs/DEVELOPMENT.md`](docs/DEVELOPMENT.md)** — roadmap M0–M8 y decisiones
   con fecha (no re-litigar lo ya decidido).

## Principios no negociables

- **Spec primero.** El comportamiento observable se modela en Allium antes o
  junto al código. Lo que sea pura presentación (tipografía, posiciones,
  colores, animación) NO va al spec — va a `tokens.css` / CSS y, si amerita, a
  los docs de diseño.
- **PHP al mínimo.** Sólo lo que el comportamiento exige y no puede vivir en
  CSS/JS: wiring, hooks, *data keys* para la plantilla. La lógica de
  presentación vive en `skin.mustache` + CSS.
- **Fidelidad estructural.** Nunca recortes el HTML que emiten MediaWiki o sus
  extensiones (SMW, SRF, PageForms, Widgets, …). El skin envuelve y estiliza; no
  reestructura. Ver el contrato `SkinRenderFidelity`.
- **Todo por token.** Colores, espacios, tipos y sombras salen de `tokens.css`.
  Nada de hex hardcodeado en componentes — usa `var(--sn-*)`. El modo oscuro
  voltea solo si respetas los tokens.
- **Accesibilidad del chrome.** Todo control interactivo expone nombre accesible
  (texto visible, `aria-label` o `title`); los íconos-only DEBEN llevar label.
  Ningún surface de chrome se suprime por viewport estrecho (sólo en
  `__PANTALLACOMPLETA__`). Ver `ChromeAccessibility`.

## Flujo con Allium

El CLI de Allium valida el spec:

```bash
allium check   specs/stella-nova.allium   # estructura
allium analyse specs/stella-nova.allium   # huecos a nivel de proceso
```

Ambos deben pasar sin `findings` antes de hacer push de un cambio de
comportamiento. Para evolucionar el spec usa el skill `tend`; para verificar que
spec y código no divergieron, `weed`.

## Estructura del repo

```
skin.json              Manifiesto. Declara ValidSkinNames, Hooks, MessagesDirs,
                       ResourceModuleSkinStyles. (Los ResourceModules del skin
                       se registran en PHP — ver más abajo.)
includes/
  SkinStellaNova.php   Única clase de render: emite las data keys propias.
  Hooks.php            Wiring: prefs como opciones de cuenta, pre-pintado sin
                       FOUC, favicon, registro robusto de módulos.
  templates/*.mustache Plantillas (skin + sprite de íconos Feather).
resources/
  tokens.css           Design tokens (la ÚNICA fuente de color/espacio/tipo).
  stella-nova.css      Estilos del skin.
  fonts.css + fonts/   IBM Plex auto-alojado (woff2 versionadas en git).
  print.css            Impresión.
  skin.js              Mejora progresiva (sin jQuery propio).
  skinStyles/          Overrides por extensión (+ext.<nombre>).
specs/                 La especificación Allium.
docs/                  ARCHITECTURE, DEVELOPMENT, especimen gráfico, etc.
```

### Estilos de extensiones (`skinStyles/`)

Para estilar una extensión, añade `"+ext.<módulo>": "skinStyles/<archivo>.css"`
en `ResourceModuleSkinStyles` de `skin.json` y crea el archivo. Lee tokens del
skin; no hardcodees colores de la extensión.

### Fuentes y rutas de assets

- Las woff2 **se versionan en git** (`resources/fonts/`). Su ausencia rompe el
  tema (cae a fuente de sistema). Al cambiar la build, `git add` los nuevos y
  `git rm` los viejos.
- Las URLs de assets se calculan de la **carpeta real** del skin
  (`Hooks::onResourceLoaderRegisterModules`), así que da igual el nombre del
  directorio al clonar. No vuelvas a hardcodear `remoteSkinPath` en `skin.json`.

## Desarrollo local

El skin se prueba contra la réplica local de Casiopea
(`~/Sites/casiopea/w`, servida en `http://casiopea.local/`), conectada por
symlink `w/skins/StellaNova → skins/stella-nova`. Comparación A/B en cualquier
página: `?useskin=stellanova` vs `?useskin=vector-2022`.

Tras editar CSS/JS/plantillas, recarga; ResourceLoader versiona por hash. Para
ver el CSS servido como en producción (minificado):

```bash
curl -s "http://casiopea.local/load.php?modules=skins.stellanova.styles&only=styles&skin=stellanova"
```

## Versionado, changelog y commits

- **Versión** en `skin.json` (`"version"`) + los archivos del especimen
  (`docs/specimen/*`). `0.MINOR.PATCH`: `MINOR` = comportamiento/estructura,
  `PATCH` = correcciones/editorial.
- **[`CHANGELOG.md`](CHANGELOG.md)**: añade una entrada por release siguiendo
  Keep a Changelog (Added / Changed / Fixed / Removed).
- **Commits de release**: `vX.Y.Z — resumen` (convención del repo). El cuerpo
  enumera los cambios. Termina los mensajes de commit con la línea
  `Co-Authored-By:` correspondiente cuando aplique.
- `main` es la rama viva; los commits de versión van directo a `main`.

## Checklist antes de push

- [ ] `allium check` y `allium analyse` pasan (si tocaste comportamiento, el
      spec quedó actualizado).
- [ ] Sin colores/medidas hardcodeadas: todo vía `var(--sn-*)`.
- [ ] Probado en claro y oscuro, y en viewport estrecho.
- [ ] Controles nuevos con nombre accesible.
- [ ] No se recortó HTML de core/extensiones.
- [ ] `skin.json` válido; versión y `CHANGELOG.md` actualizados si es release.
- [ ] Assets nuevos (fuentes/íconos) versionados.
