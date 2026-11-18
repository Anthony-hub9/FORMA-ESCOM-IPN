<?php

declare(strict_types=1);

use App\Services\HorarioOverlapService;
use CodeIgniter\Test\CIUnitTestCase;

final class HorarioOverlapServiceTest extends CIUnitTestCase
{
    private HorarioOverlapService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new HorarioOverlapService();
    }

    public function testIntervalosAdyacentesNoSeTraslapan(): void
    {
        $this->assertFalse($this->service->intervalosSeTraslapan('10:00', '12:00', '12:00', '14:00'));
        $this->assertFalse($this->service->intervalosSeTraslapan('12:00', '14:00', '10:00', '12:00'));
    }

    public function testIntervalosDisjuntosNoSeTraslapan(): void
    {
        $this->assertFalse($this->service->intervalosSeTraslapan('08:00', '10:00', '14:00', '16:00'));
    }

    public function testTraslapeParcial(): void
    {
        $this->assertTrue($this->service->intervalosSeTraslapan('10:00', '12:00', '11:30', '13:00'));
        $this->assertTrue($this->service->intervalosSeTraslapan('11:30', '13:00', '10:00', '12:00'));
    }

    public function testIntervaloContenido(): void
    {
        $this->assertTrue($this->service->intervalosSeTraslapan('09:00', '14:00', '10:00', '12:00'));
        $this->assertTrue($this->service->intervalosSeTraslapan('10:00', '12:00', '09:00', '14:00'));
    }

    public function testIntervaloIdentico(): void
    {
        $this->assertTrue($this->service->intervalosSeTraslapan('10:00:00', '12:00:00', '10:00', '12:00'));
    }

    public function testRangoInvalidoLanzaExcepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->intervalosSeTraslapan('12:00', '10:00', '13:00', '14:00');
    }

    public function testRangoIgualLanzaExcepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->intervalosSeTraslapan('10:00', '10:00', '11:00', '12:00');
    }
}
