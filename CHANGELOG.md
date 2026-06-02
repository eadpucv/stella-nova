# Changelog

Todos los cambios notables de **Stella Nova** se documentan aquí.

El formato sigue [Keep a Changelog](https://keepachangelog.com/es-ES/1.1.0/).
Mientras el skin esté en `0.x`, el versionado es **`0.MINOR.PATCH`**: `MINOR`
sube con cambios de comportamiento o estructura; `PATCH`, con correcciones y
ajustes editoriales. La fuente de verdad del comportamiento es
[`specs/stella-nova.allium`](specs/stella-nova.allium); cada entrada que toque
comportamiento debería reflejarse también ahí.

## [0.2.0] — 2026-06-02

### Changed
- **El logo del skin SIEMPRE gana.** Se retiró el override de `$wgLogos`
  (`WikiOverride`): el isotipo embebido del skin se usa siempre, ignorando
  LocalSettings. En producción `$wgLogos` traía el logo del skin viejo y
  tapaba el de Stella Nova.

### Fixed
- **Cache-busting de la CSS crítica, sin acceso al servidor.** La CSS del skin
  ya no viaja en el `<link>` combinado de MediaWiki (que va **sin `version`** y
  una caché HTTP por-URL servía rancio hasta 1 h tras cada deploy, rompiendo las
  fuentes). Ahora la carga `Hooks::onBeforePageDisplay` con su propio `<link>`
  cuyo `version` = hash de contenido de ResourceLoader → caché larga inmutable
  (30 días) **y** bust automático en cada cambio de CSS. `skin.json` `styles`
  queda vacío a propósito.

### Added
- **`.wiki-btn`** (botón de contenido outline, variantes red/green/blue)
  migrado desde `Common.css` de producción al tema, tokenizado (azul literal).
- **Especimen**: documentación de las clases de wikitexto `.full-width`,
  `.wiki-btn` y `.grilla`.
- **`CHANGELOG.md`** y **`CONTRIBUTING.md`**.
- Spec Allium sincronizada con el código (prefs 5→2, aviso descartable
  `SiteNotice`, favicon, logo siempre-skin); `allium check`/`analyse` sin
  findings.

## [0.1.0] — 2026-06-01

### Added
- **Rutas de assets robustas al nombre de carpeta.** Los módulos
  `skins.stellanova.styles` / `.scripts` se registran en PHP
  (`Hooks::onResourceLoaderRegisterModules`) calculando su `remoteSkinPath` del
  directorio real donde el wiki sirve el skin. Basta clonar en cualquier
  carpeta (`StellaNova`, `stella-nova`, symlink) y las URLs de las fuentes
  resuelven solas.

### Changed
- El enlace de patrullaje nativo de MediaWiki ("Marcar esta página como
  verificada", `div.patrollink > button.cdx-button`) se re-viste como nav-pill,
  acotado a `.patrollink` para no alterar otros botones Codex.
- `skin.json` deja de declarar `ResourceModules` / `ResourceFileModulePaths`
  (ahora en PHP). Docs (README, ARCHITECTURE, DEVELOPMENT) actualizados.

## [0.0.9] — 2026-06-01

### Added
- **Favicon definido desde el skin** (`resources/favicon.svg`), autocontenido y
  adaptable claro/oscuro, inyectado sin tocar `$wgFavicon`.
- **Aviso de sitio descartable** (`Stella-Nova:Aviso`): banda full-bleed como
  primer elemento de la hoja, con botón de cerrar. El descarte se recuerda **por
  versión de revisión** (al editar el aviso, reaparece) y es por-navegador;
  oculto sin parpadeo vía pre-pintado.

### Changed
- **Preferencias de lectura: de panel aparte → sección del menú de usuario.**
  Reducidas a **tema** (claro/auto/oscuro, íconos sun/clock/moon) y **tamaño de
  letra** (S/M/L). Se retiraron como preferencia el índice, las secciones
  colapsables (eran *stubs* sin efecto) y el toggle de movimiento.
- El buscador inactivo recibe un filete tenue.
- Estilos de impresión: márgenes de página, sin menú superior ni pie.
- Pie: enlaces de sitio movidos a la columna principal; toolbox como enlaces
  comunes con ícono Feather.

### Fixed
- **Fuentes IBM Plex Sans versionadas en git.** La build variable de dos ejes
  (`plexsans-latin-wdthwght-*.woff2`) no estaba trackeada: al clonar, el tema
  caía a la fuente de sistema. Se versionó y se retiró la build `wght`-only.

### Removed
- Movimiento reducido como preferencia de usuario (se mantiene el respeto a
  `prefers-reduced-motion` del SO a nivel CSS).
- Botón "Restablecer" de preferencias.

## [0.0.8] — 2026-05-29

### Changed
- Tipografía a **IBM Plex** (Sans variable + Serif + Mono), itálicas reales.
- Pie a dos columnas; ajustes editoriales.

## [0.0.7] — 2026-05-26

### Changed
- Itálicas reales; overrides del editor (WikiEditor lee tokens del skin).
- Conjunto de preferencias reducido de 7 a 5 (fuera ContentWidth y LineHeight:
  participan del baseline grid).

## [0.0.6] — 2026-05-24

### Added
- Chrome responsive (mobile-first; dropdowns + hamburguesa).
- Contratos de accesibilidad del chrome y de panel emergente en el spec.
- `__PANTALLACOMPLETA__` rediseñado (lienzo experimental + afordancia de escape).

## [0.0.3] — 2026-05-18

### Added
- M1–M4: `skinStyles` por extensión, layout, tema claro/oscuro, tipografía y
  chrome administrable desde páginas wiki del namespace `Stella-Nova`.

## [0.0.1] — 2026-05-18

### Added
- Esqueleto inicial: `SkinMustache` + `skin.json` + `tokens.css`; spec Allium.

[0.1.0]: https://github.com/hspencer/stella-nova/releases/tag/v0.1.0
[0.0.9]: https://github.com/hspencer/stella-nova/releases/tag/v0.0.9
[0.0.8]: https://github.com/hspencer/stella-nova/releases/tag/v0.0.8
[0.0.7]: https://github.com/hspencer/stella-nova/releases/tag/v0.0.7
[0.0.6]: https://github.com/hspencer/stella-nova/releases/tag/v0.0.6
[0.0.3]: https://github.com/hspencer/stella-nova/releases/tag/v0.0.3
[0.0.1]: https://github.com/hspencer/stella-nova/releases/tag/v0.0.1
