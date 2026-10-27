<?php
declare(strict_types=1);

namespace AstrX\TorrentSearch;

use AstrX\I18n\Translator;

/**
 * "Found 3 months ago": how long ago the index first saw a torrent, in the
 * coarse words a results list needs.
 */
final class TorrentAge
{
    public function __construct(private readonly Translator $t) {}

    /** The phrase for a first-seen unix time, or '' when unknown. */
    public function found(int $firstSeen, ?int $now = null): string
    {
        if ($firstSeen <= 0) {
            return '';
        }
        $days = intdiv(max(0, ($now ?? time()) - $firstSeen), 86400);
        $this->t->load('TorrentSearch');
        $when = match (true) {
            $days < 1   => $this->t->t('torrentsearch.age.today'),
            $days < 2   => $this->t->t('torrentsearch.age.yesterday'),
            $days < 45  => $this->t->t('torrentsearch.age.days', ['n' => $days]),
            $days < 548 => $this->t->t('torrentsearch.age.months', ['n' => max(2, intdiv($days, 30))]),
            default     => $this->t->t('torrentsearch.age.years', ['n' => max(2, intdiv($days, 365))]),
        };
        return $this->t->t('torrentsearch.found', ['when' => $when]);
    }
}
