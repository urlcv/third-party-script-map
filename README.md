# urlcv/third-party-script-map

[![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue)](https://www.php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Audit **which outside vendors a page appears to depend on** and get a clearer view of what is worth reviewing for privacy, performance, and supply-chain risk.

> **Live tool:** [urlcv.com/tools/third-party-script-map](https://urlcv.com/tools/third-party-script-map)  
> Part of **[URLCV](https://urlcv.com)** free tools.

---

## What it does

- Audits a **public HTTPS page** from a URL or pasted HTML.
- Detects likely **analytics, ads, chat, video, fonts, payments, consent tooling, CDNs**, and other vendor domains.
- Produces a plain-English **audit summary**, a simple review level, recommendations, and a detailed domain map.
- Resolves **relative URLs** when you provide the page URL.
- Labels **first-party** vs **third-party** where possible.

---

## Limitations

- **Dynamic injection** (tags added after load by JavaScript) won’t appear unless you paste HTML that already includes them or capture a post-render snapshot.
- URL fetch only works for **publicly reachable HTTPS pages**. Localhost, private hosts, some protected staging sites, and bot-protected pages may not fetch.
- Labels are **heuristic** — useful for audit triage, not proof of purpose or data processing.
- **Not** compliance or legal advice.

---

## Installation

```bash
composer require urlcv/third-party-script-map
```

---

## License

MIT — see [LICENSE](LICENSE).
