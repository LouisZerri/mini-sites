<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Page d'accueil principale --}}
    <url>
        <loc>https://gestimmo-conseillers.fr</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Mini-sites des agents --}}
    @foreach($agents as $agent)
    <url>
        <loc>https://{{ $agent->slug }}.gestimmo-conseillers.fr</loc>
        <lastmod>{{ $agent->updated_at->toIso8601String() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
</urlset>