<?php
declare(strict_types=1);

/**
 * Torrent search backend config. The section 'TorrentSearchConfig' is named
 * after the class; there is no TorrentSearchConfig.config.php, so ModuleLoader
 * falls back to this file, named after the parent namespace segment (like
 * BotTrapConfig → BotTrap.config.php).
 *
 * base_url must be the local torrentds search server. Only its scheme and
 * host are used; the user's query, page and (validated hex) infohash are
 * appended safely. Anything that isn't http(s) is replaced by the localhost
 * default. The same origin is used for the .torrent download link, which only
 * works if visitors can reach base_url (it's loopback by default); magnet
 * links work regardless.
 */
return [
    'TorrentSearchConfig' => [
        'base_url'        => 'http://127.0.0.1:8804', // torrentds `search` endpoint (localhost only)
        'timeout_seconds' => 3,                       // per-request network timeout (clamped 1–5)
        'per_page'        => 25,                       // results-per-page (torrentds clamps `limit`; clamped 1–100)
    ],
];
