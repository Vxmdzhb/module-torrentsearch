<?php
declare(strict_types=1);

namespace AstrX\TorrentSearch;

use AstrX\I18n\Translator;
use AstrX\Search\Tab\SearchHit;

/**
 * One torrent as a search result, BTDigg style: the name, its first files
 * with their sizes, a line of facts (size, file count, when it was first
 * seen, the swarm when known) and the magnet and .torrent links. Shared by
 * the Search page's Torrents tab and the torrent search page.
 */
final class TorrentHits
{
    /**
     * @param array{infohash:string, name:string, size:string, file_count:int, magnet:string,
     *              torrent_url:string, swarm:string, files:list<array{path:string, size:string, size_bytes:int}>,
     *              first_seen_ts:int} $r a result row from TorrentSearchClient::search()
     */
    public static function hit(array $r, string $detailUrl, Translator $t, TorrentAge $age): SearchHit
    {
        $t->load('TorrentSearch');
        $meta = [
            $t->t('torrentsearch.size') . ': ' . $r['size'],
            $t->t('torrentsearch.files') . ': ' . $r['file_count'],
        ];
        $found = $age->found($r['first_seen_ts']);
        if ($found !== '') {
            $meta[] = $found;
        }
        if ($r['swarm'] !== '') {
            $meta[] = $t->t('torrentsearch.swarm') . ': ' . $r['swarm'];
        }
        $files = [];
        foreach ($r['files'] as $f) {
            $files[] = ['path' => $f['path'], 'size' => $f['size']];
        }
        $links = [['label' => $t->t('torrentsearch.magnet'), 'url' => $r['magnet']]];
        if ($r['torrent_url'] !== '') {
            $links[] = ['label' => $t->t('torrentsearch.torrent'), 'url' => $r['torrent_url']];
        }
        return new SearchHit(
            title:     $r['name'],
            url:       $detailUrl,
            meta:      $meta,
            links:     $links,
            files:     $files,
            // Only when the engine listed some: an older one sends none, and
            // "+ 3 more files" over an empty list would be odd.
            moreFiles: $files === [] ? 0 : max(0, $r['file_count'] - count($files)),
            external:  false,
        );
    }
}
