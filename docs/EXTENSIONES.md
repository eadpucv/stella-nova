# Stella Nova — compatibilidad con extensiones

Stella Nova **absorbe** los estilos de las extensiones de MediaWiki en
vez de pelearse con ellos. La extensión sigue actualizándose por su
cuenta; solo cambia su apariencia. Sin parchear el código de la
extensión, sin forkearla y sin `!important` regados.

Este documento explica el mecanismo y lista las 22 extensiones
absorbidas, con el estado de pulido de cada una.

## Mecanismo

`ResourceModuleSkinStyles` en [`skin.json`](../skin.json) con prefijo `+`:
el CSS del skin se carga **después** del CSS de la extensión, y la
cascada hace que las reglas del skin ganen sin necesidad de
`!important`. Schema:

```json
"ResourceModuleSkinStyles": {
  "stellanova": {
    "+ext.smw.styles":        "resources/skinStyles/smw.css",
    "+ext.srf.formats.tagcloud": "resources/skinStyles/srf.css",
    …
  }
}
```

El `+` significa "añade a", no "reemplaza". El CSS de la extensión
sigue cargándose tal cual; el del skin va detrás.

## Dos niveles de absorción

Cada hoja en [`resources/skinStyles/`](../resources/skinStyles/) cubre
los módulos CSS de una extensión. Hay dos niveles:

### Reescrita a mano

La hoja está expresada en el sistema visual del skin: tokens
`var(--sn-*)`, escala `--sn-s-N`, tipografía `--sn-fs-X`, layout
coherente con el "papel". Estas hojas:

- Voltean light/dark sin esfuerzo (al usar los tokens del skin).
- Honran la doctrina §3 (sin alturas/anchos rígidos, sin reestructurar
  el DOM de la extensión, refine-only con CSS).
- Son legibles: cualquier diseñador puede entrar y modificar.

### Snapshot tokenizado

La hoja es el CSS **original** de la extensión capturado literalmente
y luego procesado por tres pasadas automáticas:

1. **Hex → tokens.** `#fafafa` → `var(--sn-sunk)`, `#202122` →
   `var(--sn-ink)`, etc. (mapa en
   [`scripts/apply-tokenization.py`](../scripts/apply-tokenization.py)).
2. **`@codex-vars` → tokens.** Variables Codex/WikimediaUI
   (`--color-base`, `--background-color-progressive`…) ya están
   aliasadas en `tokens.css` a tokens del skin; no requieren
   reemplazo de texto.
3. **Medidas → tokens** (cuidadosamente, según criterio
   horizontal/vertical). `padding: 1rem` puede ser `--sn-s-4`
   (horizontal/inset) o `--sn-baseline` (vertical/ritmo); no se
   sustituye a ciegas.

Los rincones con shorthands mixtos (`padding: 5px 0 5px 35px`) quedan
marcados con `/* TODO tok */` para pulir caso por caso durante el uso
real. Estas hojas funcionan: solo no están "habladas en el lenguaje
del skin" hasta el último detalle.

## Inventario

