# Stella Nova — Plan de desarrollo

Plan accionable. Principios en [`ARCHITECTURE.md`](ARCHITECTURE.md).

## Cómo se desarrolla (entorno local Casiopea)

- Repo **independiente** en `~/Sites/casiopea/skins/stella-nova/` (este).
  Symlink `…/casiopea/w/skins/StellaNova → ../../skins/stella-nova` lo conecta
  a la wiki local sin copiar nada.
- Editar aquí → recargar navegador. `$wgDefaultSkin` **no** se cambia: se
  compara A/B con `?useskin=stellanova` vs `?useskin=vector-2022` en cualquier
  URL (también seleccionable en `Especial:Preferencias`).
- En dev: `$wgResourceLoaderDebug=true` para ver CSS/JS sin minificar.
- Páginas reales de prueba (Fase 5, set mínimo): "Bitácora de Huinay",
  "Definición de una Narrativa Visual…", "Diseño de Sistema de Señaléticas
  Bibliotecas PUCV", "Taller de Amereida 2020" (stress).

## Estado

- [x] **M0 — Skeleton**: `skin.json`, `SkinStellaNova` (extends `SkinMustache`),
  `skin.mustache` semántico, tokens/layout/print/JS, i18n en/es, repo git +
  remote (sin push). Renderiza sin errores PHP, seleccionable.
- [ ] M1 — skinStyles SMW/SRF/PageForms
- [ ] M2 — Layout real
- [ ] M3 — Dark mode + tokens definitivos
- [ ] M4 — Responsive + navegación
- [ ] M5 — Accesibilidad WCAG 2.1 AA
- [ ] M6 — JS progresivo
- [ ] M7 — Testing + CI
- [ ] M8 — Verificación final y publicación

## Roadmap

### M1 — skinStyles para extensiones (máxima prioridad)
Lo que más se nota. `skinStyles` en `skin.json` con hojas dedicadas para
**SemanticMediaWiki**, **SemanticResultFormats**, **PageForms**,
**TemplateStyles**. Que tablas `#preguntar`, formularios PageForms, factbox y
formatos SRF se vean bien sin reestructurar su DOM. Probar contra las páginas
reales importadas.

### M2 — Layout real
Header (logo, búsqueda funcional, menús de usuario), sidebar de portlets, ToC
persistente, footer completo (`data-footer`), `firstHeading`/subtítulo/
categorías/indicadores. Grid mayor + Flexbox componentes; container queries
donde aporten.

### M3 — Dark mode + tokens
Paleta semántica definitiva en `tokens.css`; light/dark vía
`prefers-color-scheme` + data-attribute conmutable; contraste AA en ambos.

### M4 — Responsive + navegación
Mobile-first; drawer en móvil ↔ sidebar en desktop; sin overflow horizontal;
breakpoints definidos. Búsqueda accesible.

### M5 — Accesibilidad WCAG 2.1 AA
Landmarks, skip-links, foco visible, orden de tab, ARIA en menús/drawer,
`prefers-reduced-motion`. Pasar axe/WAVE; teclado y lector de pantalla.

### M6 — JS progresivo
ES module mínimo (drawer, toggles, búsqueda). Sin jQuery propio. Degradar sin
JS. Reservar JS para interacciones inevitables.

### M7 — Testing + CI
Lint PHP/JS/CSS; pipeline que valide en cada push. PHPUnit si aplica.
Decidir herramienta (pendiente del PLAN del proyecto).

### M8 — Verificación final (checklist Fase 8 del PLAN)
- [ ] Artículo simple (wikitexto básico).
- [ ] Plantilla compleja (ParserFunctions, transclusión, `#preguntar`).
- [ ] Formulario PageForms se ve y funciona (crear/editar).
- [ ] `Especial:Navegar`/`Special:Browse` de SMW legible.
- [ ] Navegación entre namespaces (Categoría, Plantilla, Especial, Widget,
      Propiedad, Concepto…).
- [ ] Móvil/responsive sin overflow horizontal.
- [ ] Contraste WCAG AA mínimo.
- [ ] Sin errores en consola en páginas comunes.
- [ ] Instalable en Casiopea limpia con `wfLoadSkin('StellaNova')` sin pasos
      manuales extra.

## Decisiones

- Licencia: **GPL-2.0-or-later** (vendor el texto completo en `COPYING` antes
  de publicar — hoy es una nota corta).
- Remoto: **GitHub `eadpucv/stella-nova`** (`origin` configurado, **sin push**
  aún — empujar cuando M1+ esté presentable).
- Testing/CI: herramienta por definir (M7).

## Convención de commits

Mensajes en presente, foco en el milestone (p. ej. `M1: skinStyles SMW
factbox + tablas #ask`). Co-autoría según política del proyecto.
