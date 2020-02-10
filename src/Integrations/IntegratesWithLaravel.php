<?php

declare(strict_types=1);

namespace HttpClient\Integrations;

trait IntegratesWithLaravel
{
    /**
     * Determine whether WeForge is running in Laravel framework.
     *
     * @var bool
     */
    public static $runningInLaravel = false;
}
