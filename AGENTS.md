# Zyre Elementor Addons — agent notes

## Identity

- Plugin name: **Zyre Elementor Addons**. Folder and slug: `zyre-elementor-addons`.
- Text domain: `zyre-elementor-addons`. Domain path: `/languages/`.
- Header version and `ZYRELADDONS_VERSION` stay in sync (currently `2.1.8`). Also bump `readme.txt` Stable tag on release.
- Author / company: VertexMediaLLC. Product site: https://zyreaddons.com/
- Primary namespace: `VertexMediaLLC\ZyreElementorAddons`.
  - Widgets: `VertexMediaLLC\ZyreElementorAddons\Widget`
  - Controls: `VertexMediaLLC\ZyreElementorAddons\Controls`
  - Traits: `VertexMediaLLC\ZyreElementorAddons\Traits`
  - Theme Builder: `VertexMediaLLC\ZyreElementorAddons\Modules\ThemeBuilder`
  - Mega Menu: `VertexMediaLLC\ZyreElementorAddons\Modules\Mega_Menu`
- `@package ZyreAddons` in PHPDoc.
- **Requires Plugins:** Elementor (`Requires Plugins: elementor`). Minimum Elementor `3.7.0`, minimum PHP `7.4`, WordPress `5.0+`.
- Constants (main file): `ZYRELADDONS_VERSION`, `ZYRELADDONS__FILE__`, `ZYRELADDONS_DIR_PATH`, `ZYRELADDONS_DIR_URL`, `ZYRELADDONS_ASSETS`, `ZYRELADDONS_REDIRECTION_FLAG`, `ZYRELADDONS_WIZARD_REDIRECTION_FLAG`, `ZYRELADDONS_MINIMUM_ELEMENTOR_VERSION`, `ZYRELADDONS_MINIMUM_PHP_VERSION`.
- Prefixes (do not invent new ones):
  - PHP functions / options / hooks / AJAX / CPT: `zyreladdons_` (note the **L** — historical spelling)
  - Elementor widget names: `zyre-{key}` (from `Widget\Base::get_name()`)
  - Markup / CSS: `zyre-`, `zyre-addon`, `zy-fonticon`
  - Elementor category: `zyreladdons_category` (“Zyre Addons”)
- Admin dashboard: menu title **Zyre Addons**, page slug `zyreladdons` → `admin.php?page=zyreladdons`. Capability: `manage_options`.

## Production / WordPress.org

This plugin is **live on wordpress.org** and used on many sites. Treat every change as a production change.

- Prefer the smallest fix that solves the reported issue. No drive-by refactors.
- **Never break saved Elementor content.** Do not rename or remove:
  - Elementor widget names (`zyre-*`)
  - Control IDs / repeater keys / style keys stored in `_elementor_data`
  - Option keys, post meta keys, CPT slugs, or public CSS class names that user CSS may target
  - Pre-style identifiers (`one`, `two`, …) already shipped
- Do not change frontend markup structure unless the task is explicitly a markup/CSS fix and BC is addressed.
- Do not edit WordPress core, Elementor, Elementor Pro, themes, or other plugins unless asked.
- PHP 7.4 minimum. No PHP 8-only syntax (`str_contains`, `str_starts_with`, union types, `mixed`, enums, `readonly`, named args required by callers on 7.4, etc.).
- GPL-2.0-or-later only. Do not copy proprietary code.
- Appsero (`vendor/appsero`) is the telemetry/updater dependency via Composer. Do not remove or “clean up” Appsero unless a task asks for it.
- Every edit, fix, or new code **must** satisfy the Quality gates below (WPCS / PHPCS, security, performance). Do not ship a change that fails them.

## Quality gates (mandatory on every change)

This plugin must stay review-ready for WordPress.org. Any updated, changed, or newly written code must maintain all four:

### 1. WPCS (WordPress Coding Standards)

- Follow WordPress PHP Coding Standards: tabs for indentation, spacing, naming, Yoda where the surrounding file already uses it, file/class structure matching nearby code.
- `ABSPATH` guard (or `defined( 'ABSPATH' ) || die();`) at the top of every PHP file.
- Text domain `zyre-elementor-addons` on all user-facing strings; use `esc_html__`, `esc_attr__`, `__()`, etc. correctly.
- Prefer patterns already used in neighboring files over inventing a new style.

