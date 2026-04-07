{{--
  Third-Party Script & Tracker Map - frontend-only Alpine.js tool.
  Audits browser-visible third-party dependencies from a URL or pasted HTML.
--}}

<div x-data="thirdPartyScriptMap()" class="space-y-6">
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-primary-700">Website Vendor Audit</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-900">See which outside tools your page depends on</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Enter a website URL and this tool will show the third-party vendors it appears to load, what they are likely for,
                    and what is worth reviewing for privacy, performance, and supply-chain risk.
                </p>
            </div>
            <button
                type="button"
                class="inline-flex shrink-0 items-center rounded-full border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-50"
                @click="showLimits = !showLimits"
                x-text="showLimits ? 'Hide limitations' : 'Show limitations'"
            ></button>
        </div>

        <div class="mt-5 grid gap-3 md:grid-cols-3">
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                <div class="text-xs font-semibold uppercase tracking-wide text-emerald-700">What you get</div>
                <p class="mt-2 text-sm text-emerald-900">A plain-English audit summary, likely vendors spotted, and a domain-by-domain map.</p>
            </div>
            <div class="rounded-2xl border border-sky-200 bg-sky-50 p-4">
                <div class="text-xs font-semibold uppercase tracking-wide text-sky-700">Best for</div>
                <p class="mt-2 text-sm text-sky-900">Founders, marketers, developers, agencies, and anyone trying to understand a site's vendor footprint.</p>
            </div>
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4">
                <div class="text-xs font-semibold uppercase tracking-wide text-amber-700">Worth knowing</div>
                <p class="mt-2 text-sm text-amber-900">This reads HTML only. If a site injects tags later with JavaScript, paste a post-render snapshot for better coverage.</p>
            </div>
        </div>

        <div x-show="showLimits" x-cloak class="mt-5 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900">
            <ul class="list-disc space-y-1 pl-5">
                <li>URL fetch only works for publicly reachable HTTPS pages. Localhost, private/internal hosts, and some bot-protected pages will not fetch.</li>
                <li>Even for public pages, some sites may still block requests or require bot mitigation. In that case, paste HTML from View Source or DevTools.</li>
                <li>Labels are best-effort heuristics based on domains. They do not prove data processing, consent status, or legal compliance.</li>
                <li>Missing detections do not prove absence. This is an inventory tool, not a crawler or vulnerability scanner.</li>
            </ul>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,0.92fr)_minmax(0,1.08fr)]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Start with a website URL</h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Recommended. We will try to fetch a publicly reachable HTTPS page server-side. If that fails, keep the URL entered and use advanced mode below.
                    </p>
                </div>
                <button
                    type="button"
                    class="inline-flex shrink-0 items-center rounded-full border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-50"
                    @click="advancedMode = !advancedMode"
                    x-text="advancedMode ? 'Hide advanced mode' : 'Use advanced mode'"
                ></button>
            </div>

            <div class="mt-5 space-y-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Website URL <span class="text-primary-700">(recommended)</span></label>
                    <input
                        type="url"
                        x-model="websiteUrl"
                        placeholder="https://www.example.com/page"
                        class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-transparent focus:ring-2 focus:ring-primary-500"
                    />
                    <p class="mt-1.5 text-xs text-slate-500">
                        This must be a publicly reachable HTTPS URL. It is fetched server-side, then used to resolve relative URLs and tell first-party resources apart from third-party vendors.
                    </p>
                </div>

                <div x-show="advancedMode" x-cloak class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="text-sm font-semibold text-slate-900">Advanced mode: paste HTML</div>
                            <p class="mt-1 text-xs text-slate-500">
                                Use this when fetch is blocked, or when you want to audit a saved page source or post-render snapshot.
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 space-y-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700">HTML snapshot</label>
                            <textarea
                                x-model="html"
                                rows="12"
                                placeholder="Paste page source or a fragment from DevTools..."
                                class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm font-mono focus:border-transparent focus:ring-2 focus:ring-primary-500"
                            ></textarea>
                        </div>

                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox" x-model="includeImages" class="rounded border-slate-300" />
                            Include <code class="rounded bg-slate-200 px-1 text-xs">img[src]</code> as part of the vendor audit
                        </label>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 text-xs text-slate-500">
                            Tip: if you only paste HTML without a URL, the tool can still group absolute vendor URLs by domain,
                            but it cannot reliably tell first-party from third-party or resolve relative paths.
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 pt-1">
                    <button
                        type="button"
                        :disabled="busy"
                        @click="analyze()"
                        class="inline-flex items-center rounded-xl bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-700 disabled:opacity-50"
                    >
                        <span x-show="!busy">Run audit</span>
                        <span x-show="busy" x-cloak>Auditing...</span>
                    </button>
                    <button
                        type="button"
                        @click="loadSample()"
                        class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100"
                    >
                        Load sample
                    </button>
                    <button
                        type="button"
                        @click="clear()"
                        class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
                    >
                        Clear
                    </button>
                </div>

                <p x-show="error" x-cloak x-text="error" class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"></p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Audit summary</h3>
                    <p class="mt-1 text-sm text-slate-500" x-show="!result">
                        You will get a plain-English summary, likely vendors spotted, risk flags, and a domain map you can inspect.
                    </p>
                </div>
                <button
                    type="button"
                    x-show="result"
                    @click="copyAudit()"
                    class="inline-flex shrink-0 items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100"
                    x-text="copied ? 'Copied' : 'Copy audit summary'"
                ></button>
            </div>

            <div x-show="!result" class="mt-6 grid gap-3 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Likely vendors</div>
                    <p class="mt-2 text-sm text-slate-700">Analytics, ads, chat, video, payments, fonts, CDNs, and consent tooling when recognized.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Review signals</div>
                    <p class="mt-2 text-sm text-slate-700">A simple review level plus notes on unknown domains, heavy tag stacks, and consent-related gaps.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Actionable next steps</div>
                    <p class="mt-2 text-sm text-slate-700">Recommendations you can use in privacy, performance, or vendor-cleanup conversations.</p>
                </div>
            </div>

            <template x-if="result">
                <div class="mt-5 space-y-5">
                    <div class="rounded-2xl border p-4" :class="result.review.badgeClass">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <div class="text-xs font-semibold uppercase tracking-[0.2em]" x-text="result.review.label + ' review level'"></div>
                                <h4 class="mt-2 text-lg font-semibold text-slate-900" x-text="result.headline"></h4>
                                <p class="mt-2 text-sm leading-6 text-slate-700" x-text="result.summary"></p>
                            </div>
                            <div class="grid grid-cols-2 gap-2 sm:min-w-[220px]">
                                <div class="rounded-2xl bg-white/80 p-3 text-center">
                                    <div class="text-xl font-bold text-slate-900 tabular-nums" x-text="result.stats.vendorDomains"></div>
                                    <div class="mt-1 text-[10px] uppercase tracking-wide text-slate-500">Vendor domains</div>
                                </div>
                                <div class="rounded-2xl bg-white/80 p-3 text-center">
                                    <div class="text-xl font-bold text-slate-900 tabular-nums" x-text="result.stats.categoryCount"></div>
                                    <div class="mt-1 text-[10px] uppercase tracking-wide text-slate-500">Categories spotted</div>
                                </div>
                                <div class="rounded-2xl bg-white/80 p-3 text-center">
                                    <div class="text-xl font-bold text-slate-900 tabular-nums" x-text="result.stats.unknownDomains"></div>
                                    <div class="mt-1 text-[10px] uppercase tracking-wide text-slate-500">Unknown domains</div>
                                </div>
                                <div class="rounded-2xl bg-white/80 p-3 text-center">
                                    <div class="text-xl font-bold text-slate-900 tabular-nums" x-text="result.stats.unresolvedRelative"></div>
                                    <div class="mt-1 text-[10px] uppercase tracking-wide text-slate-500">Unresolved relative</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="result.highlights.length" class="rounded-2xl border border-slate-200 p-4">
                        <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">What stands out</div>
                        <ul class="mt-3 space-y-2">
                            <template x-for="item in result.highlights" :key="item">
                                <li class="rounded-xl bg-slate-50 px-3 py-2 text-sm text-slate-700" x-text="item"></li>
                            </template>
                        </ul>
                    </div>

                    <div x-show="result.vendorHighlights.length" class="rounded-2xl border border-slate-200 p-4">
                        <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Likely tools spotted</div>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <template x-for="vendor in result.vendorHighlights" :key="vendor.key">
                                <span class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-white px-3 py-1 text-xs text-slate-700">
                                    <span x-text="vendor.label"></span>
                                    <span class="tabular-nums text-slate-400" x-text="'x' + vendor.count"></span>
                                </span>
                            </template>
                        </div>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-2">
                        <div x-show="result.categorySummary.length" class="rounded-2xl border border-slate-200 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Categories found</div>
                            <div class="mt-3 flex flex-wrap gap-2">
                                <template x-for="category in result.categorySummary" :key="category.key">
                                    <span class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700">
                                        <span x-text="category.label"></span>
                                        <span class="tabular-nums text-slate-400" x-text="'x' + category.count"></span>
                                    </span>
                                </template>
                            </div>
                        </div>

                        <div x-show="result.recommendations.length" class="rounded-2xl border border-slate-200 p-4">
                            <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Recommended next steps</div>
                            <ul class="mt-3 space-y-2">
                                <template x-for="item in result.recommendations" :key="item">
                                    <li class="text-sm leading-6 text-slate-700" x-text="item"></li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div x-show="result.warnings.length" class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                        <div class="text-xs font-semibold uppercase tracking-wide text-amber-700">Warnings</div>
                        <div class="mt-2 space-y-1">
                            <template x-for="warning in result.warnings" :key="warning">
                                <div x-text="warning"></div>
                            </template>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Vendor map</div>
                                <p class="mt-1 text-sm text-slate-500">Expand each domain to inspect the exact browser-visible URLs found in the supplied page.</p>
                            </div>
                            <div class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600" x-text="result.groups.length + ' domain group(s)'"></div>
                        </div>

                        <div class="mt-4 space-y-2 max-h-[520px] overflow-y-auto pr-1">
                            <template x-for="group in result.groups" :key="group.domain + '|' + group.tier">
                                <div class="overflow-hidden rounded-2xl border border-slate-200">
                                    <button
                                        type="button"
                                        @click="group.open = !group.open"
                                        class="flex w-full items-center justify-between gap-3 bg-white px-4 py-3 text-left hover:bg-slate-50"
                                    >
                                        <div class="min-w-0">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="truncate font-mono text-sm font-semibold text-slate-900" x-text="group.domain"></span>
                                                <span
                                                    class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide"
                                                    :class="group.tierBadgeClass"
                                                    x-text="group.tierLabel"
                                                ></span>
                                                <span class="inline-flex rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-medium text-slate-700" x-text="group.categoryLabel"></span>
                                            </div>
                                            <div class="mt-1 text-xs text-slate-500" x-text="group.resourceCount + ' hit(s) across ' + group.urls.length + ' unique URL(s)'"></div>
                                        </div>
                                        <span class="text-xs text-slate-400" x-text="group.open ? '-' : '+'"></span>
                                    </button>

                                    <div x-show="group.open" x-cloak class="border-t border-slate-200 bg-slate-50 px-4 py-3 space-y-2">
                                        <template x-for="row in group.urls" :key="row.key">
                                            <div class="text-xs">
                                                <span class="font-medium text-slate-600" x-text="row.kind + ':'"></span>
                                                <template x-if="row.linkable">
                                                    <a
                                                        :href="row.href"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="break-all font-mono text-primary-700 hover:text-primary-800 hover:underline"
                                                        x-text="row.href"
                                                    ></a>
                                                </template>
                                                <template x-if="!row.linkable">
                                                    <span class="break-all font-mono text-slate-800" x-text="row.href"></span>
                                                </template>
                                                <span
                                                    x-show="row.count > 1"
                                                    class="ml-2 inline-flex rounded-full bg-slate-200 px-1.5 py-0.5 text-[10px] font-medium text-slate-700"
                                                    x-text="'x' + row.count"
                                                ></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    function hostMatches(host, domain) {
        const h = String(host).toLowerCase();
        const d = String(domain).toLowerCase();
        return h === d || h.endsWith('.' + d);
    }

    function classifyHost(host) {
        const h = String(host).toLowerCase();
        const rules = [
            { d: 'googletagmanager.com', cat: 'analytics', label: 'Google Tag Manager' },
            { d: 'google-analytics.com', cat: 'analytics', label: 'Google Analytics' },
            { d: 'analytics.google.com', cat: 'analytics', label: 'Google Analytics' },
            { d: 'ssl.google-analytics.com', cat: 'analytics', label: 'Google Analytics' },
            { d: 'region1.google-analytics.com', cat: 'analytics', label: 'Google Analytics' },
            { d: 'stats.g.doubleclick.net', cat: 'analytics', label: 'Google / DoubleClick stats' },
            { d: 'googleadservices.com', cat: 'advertising', label: 'Google Ads' },
            { d: 'googleads.g.doubleclick.net', cat: 'advertising', label: 'Google Ads' },
            { d: 'doubleclick.net', cat: 'advertising', label: 'DoubleClick' },
            { d: 'pagead2.googlesyndication.com', cat: 'advertising', label: 'Google syndication' },
            { d: 'connect.facebook.net', cat: 'social', label: 'Meta (Facebook SDK)' },
            { d: 'facebook.net', cat: 'social', label: 'Facebook' },
            { d: 'pixel.facebook.com', cat: 'social', label: 'Meta Pixel' },
            { d: 'graph.facebook.com', cat: 'social', label: 'Facebook Graph' },
            { d: 'snap.licdn.com', cat: 'analytics', label: 'LinkedIn Insight' },
            { d: 'platform.linkedin.com', cat: 'social', label: 'LinkedIn' },
            { d: 'static.ads-twitter.com', cat: 'advertising', label: 'Twitter/X ads' },
            { d: 'static.twitter.com', cat: 'social', label: 'Twitter/X' },
            { d: 'cdn.syndication.twimg.com', cat: 'social', label: 'Twitter embed' },
            { d: 'bat.bing.com', cat: 'advertising', label: 'Microsoft Advertising' },
            { d: 'clarity.ms', cat: 'analytics', label: 'Microsoft Clarity' },
            { d: 'js.hs-scripts.com', cat: 'analytics', label: 'HubSpot' },
            { d: 'js.hs-analytics.net', cat: 'analytics', label: 'HubSpot' },
            { d: 'js.hs-banner.com', cat: 'consent', label: 'HubSpot banner' },
            { d: 'hsforms.com', cat: 'analytics', label: 'HubSpot forms' },
            { d: 'static.hotjar.com', cat: 'analytics', label: 'Hotjar' },
            { d: 'script.hotjar.com', cat: 'analytics', label: 'Hotjar' },
            { d: 'cdn.segment.com', cat: 'analytics', label: 'Segment' },
            { d: 'api.segment.io', cat: 'analytics', label: 'Segment' },
            { d: 'cdn.mxpnl.com', cat: 'analytics', label: 'Mixpanel' },
            { d: 'plausible.io', cat: 'analytics', label: 'Plausible' },
            { d: 'scripts.clarity.ms', cat: 'analytics', label: 'Microsoft Clarity' },
            { d: 'widget.intercom.io', cat: 'chat', label: 'Intercom' },
            { d: 'js.intercomcdn.com', cat: 'chat', label: 'Intercom' },
            { d: 'cdn.lr-ingest.io', cat: 'analytics', label: 'LogRocket' },
            { d: 'cdn.logrocket.io', cat: 'analytics', label: 'LogRocket' },
            { d: 'fullstory.com', cat: 'analytics', label: 'FullStory' },
            { d: 'rs.fullstory.com', cat: 'analytics', label: 'FullStory' },
            { d: 'cdn.heapanalytics.com', cat: 'analytics', label: 'Heap' },
            { d: 'static.zdassets.com', cat: 'chat', label: 'Zendesk' },
            { d: 'ekr.zdassets.com', cat: 'chat', label: 'Zendesk' },
            { d: 'client.crisp.chat', cat: 'chat', label: 'Crisp' },
            { d: 'cdn.jsdelivr.net', cat: 'cdn', label: 'jsDelivr CDN' },
            { d: 'unpkg.com', cat: 'cdn', label: 'unpkg' },
            { d: 'cdnjs.cloudflare.com', cat: 'cdn', label: 'cdnjs' },
            { d: 'ajax.googleapis.com', cat: 'cdn', label: 'Google Hosted Libraries' },
            { d: 'fonts.googleapis.com', cat: 'fonts', label: 'Google Fonts (CSS)' },
            { d: 'fonts.gstatic.com', cat: 'fonts', label: 'Google Fonts (files)' },
            { d: 'use.typekit.net', cat: 'fonts', label: 'Adobe Fonts' },
            { d: 'p.typekit.net', cat: 'fonts', label: 'Adobe Fonts' },
            { d: 'www.youtube.com', cat: 'video', label: 'YouTube' },
            { d: 'www.youtube-nocookie.com', cat: 'video', label: 'YouTube' },
            { d: 'player.vimeo.com', cat: 'video', label: 'Vimeo' },
            { d: 'i.vimeocdn.com', cat: 'video', label: 'Vimeo CDN' },
            { d: 'maps.googleapis.com', cat: 'maps', label: 'Google Maps' },
            { d: 'maps.gstatic.com', cat: 'maps', label: 'Google Maps' },
            { d: 'js.stripe.com', cat: 'payments', label: 'Stripe' },
            { d: 'm.stripe.network', cat: 'payments', label: 'Stripe' },
            { d: 'www.paypal.com', cat: 'payments', label: 'PayPal' },
            { d: 'www.paypalobjects.com', cat: 'payments', label: 'PayPal' },
            { d: 'cdn.cookielaw.org', cat: 'consent', label: 'OneTrust / CookiePro' },
            { d: 'consent.cookiebot.com', cat: 'consent', label: 'Cookiebot' },
            { d: 'cdn.onetrust.com', cat: 'consent', label: 'OneTrust' },
            { d: 'privacy-policy.truste.com', cat: 'consent', label: 'TrustArc' },
            { d: 'cdn.shopify.com', cat: 'cdn', label: 'Shopify CDN' },
            { d: 'code.jquery.com', cat: 'cdn', label: 'jQuery CDN' },
        ];
        for (const rule of rules) {
            if (hostMatches(h, rule.d)) return { category: rule.cat, label: rule.label };
        }
        if (h.includes('google') && (h.includes('analytics') || h.includes('gtm'))) {
            return { category: 'analytics', label: 'Google (other)' };
        }
        return { category: 'other', label: 'Unknown vendor' };
    }

    function tierLabel(tier) {
        if (tier === 'third') return 'Third-party';
        if (tier === 'first') return 'First-party';
        return 'Needs page URL';
    }

    function tierBadgeClass(tier) {
        if (tier === 'third') return 'bg-violet-100 text-violet-800';
        if (tier === 'first') return 'bg-slate-100 text-slate-700';
        return 'bg-amber-100 text-amber-800';
    }

    function safeUrl(href, base) {
        try {
            return new URL(href, base);
        } catch (e) {
            return null;
        }
    }

    function pushUnique(list, value) {
        if (!value || list.includes(value)) return;
        list.push(value);
    }

    async function tryFetchUrl(url) {
        const u = String(url || '').trim();
        if (!u) return { ok: false, error: 'No URL provided.' };

        try {
            const token = document.querySelector('meta[name="csrf-token"]');
            const response = await fetch('/tools/fetch-url', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token ? token.getAttribute('content') : '',
                },
                body: JSON.stringify({ url: u }),
            });

            const data = await response.json();
            if (!response.ok || data.error) {
                return { ok: false, error: data.error || 'Fetch failed.' };
            }

            return {
                ok: true,
                html: data.html || '',
                finalUrl: data.final_url || u,
            };
        } catch (e) {
            return { ok: false, error: 'Could not fetch that URL right now.' };
        }
    }

    function buildReview(vendorGroups, categorySummary, unknownDomains, unresolvedRelative, hasPageUrl) {
        const categories = categorySummary.map((item) => item.category);
        let score = 0;
        const reasons = [];

        if (vendorGroups.length >= 3) score += 1;
        if (vendorGroups.length >= 8) {
            score += 2;
            reasons.push('large external vendor footprint');
        }
        if (categories.includes('analytics')) {
            score += 1;
            reasons.push('analytics tooling present');
        }
        if (categories.includes('advertising')) {
            score += 2;
            reasons.push('advertising technology present');
        }
        if (categories.includes('payments')) {
            score += 2;
            reasons.push('payment scripts present');
        }
        if (categories.includes('chat')) {
            score += 1;
            reasons.push('chat widgets present');
        }
        if (unknownDomains > 0) {
            score += 1;
            reasons.push('unknown domains need manual review');
        }
        if (unresolvedRelative > 0) {
            score += 1;
            reasons.push('some relative URLs could not be resolved');
        }
        if (hasPageUrl && !categories.includes('consent') && (categories.includes('analytics') || categories.includes('advertising'))) {
            score += 1;
            reasons.push('no obvious consent tooling detected');
        }

        let label = 'Low';
        let badgeClass = 'border-emerald-200 bg-emerald-50 text-emerald-800';
        if (score >= 5) {
            label = 'High';
            badgeClass = 'border-rose-200 bg-rose-50 text-rose-800';
        } else if (score >= 2) {
            label = 'Moderate';
            badgeClass = 'border-amber-200 bg-amber-50 text-amber-800';
        }

        return {
            label,
            badgeClass,
            reasons,
        };
    }

    function buildSummaryText(vendorGroups, categorySummary, hasPageUrl) {
        if (!vendorGroups.length) {
            return hasPageUrl
                ? 'No obvious third-party vendors were found in the supplied HTML. That can mean the page is relatively self-contained, or that key tags are injected later after load.'
                : 'No obvious vendor domains were found in the supplied HTML. Add a page URL or a richer HTML snapshot for a more reliable audit.';
        }

        const topCategories = categorySummary.slice(0, 3).map((item) => item.label.toLowerCase());
        if (topCategories.length === 1) {
            return `The page appears to rely mostly on ${topCategories[0]} tooling.`;
        }
        if (topCategories.length === 2) {
            return `The page appears to rely on ${topCategories[0]} and ${topCategories[1]} tooling.`;
        }
        return `The page appears to rely on ${topCategories[0]}, ${topCategories[1]}, and ${topCategories[2]} tooling.`;
    }

    function buildHeadline(vendorDomainCount, reviewLabel, hasPageUrl) {
        if (!vendorDomainCount) {
            return hasPageUrl ? 'No obvious third-party vendors detected in this snapshot' : 'No obvious vendor domains detected in this snapshot';
        }
        return `${vendorDomainCount} likely external vendor domain${vendorDomainCount === 1 ? '' : 's'} detected (${reviewLabel.toLowerCase()} review)`;
    }

    function buildHighlights(vendorGroups, categorySummary, stats, hasPageUrl) {
        const items = [];

        if (!vendorGroups.length) {
            items.push('No obvious external vendors were found in the supplied HTML snapshot.');
            if (!hasPageUrl) items.push('Without a page URL, relative paths and first-party scope cannot be resolved.');
            return items;
        }

        items.push(`${stats.vendorDomains} vendor domain${stats.vendorDomains === 1 ? '' : 's'} and ${stats.vendorResources} distinct vendor URL${stats.vendorResources === 1 ? '' : 's'} were found.`);

        const topCategory = categorySummary[0];
        if (topCategory) {
            items.push(`${topCategory.count} domain${topCategory.count === 1 ? '' : 's'} matched ${topCategory.label.toLowerCase()} tooling.`);
        }

        if (stats.unknownDomains > 0) {
            items.push(`${stats.unknownDomains} domain${stats.unknownDomains === 1 ? '' : 's'} were not confidently recognized and should be reviewed manually.`);
        }

        if (stats.firstPartyResources > 0 && hasPageUrl) {
            items.push(`${stats.firstPartyResources} resource URL${stats.firstPartyResources === 1 ? '' : 's'} stayed on the page's own origin.`);
        }

        if (stats.unresolvedRelative > 0) {
            items.push(`${stats.unresolvedRelative} relative URL${stats.unresolvedRelative === 1 ? '' : 's'} could not be resolved from the supplied input.`);
        }

        return items.slice(0, 5);
    }

    function buildRecommendations(categorySummary, stats, hasPageUrl) {
        const items = [];
        const categories = categorySummary.map((item) => item.category);
        const analyticsCount = categorySummary.find((item) => item.category === 'analytics')?.count || 0;

        if (!stats.vendorDomains) {
            pushUnique(items, 'If the result looks too clean, test again with a post-render HTML snapshot from DevTools because some sites inject tags after load.');
        }

        if (stats.unknownDomains > 0) {
            pushUnique(items, 'Review unknown domains first. They are the easiest place for stale vendors, agency leftovers, or undocumented dependencies to hide.');
        }

        if (analyticsCount > 1) {
            pushUnique(items, 'You appear to have overlapping analytics tooling. Check whether all of it is still intentional before adding more tags.');
        }

        if (categories.includes('advertising') && !categories.includes('consent')) {
            pushUnique(items, 'Advertising or analytics tooling was spotted without obvious consent tooling. Double-check how and when those scripts load.');
        }

        if (categories.includes('chat')) {
            pushUnique(items, 'Load chat widgets only when needed or after interaction if performance and privacy matter on landing pages.');
        }

        if (categories.includes('video')) {
            pushUnique(items, 'Lazy-load embedded video and use privacy-enhanced embed modes where possible.');
        }

        if (categories.includes('fonts')) {
            pushUnique(items, 'If privacy or performance matters, consider self-hosting fonts instead of calling a third-party font service.');
        }

        if (categories.includes('payments')) {
            pushUnique(items, 'Check that payment scripts only appear on the pages that truly need them.');
        }

        if (stats.vendorDomains >= 8) {
            pushUnique(items, 'A large vendor footprint can slow pages and complicate privacy review. Confirm every vendor still earns its place.');
        }

        if (!hasPageUrl && stats.unresolvedRelative > 0) {
            pushUnique(items, 'Add the page URL next time so relative paths can be resolved and first-party resources can be separated from vendor domains.');
        }

        pushUnique(items, 'Use the domain map below as the starting inventory for a privacy, performance, or tag-cleanup review.');

        return items.slice(0, 6);
    }

    function summariseVendors(groups) {
        const counts = new Map();
        for (const group of groups) {
            if (!group.vendorKnown) continue;
            counts.set(group.categoryLabel, (counts.get(group.categoryLabel) || 0) + 1);
        }
        return Array.from(counts.entries())
            .map(([label, count]) => ({ key: label, label, count }))
            .sort((a, b) => b.count - a.count || a.label.localeCompare(b.label))
            .slice(0, 8);
    }

    window.tpsmBuildResourceMap = function (html, pageUrlStr, includeImages) {
        const warnings = [];
        const rawPageUrl = String(pageUrlStr || '').trim();
        let base = null;
        let pageOrigin = '';

        if (rawPageUrl) {
            try {
                base = new URL(rawPageUrl);
                pageOrigin = base.origin;
            } catch (e) {
                return { error: 'Enter a valid website URL (https://...) or leave it blank if you only want to group absolute URLs from pasted HTML.' };
            }
        }

        const hasPageUrl = Boolean(base);
        const doc = new DOMParser().parseFromString(html || '<html></html>', 'text/html');
        const rows = [];
        let unresolvedRelative = 0;

        function pushRow(kind, rawHref) {
            if (!rawHref || !String(rawHref).trim()) return;
            const raw = String(rawHref).trim();
            if (raw.startsWith('data:') || raw.startsWith('blob:') || raw.startsWith('javascript:')) return;

            const resolved = safeUrl(raw, base ? base.href : undefined);

            if (!resolved) {
                unresolvedRelative++;
                rows.push({
                    kind,
                    href: raw,
                    host: '(unresolved)',
                    tier: 'unknown',
                    tierLabel: tierLabel('unknown'),
                    tierBadgeClass: tierBadgeClass('unknown'),
                    category: 'other',
                    categoryLabel: 'Needs page URL',
                    unresolved: true,
                    vendorKnown: false,
                });
                return;
            }

            if (resolved.protocol !== 'http:' && resolved.protocol !== 'https:') return;

            const host = resolved.hostname;
            const classified = classifyHost(host);
            let tier = 'unknown';
            let category = classified.category;
            let categoryLabel = classified.label;

            if (hasPageUrl) {
                tier = resolved.origin === pageOrigin ? 'first' : 'third';
                if (tier === 'first') {
                    category = 'first_party';
                    categoryLabel = 'First-party';
                }
            } else if (category === 'other') {
                categoryLabel = 'Unknown vendor';
            }

            rows.push({
                kind,
                href: resolved.href,
                host,
                tier,
                tierLabel: tierLabel(tier),
                tierBadgeClass: tierBadgeClass(tier),
                category,
                categoryLabel,
                unresolved: false,
                vendorKnown: category !== 'other' && category !== 'first_party',
            });
        }

        doc.querySelectorAll('script[src]').forEach((el) => pushRow('script', el.getAttribute('src')));
        doc.querySelectorAll('link[rel="stylesheet"][href]').forEach((el) => pushRow('stylesheet', el.getAttribute('href')));
        doc.querySelectorAll('link[rel="preload"][href]').forEach((el) => {
            const asType = (el.getAttribute('as') || '').toLowerCase();
            pushRow('preload:' + (asType || 'asset'), el.getAttribute('href'));
        });
        doc.querySelectorAll('link[rel="modulepreload"][href]').forEach((el) => pushRow('modulepreload', el.getAttribute('href')));
        doc.querySelectorAll('link[rel="preconnect"][href], link[rel="dns-prefetch"][href]').forEach((el) => {
            const rel = (el.getAttribute('rel') || '').toLowerCase();
            pushRow(rel === 'preconnect' ? 'preconnect' : 'dns-prefetch', el.getAttribute('href'));
        });
        doc.querySelectorAll('iframe[src]').forEach((el) => pushRow('iframe', el.getAttribute('src')));
        if (includeImages) {
            doc.querySelectorAll('img[src]').forEach((el) => pushRow('img', el.getAttribute('src')));
        }

        if (!rows.length) {
            warnings.push('No external script, stylesheet, iframe, preload, or resource-hint URLs were found in the supplied HTML.');
        }

        if (!hasPageUrl && rows.some((row) => row.unresolved)) {
            warnings.push('Some relative URLs could not be resolved because no website URL was provided.');
        }

        if (!hasPageUrl && rows.some((row) => !row.unresolved)) {
            warnings.push('No website URL was provided, so this audit cannot reliably separate first-party resources from third-party vendors.');
        }

        const byHost = new Map();
        for (const row of rows) {
            const key = row.unresolved ? 'unresolved|' + row.href : row.host + '|' + row.tier;
            if (!byHost.has(key)) {
                byHost.set(key, {
                    domain: row.unresolved ? 'Could not resolve' : row.host,
                    tier: row.tier,
                    tierLabel: row.tierLabel,
                    tierBadgeClass: row.tierBadgeClass,
                    category: row.category,
                    categoryLabel: row.categoryLabel,
                    vendorKnown: row.vendorKnown,
                    urls: new Map(),
                });
            }

            const group = byHost.get(key);
            const rowKey = row.kind + '|' + row.href;
            if (!group.urls.has(rowKey)) {
                group.urls.set(rowKey, {
                    kind: row.kind,
                    href: row.href,
                    key: rowKey,
                    count: 0,
                    linkable: !row.unresolved,
                });
            }
            group.urls.get(rowKey).count++;
        }

        const groups = Array.from(byHost.values()).map((group) => ({
            domain: group.domain,
            tier: group.tier,
            tierLabel: group.tierLabel,
            tierBadgeClass: group.tierBadgeClass,
            category: group.category,
            categoryLabel: group.categoryLabel,
            vendorKnown: group.vendorKnown,
            resourceCount: Array.from(group.urls.values()).reduce((total, item) => total + item.count, 0),
            urls: Array.from(group.urls.values()).sort((a, b) => b.count - a.count || a.kind.localeCompare(b.kind) || a.href.localeCompare(b.href)),
            open: false,
        }));

        const tierOrder = { third: 0, unknown: 1, first: 2 };
        groups.sort((a, b) =>
            (tierOrder[a.tier] ?? 9) - (tierOrder[b.tier] ?? 9)
            || b.resourceCount - a.resourceCount
            || a.domain.localeCompare(b.domain)
        );

        const vendorGroups = groups.filter((group) => group.tier !== 'first');
        const vendorRows = rows.filter((row) => row.tier !== 'first' && !row.unresolved);
        const firstRows = rows.filter((row) => row.tier === 'first' && !row.unresolved);
        const vendorDomains = new Set(vendorRows.map((row) => row.host));
        const vendorResources = new Set(vendorRows.map((row) => row.kind + '|' + row.href));
        const firstPartyResources = new Set(firstRows.map((row) => row.kind + '|' + row.href));
        const unknownDomains = vendorGroups.filter((group) => group.category === 'other').length;

        const categoryCounts = new Map();
        for (const group of vendorGroups) {
            const categoryKey = group.category + '|' + group.categoryLabel;
            if (!categoryCounts.has(categoryKey)) {
                categoryCounts.set(categoryKey, {
                    key: categoryKey,
                    category: group.category,
                    label: group.categoryLabel,
                    count: 0,
                });
            }
            categoryCounts.get(categoryKey).count++;
        }

        const categorySummary = Array.from(categoryCounts.values())
            .sort((a, b) => b.count - a.count || a.label.localeCompare(b.label));

        const stats = {
            vendorDomains: vendorDomains.size,
            vendorResources: vendorResources.size,
            firstPartyResources: firstPartyResources.size,
            unknownDomains,
            unresolvedRelative,
            categoryCount: categorySummary.length,
        };

        const review = buildReview(vendorGroups, categorySummary, unknownDomains, unresolvedRelative, hasPageUrl);
        const headline = buildHeadline(stats.vendorDomains, review.label, hasPageUrl);
        const summary = buildSummaryText(vendorGroups, categorySummary, hasPageUrl);
        const highlights = buildHighlights(vendorGroups, categorySummary, stats, hasPageUrl);
        const recommendations = buildRecommendations(categorySummary, stats, hasPageUrl);
        const vendorHighlights = summariseVendors(vendorGroups);

        return {
            stats,
            review,
            headline,
            summary,
            highlights,
            recommendations,
            vendorHighlights,
            categorySummary,
            groups,
            warnings,
        };
    };
})();

