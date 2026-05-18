# Stella Nova — Arquitectura y principios

Doctrina que rige el desarrollo del skin. Doc canónico (vive en el repo del
skin, publicable). El plan accionable está en [`DEVELOPMENT.md`](DEVELOPMENT.md).

## 0. Principio rector

Escrito **desde cero**: sin Bootstrap, sin clonar Example/BoilerPlate, sin
heredar de Chameleon. Solo el contrato mínimo de MediaWiki (`SkinMustache` +
`skin.json`) y CSS moderno propio. Citizen/Vector/Lift se **leen** como
referencia, no se copian.

## 1. Stack de skins MediaWiki

MediaWiki migró de `SkinTemplate`+PHP a `SkinMustache` + registro declarativo
en `skin.json` + separación datos/presentación con Mustache. Permite trabajar
casi sin PHP y favorece código testeable. Es la dirección oficial.

## 2. Arquitectura base

- Declarar todo en `skin.json` (`ValidSkinNames`, `MessagesDirs`,
  `ResourceModules`, `AutoloadNamespaces`), no inicialización en PHP.
- Clase base `SkinMustache` (en MW 1.43 es **clase global** `SkinMustache`,
  no `MediaWiki\Skin\SkinMustache`). PHP al mínimo (config, wiring, hooks).
- Hooks en clase separada (`…Hooks.php`), no mezclados con layout.
- Estructura: `skin.json`, `includes/` (clase + `templates/*.mustache`),
  `resources/` (`styles/` Less/CSS, `scripts/` JS), `i18n/`.
- `templateDirectory` se declara en `skin.json` relativo al skin
  (convención Vector: `includes/templates`). Plantilla principal `skin.mustache`
  empieza con `{{{html-headelement}}}` y cierra `</body></html>`.

## 3. Compatibilidad con Semantic MediaWiki (lo más crítico aquí)

SMW/SRF/PageForms generan mucho HTML (propiedades, tablas, formularios,
resultados en formatos diversos). Reglas:

- **No** sobrescribir agresivamente clases de core/SMW; refinar con CSS, no
  reestructurar el DOM.
- `skinStyles` dedicados en `skin.json` apuntando a hojas específicas para
  SMW y SRF (patrón Citizen), separadas del layout.
- Tablas/datatables como componentes: `overflow-x:auto` en contenedores;
  clases opt-in para "nowrap"/overflow sin romper funcionalidad.
- Sin alturas/anchos rígidos en elementos SMW; layouts líquido-flexibles.
- Probar con los formatos reales usados en Casiopea: tablas, listas,
  `#preguntar`, PageForms, `#widget` (Smarty), Mermaid, Maps.

## 4. Responsividad

Mobile-first real (no MobileFrontend): un solo layout que adapta ancho,
navegación y densidad con breakpoints en CSS. Navegación que degrada:
drawer/hamburguesa en móvil, sidebar persistente en desktop. ToC persistente;
opcional command palette. Foco visible y navegación por teclado siempre.

## 5. Accesibilidad — objetivo WCAG 2.1 AA

- **Perceptible**: contraste AA (incl. dark mode); alternativas textuales
  (`aria-label`/`aria-hidden`); no depender solo del color.
- **Operable**: 100 % teclado, orden de tab lógico, `:focus-visible`,
  skip-link a contenido y a navegación; sin trampas de foco en
  modales/drawers (`role="dialog"`, `aria-modal`, devolver foco);
  `prefers-reduced-motion`.
- **Comprensible**: landmarks (`header/nav/main/aside/footer/search`),
  jerarquía de encabezados, labels claros.
- **Robusta**: HTML5 + ARIA correcto; testear con NVDA/VoiceOver y axe/WAVE
  en CI.

## 6. Configuración y extensibilidad

Núcleo de UX fijo + tuning por variables globales con defaults sensatos
(estilo Citizen: tema por defecto, secciones colapsables, page tools).
Documentar cada flag. Mantener en el README una tabla de compatibilidad de
extensiones con versiones testadas (Citizen-style). `skinStyles` se amplían
incrementalmente por extensión.

## 7. Testing

Páginas de prueba que cubran patrones semánticos (fichas, listas, tablas de
propiedades, agregados, mapas, formularios); probar lectura/edición SMW en
distintos roles; rondas con lectores de pantalla y móviles reales; axe/WAVE
en el flujo continuo.

## Referencias

- Manual:How to make a MediaWiki skin · …/Migrating SkinTemplate to SkinMustache
- Skin:Lift/Development guide · Skin:Citizen · Skin:Tweeki
- Accessibility guide for developers (MediaWiki) · A11y playbook WCAG 2.1 AA
- Codex › Accessibility · WAI-ARIA 1.3
- StarCitizenTools/mediawiki-skins-Citizen (GitHub)

(URLs completas en el commit original / `git log`; este doc es la síntesis
operativa.)