### 2. PHPCS

- New and touched PHP must be PHPCS-clean under WordPress / WordPress-Extra expectations (WPCS ruleset). Do not introduce sniffs the Plugin Check / wp.org review commonly flags.
- Do not disable sniffs with inline `phpcs:ignore` / `phpcs:disable` unless unavoidable and briefly justified on the same line.
- Do not run a repo-wide PHPCS autofix or mass reformat unrelated to the task. Fix only what you touch (plus any clear violation you introduced).
- There is no project-root `phpcs.xml` yet; still write code as if WordPress-Extra + security-minded review will run on the diff.

### 3. Security

- **Escape on output** (`esc_html`, `esc_attr`, `esc_url`, `wp_kses` / existing `zyreladdons_get_allowed_html()` helpers). Never echo raw request or DB data.
- **Sanitize on input** (`sanitize_text_field`, `absint`, `wp_unslash`, existing `zyreladdons_sanitize_array_recursively()`, etc.).
- **Nonce + capability** on every state-changing admin/AJAX/REST path. Match existing actions (e.g. dashboard `zyreladdons_save_dashboard_settings`).
- No direct SQL without `$wpdb->prepare()`. No trusting `$_GET` / `$_POST` / `$_REQUEST` without sanitizing.
- Do not weaken auth, open nopriv AJAX without a clear public need, or log secrets. Keep file includes on fixed plugin paths — no user-controlled path includes.
- Frontend JS that sends admin-ajax must carry the same nonce/capability model the PHP handler expects.

### 4. Performance

- Do not add per-request heavy work on `init` / `plugins_loaded` / every admin or frontend hit (no unconditional `flush_rewrite_rules()`, no large unused includes, no scanning all posts).
- Enqueue CSS/JS only on screens or documents that need them; prefer existing on-demand / per-widget depends patterns.
- Do not undo the 2.1.7+ performance fixes. Before load-path, cache, enqueue, or rewrite changes, read `PERFORMANCE-AUDIT.md` and `PERFORMANCE-CHANGELOG.md` (see Performance docs below).
- Avoid new autoloaded options, unbounded queries, or loading every widget’s assets “just in case.”
- Deferred ideas (F9, F13, Off-Canvas listener model) stay deferred unless the task explicitly asks.

## Repository

The plugin folder is the git root. Remote: `https://github.com/vertexmediaLLC/zyre-elementor-addons.git`.

Ignore `node_modules/`, `vendor/` churn, and hand-edits to generated `.min.*` files (see Build).

## Layout

```
zyre-elementor-addons/
  zyre-elementor-addons.php          # bootstrap, version constants, dependency checks
  AGENTS.md
  PERFORMANCE-AUDIT.md               # performance findings (proposals + context)
  PERFORMANCE-CHANGELOG.md           # which audit items were applied
  readme.txt / changelog.txt
  gulpfile.js / package.json         # asset minify + widgets-editor merge
  composer.json                      # Appsero only; PSR-4 for unused src/ namespace
  base/
    plugin-base.php                  # Plugin singleton
    widget-base.php                  # Widget\Base (all widgets extend this)
  includes/
    helpers.php                      # loaded before Elementor version check
    functions.php
    filterable-functions.php         # e.g. zyreladdons_is_on_demand_cache_enabled()
  classes/
    widgets-manager.php              # widget map + register
    assets-manager.php / cache-manager.php / widgets-cache.php / assets-cache.php
    admin-dashboard.php              # Dashboard UI
    ajax-handler.php / query-manager.php / icons-manager.php
    library-manager.php / library-source.php / prestyles-manager.php
    search-handler.php / select2-handler.php / credentials-manager.php
    walker-nav-menu.php
  controls/                          # Select2, Style_Control, Radio_Choices, typography group
  traits/                            # button, list-item, social, swiper, …
  widgets/{key}/{key}.php            # one folder per widget (~61)
  modules/
    theme-builder/                   # CPT zyreladdons_library, conditions, theme compat
    mega-menu/                       # CPT zyreladdons_mm, walker, options
  assets/
    css/                             # global, per-widget, widgets-editor(.min).css
    js/                              # zyre-addons.js + libs (lottie, typed, …)
    admin/                           # dashboard / editor / template-library assets
    pre-styles/                      # JSON presets per widget
    fonts/ / libs/ / img/ / svg/ …
  templates/                         # admin + template-library PHP views
  languages/
  vendor/                            # Composer (Appsero)
```

