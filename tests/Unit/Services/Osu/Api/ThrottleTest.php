<?php

namespace Tests\Unit\Services\Osu\Api;

use App\Services\Osu\Api\Throttle;
use Illuminate\Contracts\Cache\Store;
use Mockery;
use PHPUnit\Framework\TestCase;

class ThrottleTest extends TestCase
{
    protected Throttle $throttle;
    protected array $throttle_settings;
    protected string $key;
    protected int $accountId;

    protected $cacheMock;

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->cacheMock = Mockery::mock(Store::class);
        app()->bind('cache.store', fn() => $this->cacheMock);

        $this->accountId = 1;
        $this->throttle_settings = [
            'attempt_count' => 2,
            'time_out' => 60,
        ];
        $this->key = 'ApiThrottle:Osu:' . $this->accountId;
        $this->throttle = new Throttle($this->throttle_settings);
        $this->throttle->setAccountId($this->accountId);
    }

    public function testCheckIsNotCacheKey(): void
    {
        $this->cacheMock
            ->shouldReceive('tags')
            ->withArgs(['osu'])
            ->once()
            ->andReturn($this->cacheMock);

        $this->cacheMock
            ->shouldReceive('has')
            ->withArgs([$this->key])
            ->once()
            ->andReturn(false);

        $status = $this->throttle->check();
        $this->assertFalse($status);
    }

    public function testCheckIsFailTimeOut(): void
    {
        $this->cacheMock
            ->shouldReceive('tags')
            ->withArgs(['osu'])
            ->twice()
            ->andReturn($this->cacheMock);

        $this->cacheMock
            ->shouldReceive('has')
            ->withArgs([$this->key])
            ->once()
            ->andReturn(true);

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key.':FailTimeOut'])
            ->once()
            ->andReturn('33');

        $status = $this->throttle->check();
        $this->assertTrue($status);
    }

    public function testCheckIsNotAttemptCount()
    {
        $this->cacheMock
            ->shouldReceive('tags')
            ->withArgs(['osu'])
            ->times(3)
            ->andReturn($this->cacheMock);

        $this->cacheMock
            ->shouldReceive('has')
            ->withArgs([$this->key])
            ->once()
            ->andReturn('33');

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key.':FailTimeOut'])
            ->once()
            ->andReturn(null);

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key])
            ->once()
            ->andReturn('1');


        $status = $this->throttle->check();
        $this->assertFalse($status);
    }

    public function testCheckIsNotThrottle()
    {
        $this->cacheMock
            ->shouldReceive('tags')
            ->withArgs(['osu'])
            ->times(4)
            ->andReturn($this->cacheMock);

        $this->cacheMock
            ->shouldReceive('has')
            ->withArgs([$this->key])
            ->once()
            ->andReturn('33');

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key.':FailTimeOut'])
            ->once()
            ->andReturn(null);

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key])
            ->once()
            ->andReturn('2');

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key.':TimeOut'])
            ->once()
            ->andReturn('20');

        $status = $this->throttle->check();
        $this->assertFalse($status);
    }

    public function testCheckIsThrottle()
    {
        $this->cacheMock
            ->shouldReceive('tags')
            ->withArgs(['osu'])
            ->times(4)
            ->andReturn($this->cacheMock);

        $this->cacheMock
            ->shouldReceive('has')
            ->withArgs([$this->key])
            ->once()
            ->andReturn('33');

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key.':FailTimeOut'])
            ->once()
            ->andReturn(null);

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key])
            ->once()
            ->andReturn('2');

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key.':TimeOut'])
            ->once()
            ->andReturn('10000000000000000');

        $status = $this->throttle->check();
        $this->assertTrue($status);
    }


    public function testAndCountIncrement()
    {
        $this->cacheMock
            ->shouldReceive('tags')
            ->withArgs(['osu'])
            ->times(2)
            ->andReturn($this->cacheMock);

        $this->cacheMock
            ->shouldReceive('has')
            ->withArgs([$this->key])
            ->once()
            ->andReturn('33');

        $this->cacheMock
            ->shouldReceive('increment')
            ->withArgs([$this->key])
            ->once();

        $this->throttle->addCount();

        // заглушка, т.к. без нее PHPUnit просто выдаст предупреждение о том, что в данном тесте нет никаких проверок, но это не так
        $this->assertTrue(True);
    }

    public function testAndCountIncrementPut()
    {
        $this->cacheMock
            ->shouldReceive('tags')
            ->withArgs(['osu'])
            ->times(3)
            ->andReturn($this->cacheMock);

        $this->cacheMock
            ->shouldReceive('has')
            ->withArgs([$this->key])
            ->once()
            ->andReturn(null);

        $this->cacheMock
            ->shouldReceive('put')
            ->withArgs([$this->key, 1, $this->throttle_settings['time_out']])
            ->once();

        $this->cacheMock
            ->shouldReceive('put')
            ->withArgs([$this->key.':TimeOut', time(), $this->throttle_settings['time_out']])
            ->once();

        $this->throttle->addCount();

        $this->assertTrue(True);
    }

    public function testGetTimeOutIsZero()
    {
        $this->cacheMock
            ->shouldReceive('tags')
            ->withArgs(['osu'])
            ->times(1)
            ->andReturn($this->cacheMock);

        $this->cacheMock
            ->shouldReceive('has')
            ->withArgs([$this->key])
            ->once()
            ->andReturn(null);

        $timeOut = $this->throttle->getTimeOut();
        $this->assertEquals(0, $timeOut);
    }

    public function testGetTimeOutFail()
    {
        $failCount = 1;
        $time = 33;

        $this->cacheMock
            ->shouldReceive('tags')
            ->withArgs(['osu'])
            ->times(3)
            ->andReturn($this->cacheMock);

        $this->cacheMock
            ->shouldReceive('has')
            ->withArgs([$this->key])
            ->once()
            ->andReturn($failCount);

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key])
            ->once()
            ->andReturn($failCount);

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key.':TimeOut'])
            ->once()
            ->andReturn($time);

        $timeOut = $this->throttle->getTimeOut();
        $condition = $time + $this->throttle_settings['time_out'] - time();

        $this->assertEquals($condition, $timeOut);
    }

    public function testGetTimeOutIncrement()
    {
        $failCount = 3;
        $failTimeOut = 90;

        $this->cacheMock
            ->shouldReceive('tags')
            ->withArgs(['osu'])
            ->times(4)
            ->andReturn($this->cacheMock);

        $this->cacheMock
            ->shouldReceive('has')
            ->withArgs([$this->key])
            ->once()
            ->andReturn($failCount);

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key])
            ->once()
            ->andReturn($failCount);

        $this->cacheMock
            ->shouldReceive('has')
            ->withArgs([$this->key.':FailTimeOut'])
            ->once()
            ->andReturn('3');

        $this->cacheMock
            ->shouldReceive('get')
            ->withArgs([$this->key.':FailTimeOut'])
            ->once()
            ->andReturn($failTimeOut);


        $multiplier = ceil($failCount / $this->throttle_settings['attempt_count']);
        $assert = $failTimeOut + ($multiplier * $this->throttle_settings['time_out'])  - time();

        $result = $this->throttle->getTimeOut();

        $this->assertEquals($assert, $result);
    }
}
