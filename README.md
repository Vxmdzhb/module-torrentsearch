# astrx/module-torrentsearch

Search page backed by the astrx-suite torrent index — the **Torrent search** module of [AstrX](https://github.com/Vxmdzhb/astrx).

![Torrent results: the first files of each torrent, its size and age, and its magnet link, on the Search page](docs/screenshot.png)

- Module key: `torrentsearch` (switch it on in the site's `resources/config/Modules.config.php`)
- Pages: `torrent_search`
- Requires: `astrx/cms`, `astrx/framework`, `astrx/library`, `astrx/module-search`

It adds a **Torrents** tab to the site's Search page
([module-search](https://github.com/Vxmdzhb/module-search)), which shows
the torrent index (`torrentds`) from [astrx-suite](https://github.com/Vxmdzhb/astrx-suite):
`/search?source=torrents&q=…`. The module's own page sits behind the tab's
"More options" link, and the navbar highlights Search there too (the
manifest's `nav_section`). Its own navbar link is off by default; Admin →
Navbar switches it on.

It ships its own templates, catalogs (en, it), default configuration and SQL in
`resources/`; the site overrides any of them from its own `resources/`.

AstrX isn't on Packagist and doesn't tag versions: you install from each
repository's `main`, and your `composer.lock` pins the exact commit. Tell
Composer where to find the package and the AstrX packages it depends on:

```json
{
    "minimum-stability": "dev",
    "prefer-stable": true,
    "repositories": [
        { "type": "vcs", "url": "https://github.com/Vxmdzhb/module-torrentsearch" },
        { "type": "vcs", "url": "https://github.com/Vxmdzhb/module-search" },
        { "type": "vcs", "url": "https://github.com/Vxmdzhb/cms" },
        { "type": "vcs", "url": "https://github.com/Vxmdzhb/framework" },
        { "type": "vcs", "url": "https://github.com/Vxmdzhb/library" }
    ]
}
```

Then:

```sh
composer require astrx/module-torrentsearch:dev-main
```

After that, list `AstrX\TorrentSearch\TorrentSearchModule::class` in the
site's `ApplicationModules::INSTALLED` and run the installer to create its
tables. See [modules](https://github.com/Vxmdzhb/astrx/blob/main/docs/MODULES.md).

Issues and pull requests are welcome here. [AstrX](https://github.com/Vxmdzhb/astrx)
is the site that puts all the packages together.

## License

Released under the [Do Whatever License](LICENSE), with a code of conduct
in the same spirit: [CODE_OF_CONDUCT](CODE_OF_CONDUCT).