There is no project Autoloader for `VertexMediaLLC\…`. Classes are `include_once`d from `Plugin::include_files()` and `Widgets_Manager::register()`. Composer PSR-4 (`Zyreaddons\ZyreElementorAddons\` → `src/`) is unused for runtime plugin classes; do not move core classes into `src/` without an explicit task.

## Bootstrap

1. `plugins_loaded` → `zyreladdons_init()` in `zyre-elementor-addons.php`.
2. Loads `includes/helpers.php`, then checks PHP / Elementor loaded / Elementor version. Failures only show admin notices.
3. Loads `base/plugin-base.php` → `Plugin::instance()->init()`.
4. `Plugin::init()`:
   - `init` → `include_files()` (managers, Theme Builder, Mega Menu, conditional admin/library files)
   - Elementor category + custom controls
   - Mailchimp AJAX (priv + nopriv)
   - Appsero insights
   - `do_action( 'zyreladdons_loaded' )`
5. Widget PHP loads later on `elementor/widgets/register` via `Widgets_Manager::register()` — inactive widgets (option `zyreladdons_inactive_widgets`) are skipped.

Theme Builder and Mega Menu always boot from `include_files()` (not gated by the widgets dashboard toggle alone).

## Widgets

| Piece | Rule |
| --- | --- |
| Map | `Widgets_Manager::get_free_widgets_map()` — keys, CSS handles, libs, pre-styles, demo/doc URLs |
| File | `widgets/{key}/{key}.php` |
| Class | `VertexMediaLLC\ZyreElementorAddons\Widget\{Name}` where `{key}` hyphens become underscores (`call-to-action` → `Call_To_Action`). Single-token keys use StudlyCase (`infobox` → `InfoBox`). PHP class matching is case-insensitive; keep existing spellings. |
| Elementor name | `zyre-{key}` from `Widget\Base` |
| Base | Extend `Widget\Base` (`base/widget-base.php`) |
| Styles / scripts | Prefer map-driven `get_style_depends()` / `get_script_depends()` on Base (performance work in 2.1.7+). Overrides must **merge** base handles when needed (Menu, Mega Menu, carousels, News Ticker already do). |

Adding a widget requires: map entry, widget PHP, CSS under `assets/css/widgets/…`, optional JS/libs, optional `assets/pre-styles/{key}/`, then `npm run build` so minified + `widgets-editor` bundles update.

## Modules

| Module | CPT / surface | Role |
| --- | --- | --- |
| Theme Builder | `zyreladdons_library` | Header/Footer/Single/Archive templates, conditions (`zyreladdons_theme_builder_conditions` + post meta `zyreladdons_display_cond`), theme compatibility classes under `modules/theme-builder/compatibility/` |
| Mega Menu | `zyreladdons_mm` | Mega menu content posts, nav-menus UI, walker; rewrite flush once per version via `zyreladdons_mm_rewrite_version` |

Theme Builder display defaults (when `zyreladdons_display_cond` is empty): header/footer → `include/general`; archive → `include/archive`; single → `include/singular`. Applied silently on Elementor `document/after_save` and when an empty list is saved from the conditions modal; never overwrite non-empty custom conditions; `loop-template` is excluded. Conflict with another same-type template fails soft (leave empty / show modal notice).

## Assets and cache

- Production URLs use `.min.` unless `SCRIPT_DEBUG` is on.
- **On-demand CSS cache** defaults on (`zyreladdons_is_on_demand_cache_enabled()`). Published pages load a combined file under uploads (`zyre-addons/css/zyre-{post_id}.css`) for widgets on that document.
- Document widget lists live in post meta / `zyreladdons_data_cache`. An **empty array `[]` is a valid cache hit** (no Zyre widgets) — do not treat `empty( [] )` as missing cache.
- Frontend handlers live mainly in `assets/js/zyre-addons.js`, hooked with `elementorFrontend.hooks.addAction( 'frontend/element_ready/...' )`.
- Edit **source** CSS/JS (non-`.min`). Run `npm run build` (Gulp) to refresh `.min` files and `assets/css/widgets-editor.css` / `.min.css`. Do not hand-edit minified output.

## Build

```bash
npm run build    # gulp: minify CSS/JS + merge widget CSS → widgets-editor
npm run makepot  # wp i18n make-pot …
```

Gulp sources exclude existing `*.min.*`. `mergeWidgetCss` concatenates non-min widget CSS into `widgets-editor.css` then minifies.

## Performance docs (required reading for perf / load-path work)

Two checked-in docs from the 2.1.7 performance pass:

| File | Purpose |
| --- | --- |
| `PERFORMANCE-AUDIT.md` | Full audit (F1–F14): findings, safe-fix notes, risks, deferred ideas, verification checklist. Written against **2.1.7**; Phase 1 was proposals, then fixes were applied (see changelog). |
| `PERFORMANCE-CHANGELOG.md` | What was actually shipped: F1, F2, F3, F4, F5, F6, F7, F8, F10, F11, F12. |

**Before any performance or asset-loading change:**

1. Read both files (at least the Priority overview + the IDs you might touch).
2. Do **not** re-introduce fixed problems (examples: per-request `flush_rewrite_rules()`, treating empty widget cache as miss, enqueueing all widget CSS/libs in the editor, boot-loading mega-menu `icon-list.php`, Theme Builder admin assets on every wp-admin screen).
3. Respect **explicitly deferred** items unless the task names them: F13 (lazy widget PHP), F9 (split `zyre-addons.js`), Off-Canvas `wrapInner` / document listeners.
4. After a new performance fix, append an entry to `PERFORMANCE-CHANGELOG.md` and, if the audit status/IDs need updating, adjust `PERFORMANCE-AUDIT.md` briefly — do not rewrite the whole audit.

## Important option / meta keys (do not rename)

| Key | Role |
| --- | --- |
| `zyreladdons_inactive_widgets` | Dashboard-disabled widgets |
| `zyreladdons_widgets_active_styles` | Active pre-styles per widget |
| `zyreladdons_data_cache` | Global / related widget cache data (autoload off after F3) |
| `zyreladdons_theme_builder_conditions` | Theme Builder conditions |
| `zyreladdons_library_cache` | Template library catalog cache |
| `zyreladdons_megamenu_settings` / `zyreladdons_menuitem_settings` | Mega menu settings |
| `zyreladdons_mm_rewrite_version` | Mega Menu rewrite flush gate |
| `_zyreladdons_mm_content_id` / `_zyreladdons_mm_nested_nav` | Mega menu item ↔ content post (F6) |

## Conventions

- OOP for features; helpers in `includes/` use `zyreladdons_` prefix.
- Hook names: `zyreladdons_…` or `zyreladdons/…` (existing style). Ajax actions follow the same prefix.
- Keep dashboard, Theme Builder, and Mega Menu asset enqueues **screen-scoped** (see F12 / existing dashboard checks).
- Custom Elementor controls live under `controls/` and are registered from `Plugin::register_controls()`.
- Shared widget UI patterns go in `traits/`, not copy-pasted across widgets.
- i18n: every user-facing string uses text domain `zyre-elementor-addons`.

## Agent workflow

1. Read this file (especially **Quality gates**). For load/cache/asset issues, also read the performance docs above.
2. Touch only files under `wp-content/plugins/zyre-elementor-addons/` unless the user asks otherwise.
3. Reproduce from the issue description; prefer targeted reads over whole-tree rewrites.
4. Ship a minimal patch. Preserve BC for controls, names, markup, and options.
5. Before finishing, self-check the diff against WPCS/PHPCS, security, and performance gates. Fix any regression you introduced.
6. If you change CSS/JS sources, run `npm run build` when minified assets must ship with the fix.
7. After a task that adds/removes/renames a file, class, method, hook, module, constant, option, or convention, update this `AGENTS.md` before finishing. If nothing structural changed, leave it alone.
8. Do not bump version / `readme.txt` changelog unless the user asks for a release.

## Not in scope by default

- Lazy-loading only some widget PHP files on the frontend (F13)
- Splitting `zyre-addons.js` into per-widget bundles (F9)
- Removing Appsero, changing telemetry UX, or broad PHPCS-only sweeps
- Renaming the `zyreladdons_` prefix to “fix” the L
- Elementor Pro-only features or depending on Pro APIs unless the task requires it
- Editing other plugins in this Local site (e.g. `elementorin-templates`) while working on Zyre
