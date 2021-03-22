<?php

namespace Modules\Exercise01\Tests\Unit\Services;

use Carbon\Carbon;
use InvalidArgumentException;
use Modules\Exercise01\Services\DTO\Price;
use Modules\Exercise01\Services\PriceService;
use Tests\TestCase;

class PriceServiceTest extends TestCase
{
    protected $priceService;

    public function setUp(): void
    {
        parent::setUp();
        $this->priceService = new PriceService;
    }

    public function test_calculate_before_special_time_without_vouncher()
    {
        Carbon::setTestNow(Carbon::create(null, null, null, 15, 59, 00));
        $result = $this->priceService->calculate(10, false);

        $this->assertInstanceOf(Price::class, $result);
        $this->assertEquals(4900, $result->getTotal());
        $this->assertEquals(0, $result->getVoucherDiscount());
        $this->assertEquals(0, $result->getSpecialTimeDiscount());
    }

    public function test_calculate_min_special_time_without_vouncher()
    {
        Carbon::setTestNow(Carbon::create(null, null, null, 16, 00, 00));
        $result = $this->priceService->calculate(10, false);

        $this->assertInstanceOf(Price::class, $result);
        $this->assertEquals(2900, $result->getTotal());
        $this->assertEquals(0, $result->getVoucherDiscount());
        $this->assertEquals(2000, $result->getSpecialTimeDiscount());
    }

    public function test_calculate_max_special_time_without_vouncher()
    {
        Carbon::setTestNow(Carbon::create(null, null, null, 17, 59, 00));
        $result = $this->priceService->calculate(10, false);

        $this->assertInstanceOf(Price::class, $result);
        $this->assertEquals(2900, $result->getTotal());
        $this->assertEquals(0, $result->getVoucherDiscount());
        $this->assertEquals(2000, $result->getSpecialTimeDiscount());
    }

    public function test_calculate_after_special_time_without_vouncher()
    {
        Carbon::setTestNow(Carbon::create(null, null, null, 18, 00, 00));
        $result = $this->priceService->calculate(10, false);

        $this->assertInstanceOf(Price::class, $result);
        $this->assertEquals(4900, $result->getTotal());
        $this->assertEquals(0, $result->getVoucherDiscount());
        $this->assertEquals(0, $result->getSpecialTimeDiscount());
    }

    public function test_calculate_before_special_time_have_vouncher()
    {
        Carbon::setTestNow(Carbon::create(null, null, null, 15, 59, 00));
        $result = $this->priceService->calculate(10, true);

        $this->assertInstanceOf(Price::class, $result);
        $this->assertEquals(4510, $result->getTotal());
        $this->assertEquals(390, $result->getVoucherDiscount());
        $this->assertEquals(0, $result->getSpecialTimeDiscount());
    }

    public function test_calculate_min_special_time_have_vouncher()
    {
        Carbon::setTestNow(Carbon::create(null, null, null, 16, 00, 00));
        $result = $this->priceService->calculate(10, true);

        $this->assertInstanceOf(Price::class, $result);
        $this->assertEquals(2710, $result->getTotal());
        $this->assertEquals(390, $result->getVoucherDiscount());
        $this->assertEquals(1800, $result->getSpecialTimeDiscount());
    }

    public function test_calculate_max_special_time_have_vouncher()
    {
        Carbon::setTestNow(Carbon::create(null, null, null, 17, 59, 00));
        $result = $this->priceService->calculate(10, true);

        $this->assertInstanceOf(Price::class, $result);
        $this->assertEquals(2710, $result->getTotal());
        $this->assertEquals(390, $result->getVoucherDiscount());
        $this->assertEquals(1800, $result->getSpecialTimeDiscount());
    }

    public function test_calculate_after_special_time_have_vouncher()
    {
        Carbon::setTestNow(Carbon::create(null, null, null, 18, 00, 00));
        $result = $this->priceService->calculate(10, true);

        $this->assertInstanceOf(Price::class, $result);
        $this->assertEquals(4510, $result->getTotal());
        $this->assertEquals(390, $result->getVoucherDiscount());
        $this->assertEquals(0, $result->getSpecialTimeDiscount());
    }

    public function test_quality_exception()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->priceService->calculate(-1, true);
    }
}
