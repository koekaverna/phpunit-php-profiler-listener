<?php declare(strict_types=1);
/*
 * This file is part of phpunit/phpunit-tideways-listener.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Xhgui;

use PHPUnit\Runner\AfterTestHook;
use PHPUnit\Runner\BeforeTestHook;
use Xhgui\Profiler\Profiler;

final class TestListener implements AfterTestHook, BeforeTestHook
{
    /**
     * @var Profiler
     */
    private Profiler $profiler;

    public function __construct(array $config = [])
    {
        $this->profiler = new Profiler($config);
    }

    public function executeBeforeTest(string $test): void
    {
        // \TIDEWAYS_XHPROF_FLAGS_MEMORY | \TIDEWAYS_XHPROF_FLAGS_CPU
        $this->profiler->enable();
    }

    public function executeAfterTest(string $test, float $time): void
    {
        $data = $this->profiler->disable();
        $this->profiler->save($data);
    }
}
