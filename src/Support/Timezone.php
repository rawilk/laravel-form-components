<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Support;

use DateTime;
use DateTimeZone;

class Timezone
{
    protected static array $generalTimezones = [
        'GMT' => 'GMT',
        'UTC' => 'UTC',
    ];

    protected static array $regions = [
        TimeZoneRegion::AFRICA => DateTimeZone::AFRICA,
        TimeZoneRegion::AMERICA => DateTimeZone::AMERICA,
        TimeZoneRegion::ANTARCTICA => DateTimeZone::ANTARCTICA,
        TimeZoneRegion::ARCTIC => DateTimeZone::ARCTIC,
        TimeZoneRegion::ASIA => DateTimeZone::ASIA,
        TimeZoneRegion::ATLANTIC => DateTimeZone::ATLANTIC,
        TimeZoneRegion::AUSTRALIA => DateTimeZone::AUSTRALIA,
        TimeZoneRegion::EUROPE => DateTimeZone::EUROPE,
        TimeZoneRegion::INDIAN => DateTimeZone::INDIAN,
        TimeZoneRegion::PACIFIC => DateTimeZone::PACIFIC,
    ];

    /**
     * Specify a subset of regions to return.
     *
     * @var bool|array
     */
    protected $only;

    protected array $timezones;

    public function __construct()
    {
        $this->only(config('form-components.timezone_subset', false));
    }

    public function only($only): self
    {
        if (is_string($only)) {
            $only = [$only];
        }

        $this->only = $only;

        return $this;
    }

    public function all(): array
    {
        if (! empty($this->timezones) && $this->only === config('form-components.timezone_subset', false)) {
            return $this->timezones;
        }

        $timezones = [];

        if ($this->shouldIncludeRegion(TimeZoneRegion::GENERAL)) {
            $timezones[TimeZoneRegion::GENERAL] = self::$generalTimezones;
        }

        foreach ($this->regionsToInclude() as $region => $regionCode) {
            $regionTimezones = DateTimeZone::listIdentifiers($regionCode);
            $timezones[$region] = [];

            foreach ($regionTimezones as $timezone) {
                $timezones[$region][$timezone] = $this->format($timezone, $region);
            }
        }

        // reset to default options
        $this->only = false;

        return $this->timezones = $timezones;
    }

    protected function format(string $timezone, string $region): string
    {
        $time = new DateTime('', new DateTimeZone($timezone));
        $offset = $time->format('P');

        $timezone = substr($timezone, strlen($region) + 1);
        $timezone = str_replace(
            ['St_', '_'],
            ['St.', ' '],
            $timezone
        );

        return "(GMT/UTC {$offset}) {$timezone}";
    }

    protected function regionsToInclude(): array
    {
        if ($this->only === false) {
            return self::$regions;
        }

        return array_filter(self::$regions, fn ($region) => $this->shouldIncludeRegion($region), ARRAY_FILTER_USE_KEY);
    }

    protected function shouldIncludeRegion(string $region): bool
    {
        if ($this->only === false) {
            return true;
        }

        return in_array($region, $this->only, true);
    }
}
