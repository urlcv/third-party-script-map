# urlcv/third-party-script-map

[![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue)](https://www.php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Map **third-party scripts, styles, iframes, and resource hints** from HTML — grouped by domain with likely labels for analytics, ads, chat, fonts, CDNs, and more.

> **Live tool:** [urlcv.com/tools/third-party-script-map](https://urlcv.com/tools/third-party-script-map)  
> Part of **[URLCV](https://urlcv.com)** free tools.

---

## What it does

- Parses **static HTML** (pasted source or fetched in-browser when CORS allows).
- Collects **external** resources: `<script src>`, `<link href>` (stylesheets, preconnect, dns-prefetch, preload), `<iframe src>`.
- Optionally includes **images** (can be noisy on large pages).
- Resolves **relative URLs** using the page URL you provide.
- Labels **first-party** vs **third-party** (different origin than the page URL).
- Classifies each **domain** using a maintainable rule list (not a legal/cookie consent verdict).

---

## Limitations

- **Dynamic injection** (tags added after load by JavaScript) won’t appear unless you paste HTML that already includes them or capture a post-render snapshot.
- **Fetch mode** only works when the target allows **CORS** for your browser; otherwise paste HTML from DevTools.
- Labels are **heuristic** (e.g. “likely analytics”) — not a guarantee of purpose or data processing.
- **Not** compliance or legal advice.

---

## Installation

```bash
composer require urlcv/third-party-script-map
```

---

## License

MIT — see [LICENSE](LICENSE).
