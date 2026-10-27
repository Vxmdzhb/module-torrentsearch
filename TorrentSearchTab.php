<?php
declare(strict_types=1);

namespace AstrX\TorrentSearch;

use AstrX\I18n\Translator;
use AstrX\Routing\UrlGenerator;
use AstrX\Search\Tab\SearchHit;
use AstrX\Search\Tab\SearchTab;
use AstrX\Search\Tab\SearchTabPage;

/**
 * The Search page's "Torrents" tab: torrents through the torrentds engine,
 * listed the way BTDigg lists them — the name, the first few files with their
 * sizes, then size, file count, when the index first saw it, and the magnet
 * and .torrent links. The name opens the torrent's own page with every file.
 */
final class TorrentSearchTab implements SearchTab
{
    public function __construct(
        private readonly TorrentSearchClient $client,
        private readonly TorrentAge $age,
        private readonly Translator $t,
        private readonly UrlGenerator $urlGen,
    ) {}

    public function key(): string
    {
        return 'torrents';
    }

    public function label(): string
    {
        $this->t->load('TorrentSearch');
        return $this->t->t('torrentsearch.tab');
    }

    public function order(): int
    {
        return 30;
    }

    public function search(string $query, int $page): SearchTabPage
    {
        $this->t->load('TorrentSearch');
        $slug = $this->t->t('WORDING_TORRENTSEARCH');
        $more = $this->urlGen->toPage($slug, ['q' => $query]);
        $resp = $this->client->search($query, $page);
        if (!$resp['ok']) {
            return SearchTabPage::unavailable($more);
        }
        $hits = [];
        foreach ($resp['results'] as $r) {
            $hits[] = TorrentHits::hit($r, $this->urlGen->toPage($slug, ['ih' => $r['infohash']]), $this->t, $this->age);
        }
        $pages = max(1, intdiv($resp['total'] + max(1, $resp['page_size']) - 1, max(1, $resp['page_size'])));
        return new SearchTabPage(true, $hits, $resp['total'], $resp['page'] < $pages, $more);
    }
}
