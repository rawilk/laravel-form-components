<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Support;

/**
 * We will be dropping this class at some point in the future if we
 * drop support for PHP 8.0.
 *
 * @deprecated Use TimeZoneRegionEnum instead if on PHP 8.1+.
 */
final class TimeZoneRegion
{
    /**
     * A "general" timezone region.
     *
     * @var string
     */
    public const GENERAL = 'General';

    /** @var string */
    public const AFRICA = 'Africa';

    /** @var string */
    public const AMERICA = 'America';

    /** @var string */
    public const ANTARCTICA = 'Antarctica';

    /** @var string */
    public const ARCTIC = 'Arctic';

    /** @var string */
    public const ASIA = 'Asia';

    /** @var string */
    public const ATLANTIC = 'Atlantic';

    /** @var string */
    public const AUSTRALIA = 'Australia';

    /** @var string */
    public const EUROPE = 'Europe';

    /** @var string */
    public const INDIAN = 'Indian';

    /** @var string */
    public const PACIFIC = 'Pacific';
}