function thirdPartyScriptMap() {
    return {
        websiteUrl: '',
        html: '',
        includeImages: false,
        advancedMode: false,
        busy: false,
        error: '',
        result: null,
        copied: false,
        showLimits: false,

        loadSample() {
            this.websiteUrl = 'https://www.example.com/';
            this.advancedMode = true;
            this.includeImages = true;
            this.html = `<!DOCTYPE html><html><head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://www.googletagmanager.com">
<link rel="stylesheet" href="/assets/app.css">
<script src="https://www.googletagmanager.com/gtag/js?id=G-XXXX"><\/script>
<script src="/assets/app.js"><\/script>
</head><body>
<iframe src="https://www.youtube.com/embed/abc"></iframe>
<img src="https://cdn.example.com/logo.png" alt="">
</body></html>`;
        },

        clear() {
            this.websiteUrl = '';
            this.html = '';
            this.includeImages = false;
            this.advancedMode = false;
            this.busy = false;
            this.error = '';
            this.result = null;
            this.copied = false;
        },

        async analyze() {
            this.error = '';
            this.result = null;
            this.copied = false;
            this.busy = true;

            const url = String(this.websiteUrl || '').trim();
            let html = String(this.html || '').trim();

            if (!url && !html) {
                this.busy = false;
                this.error = 'Enter a website URL or open advanced mode and paste HTML.';
                return;
            }

            if (!html && url) {
                const fetched = await tryFetchUrl(url);
                if (!fetched.ok) {
                    this.busy = false;
                    this.error = fetched.error || 'Could not fetch that URL. Use a publicly reachable HTTPS page, or open advanced mode and paste HTML from View Source or DevTools.';
                    return;
                }

                try {
                    html = fetched.html;
                    this.html = html;
                    this.advancedMode = true;
                    if (!this.websiteUrl.trim()) this.websiteUrl = fetched.finalUrl || url;
                } catch (e) {
                    this.busy = false;
                    this.error = 'Could not process the fetched page. Use a publicly reachable HTTPS page, or open advanced mode and paste HTML from View Source or DevTools.';
                    return;
                }
            }

            const out = window.tpsmBuildResourceMap(html, url, this.includeImages);
            this.busy = false;

            if (out.error) {
                this.error = out.error;
                return;
            }

            this.result = out;
        },

        async copyAudit() {
            if (!this.result) return;

            const lines = [
                '# Website vendor audit',
                '',
                `Headline: ${this.result.headline}`,
                '',
                this.result.summary,
                '',
                '## Stats',
                `- Vendor domains: ${this.result.stats.vendorDomains}`,
                `- Categories spotted: ${this.result.stats.categoryCount}`,
                `- Unknown domains: ${this.result.stats.unknownDomains}`,
                `- Unresolved relative URLs: ${this.result.stats.unresolvedRelative}`,
                '',
            ];

            if (this.result.highlights.length) {
                lines.push('## What stands out');
                for (const item of this.result.highlights) lines.push(`- ${item}`);
                lines.push('');
            }

            if (this.result.recommendations.length) {
                lines.push('## Recommended next steps');
                for (const item of this.result.recommendations) lines.push(`- ${item}`);
                lines.push('');
            }

            lines.push('## Vendor map');
            for (const group of this.result.groups) {
                lines.push(`### ${group.domain} (${group.tierLabel.toLowerCase()}) - ${group.categoryLabel}`);
                for (const row of group.urls) {
                    const suffix = row.count > 1 ? ` x${row.count}` : '';
                    lines.push(`- ${row.kind}: \`${row.href}\`${suffix}`);
                }
                lines.push('');
            }

            try {
                await navigator.clipboard.writeText(lines.join('\n'));
                this.copied = true;
                setTimeout(() => {
                    this.copied = false;
                }, 2000);
            } catch (e) {
                this.error = 'Clipboard not available.';
            }
        },
    };
}
</script>
@endpush
