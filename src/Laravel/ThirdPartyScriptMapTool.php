<?php

declare(strict_types=1);

namespace URLCV\ThirdPartyScriptMap\Laravel;

use App\Tools\Contracts\ToolInterface;

class ThirdPartyScriptMapTool implements ToolInterface
{
    public function slug(): string
    {
        return 'third-party-script-map';
    }

    public function name(): string
    {
        return 'Website Vendor Audit';
    }

    public function summary(): string
    {
        return 'See which third-party vendors a page appears to load, what they are likely for, and what is worth reviewing for privacy and performance.';
    }

    public function descriptionMd(): ?string
    {
        return <<<'MD'
## Third-Party Script & Tracker Map

See **which outside vendors a page appears to depend on**: analytics, ads, chat, video, fonts, CDNs, payments, consent tooling, and more.

- Runs **entirely in your browser**.
- Gives you a clear **audit summary**, likely vendor labels, and a detailed **domain map**.
- **Evidence-based**: every row links back to the exact URL found in the HTML.
- **Not** a vulnerability scanner and **not** legal or compliance advice about cookies or consent.

### Best for

Founders, marketers, developers, privacy reviewers, and agencies trying to understand a site's third-party footprint quickly.
MD;
    }

    public function mode(): string
    {
        return 'frontend';
    }

    public function isAsync(): bool
    {
        return false;
    }

    public function isPublic(): bool
    {
        return true;
    }

    public function categories(): array
    {
        return ['web', 'security'];
    }

    public function tags(): array
    {
        return ['privacy', 'third-party', 'scripts', 'trackers', 'performance', 'devtools'];
    }

    public function inputSchema(): array
    {
        return [
            'url' => [
                'type'        => 'text',
                'label'       => 'Page URL',
                'placeholder' => 'https://example.com/page',
                'required'    => false,
                'max_length'  => 2048,
                'help'        => 'Optional. Used to resolve relative URLs and to label first-party vs third-party.',
            ],
            'html' => [
                'type'        => 'text',
                'label'       => 'HTML',
                'placeholder' => 'Paste page source or HTML fragment…',
                'rows'        => 10,
                'required'    => false,
                'max_length'  => 500_000,
            ],
        ];
    }

    public function run(array $input): array
    {
        return [];
    }

    public function rateLimitPerMinute(): int
    {
        return 30;
    }

    public function cacheTtlSeconds(): int
    {
        return 0;
    }

    public function sortWeight(): int
    {
        return 84;
    }

    public function frontendView(): ?string
    {
        return 'third-party-script-map::third-party-script-map';
    }
}
