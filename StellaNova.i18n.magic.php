<?php
/**
 * Stella Nova — palabra mágica de comportamiento (behaviour switch).
 *
 * __PANTALLACOMPLETA__ declara LayoutMode.fullscreen (spec entity PageRender):
 * el skin suprime todo el chrome salvo la afordancia de escape. NO implica
 * ocultar el título: para eso se usa __NOTITLE__ además, de forma explícita
 * (más limpio que acoplarlos). El `1` = sensible a mayúsculas, como los
 * demás dobles-guión-bajo de MediaWiki.
 *
 * __PAGINAANCHA__ declara LayoutMode.wide: chrome estándar, pero la hoja (y
 * el pie) se ensanchan de la medida de lectura (--sn-measure) al ancho del
 * conjunto (--sn-shell). Para tablas, grillas o grafos que no caben en la
 * columna de lectura. Si la página declara ambas, gana __PANTALLACOMPLETA__.
 *
 * @file
 * @license Artistic-2.0
 */

$magicWords = [];

$magicWords['en'] = [
	'stellanova_fullscreen' => [ 1, '__FULLSCREEN__', '__PANTALLACOMPLETA__' ],
	'stellanova_wide' => [ 1, '__WIDEPAGE__', '__PAGINAANCHA__' ],
];

$magicWords['es'] = [
	'stellanova_fullscreen' => [ 1, '__PANTALLACOMPLETA__', '__FULLSCREEN__' ],
	'stellanova_wide' => [ 1, '__PAGINAANCHA__', '__WIDEPAGE__' ],
];
