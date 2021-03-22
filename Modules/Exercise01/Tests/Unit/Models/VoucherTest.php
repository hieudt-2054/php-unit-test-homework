<?php

namespace Modules\Exercise01\Tests\Unit\Models\VoucherTest;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Modules\Exercise01\Models\Voucher;
use Modules\Exercise01\Services\DTO\Price;
use Modules\Exercise01\Services\PriceService;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    use RefreshDatabase;

    protected $vouncher;

    public function setUp(): void
    {
        parent::setUp();
        $this->vouncher = new Voucher;
    }

    public function test_get_table_name()
    {
        $tableName = Voucher::getTableName();

        $this->assertEquals('vouchers', $tableName);
    }

    public function test_new_factory()
    {
        $voucher = Voucher::newFactory();

        $this->assertInstanceOf(Voucher::class, $voucher);
        $this->assertArrayHasKey('code', $voucher);
        $this->assertArrayHasKey('is_active', $voucher);
    }
}