| Extensión | Hoja | Nivel |
|---|---|---|
| [Semantic MediaWiki](https://www.semantic-mediawiki.org/) | [`smw.css`](../resources/skinStyles/smw.css) | reescrita a mano |
| [Semantic Result Formats](https://www.semantic-mediawiki.org/wiki/Extension:Semantic_Result_Formats) | [`srf.css`](../resources/skinStyles/srf.css) | reescrita a mano |
| [PageForms](https://www.mediawiki.org/wiki/Extension:Page_Forms) | [`pageforms.css`](../resources/skinStyles/pageforms.css) | reescrita a mano |
| OOUI (core MW, tema wikimediaui) | [`oojs-ui.css`](../resources/skinStyles/oojs-ui.css) | snapshot tokenizado |
| [MsUpload](https://www.mediawiki.org/wiki/Extension:MsUpload) | [`msupload.less`](../resources/skinStyles/msupload.less) | snapshot tokenizado |
| [SimpleBatchUpload](https://www.mediawiki.org/wiki/Extension:SimpleBatchUpload) | [`simplebatchupload.css`](../resources/skinStyles/simplebatchupload.css) | snapshot tokenizado |
| [ConfirmEdit](https://www.mediawiki.org/wiki/Extension:ConfirmEdit) (+ hCaptcha bundled) | [`confirmedit.css`](../resources/skinStyles/confirmedit.css) | snapshot tokenizado |
| [WikiEditor](https://www.mediawiki.org/wiki/Extension:WikiEditor) | [`wikieditor.css`](../resources/skinStyles/wikieditor.css) | snapshot tokenizado |
| [InlineComments](https://www.mediawiki.org/wiki/Extension:InlineComments) | [`inlinecomments.css`](../resources/skinStyles/inlinecomments.css) | snapshot tokenizado |
| [PageNotice](https://www.mediawiki.org/wiki/Extension:PageNotice) | [`pagenotice.css`](../resources/skinStyles/pagenotice.css) | snapshot tokenizado |
| [EasyTimeline](https://www.mediawiki.org/wiki/Extension:EasyTimeline) | [`easytimeline.css`](../resources/skinStyles/easytimeline.css) | snapshot tokenizado |
| [ImageMap](https://www.mediawiki.org/wiki/Extension:ImageMap) | [`imagemap.css`](../resources/skinStyles/imagemap.css) | snapshot tokenizado |
| [3DAlloy](https://github.com/dolfinus/3DAlloy) | [`3dalloy.css`](../resources/skinStyles/3dalloy.css) | snapshot tokenizado |
| [Mermaid](https://www.mediawiki.org/wiki/Extension:Mermaid) | [`mermaid.css`](../resources/skinStyles/mermaid.css) | snapshot tokenizado |
| [CategoryTree](https://www.mediawiki.org/wiki/Extension:CategoryTree) | [`categorytree.less`](../resources/skinStyles/categorytree.less) | snapshot tokenizado |
| [Cite](https://www.mediawiki.org/wiki/Extension:Cite) | [`cite.less`](../resources/skinStyles/cite.less) | snapshot tokenizado |
| [Math](https://www.mediawiki.org/wiki/Extension:Math) | [`math.css`](../resources/skinStyles/math.css) | snapshot tokenizado |
| [Maps](https://www.mediawiki.org/wiki/Extension:Maps) (Leaflet) | [`maps.base.css`](../resources/skinStyles/maps.base.css) + [`maps.widgets.css`](../resources/skinStyles/maps.widgets.css) | snapshot tokenizado |
| [Nuke](https://www.mediawiki.org/wiki/Extension:Nuke) | [`nuke.css`](../resources/skinStyles/nuke.css) | snapshot tokenizado |
| [Echo](https://www.mediawiki.org/wiki/Extension:Echo) | [`echo.base.less`](../resources/skinStyles/echo.base.less) + [`echo.widgets.less`](../resources/skinStyles/echo.widgets.less) | snapshot tokenizado |
| [ReplaceText](https://www.mediawiki.org/wiki/Extension:ReplaceText) | [`replacetext.less`](../resources/skinStyles/replacetext.less) | snapshot tokenizado |
| [TemplateData](https://www.mediawiki.org/wiki/Extension:TemplateData) | [`templatedata.css`](../resources/skinStyles/templatedata.css) | snapshot tokenizado |

En total, **47 módulos CSS** de **22 extensiones** quedan absorbidos.

## Extensiones no incluidas

`VisualEditor`, `DiscussionTools`, `MultimediaViewer`, `Scribunto`,
`AbuseFilter`, `OATHAuth`, `CodeEditor`, `CiteThisPage`, `Interwiki`,
`SyntaxHighlight`, `TemplateDataGenerator` — no se activan en la wiki
de [Casiopea](https://wiki.ead.pucv.cl) de producción y se omitieron
del primer corte. Para integrarlas, repetir el flujo descrito abajo.

## Flujo para absorber una extensión nueva

1. **Identificar los módulos CSS** que carga la extensión. Mirar su
   `extension.json` → `ResourceModules`. Anotar los nombres
   (`ext.foo.styles`, `ext.foo.widgets`…).
2. **Capturar el snapshot.** Para OOUI hay un script dedicado:
   ```bash
   python3 scripts/snapshot-oojs-ui.py
   ```
   Para otras extensiones, copiar manualmente el CSS desde
   `w/extensions/<Foo>/resources/` a
   `resources/skinStyles/<foo>.css` (preservar nombre cuando sea
   sensato — `Cite/modules/ext.cite.styles.css` → `cite.css`).
3. **Mapear en `skin.json`** con prefijo `+`:
   ```json
   "+ext.foo.styles": "resources/skinStyles/foo.css"
   ```
4. **Tokenizar** las pasadas automáticas:
   ```bash
   python3 scripts/apply-tokenization.py foo.css
   ```
   (sin argumento procesa todos los snapshots; pasa
   `--help` para ver opciones).
5. **Revisar** los `/* TODO tok */` durante el uso real de la
   extensión.

## Scripts del flujo

Todos los scripts del repo viven en [`scripts/`](../scripts/) y son
**idempotentes**: correrlos dos veces no rompe nada.

| Script | Qué hace |
|---|---|
| [`snapshot-oojs-ui.py`](../scripts/snapshot-oojs-ui.py) | Captura el CSS fuente de OOUI (core + widgets + windows, tema wikimediaui) desde `w/resources/lib/ooui/` y lo escribe como `resources/skinStyles/oojs-ui.css` con header de atribución (versión, fecha, módulos). Se corre cuando OOUI sube versión. |
| [`apply-tokenization.py`](../scripts/apply-tokenization.py) | Aplica las 3 pasadas de tokenización (hex → tokens, codex-vars → tokens, medidas → tokens) a las hojas snapshot. Acepta argumento opcional para un solo archivo. Crea backup `.pre-tok-<timestamp>` antes de escribir. |

Comandos típicos:

```bash
# Recapturar OOUI cuando suba versión en el wiki local
python3 scripts/snapshot-oojs-ui.py
python3 scripts/apply-tokenization.py oojs-ui.css

# Re-tokenizar todos los snapshots (raro; suele bastar al añadir
# un mapeo nuevo de hex/medida → token en apply-tokenization.py)
python3 scripts/apply-tokenization.py
```

(El script `build-specimen.py` no participa de este flujo — está en
[`DISENO.md`](DISENO.md), pertenece al ciclo de iteración del
sistema visual.)

## Detalle completo y trazabilidad

> El proceso completo, mapas de equivalencias y trazabilidad de cada
> hoja está en el [Plan de Migración Stella Nova](https://wiki.ead.pucv.cl/Stella_Nova).

## Casiopea-Con§tel (desarrollo propio)

[`skinStyles/constel.css`](../resources/skinStyles/constel.css) sobre
`ext.constel.map.styles`: las páginas Especial:Constelación y Especial:MiConstel
marcan `<body class="constel-wide">` y aquí la hoja se ensancha a `--sn-shell`.
Especial:Constelación además va a pantalla completa: fija `stellanova-fullscreen`
(lo mismo que `__PANTALLACOMPLETA__`) y marca `constel-full`; aquí el canvas
pierde su padding, título e introducción quedan sólo para lectores de pantalla
y la barra del mapa deja libre la esquina del isotipo.
El resto de la extensión no necesita absorción: se diseñó sobre los tokens
semánticos y de componente del skin (capa de alias `--constel-*`).

