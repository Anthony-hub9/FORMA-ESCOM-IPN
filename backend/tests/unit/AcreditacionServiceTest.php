<?php

declare(strict_types=1);

use App\Services\AcreditacionService;
use App\Services\InscripcionService;
use CodeIgniter\Test\CIUnitTestCase;

final class AcreditacionServiceTest extends CIUnitTestCase
{
    private AcreditacionService $acreditacionService;
    private InscripcionService $inscripcionService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->acreditacionService = new AcreditacionService();
        $this->inscripcionService  = new InscripcionService();
    }

    public function testCalcularPorcentajeAsistencia(): void
    {
        $this->assertSame(80.0, $this->acreditacionService->calcularPorcentajeAsistencia(8, 10));
        $this->assertSame(0.0, $this->acreditacionService->calcularPorcentajeAsistencia(0, 0));
        $this->assertSame(83.33, $this->acreditacionService->calcularPorcentajeAsistencia(5, 6));
    }

    public function testCalcularPorcentajeAsistenciaInvalido(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->acreditacionService->calcularPorcentajeAsistencia(11, 10);
    }

    public function testEvaluarDictamenUmbrales(): void
    {
        $this->assertSame('ACREDITADO', $this->acreditacionService->evaluarDictamen(80.0, 70.0));
        $this->assertSame('ACREDITADO', $this->acreditacionService->evaluarDictamen(100.0, 95.5));
        $this->assertSame('NO_ACREDITADO', $this->acreditacionService->evaluarDictamen(79.99, 95.0));
        $this->assertSame('NO_ACREDITADO', $this->acreditacionService->evaluarDictamen(90.0, 69.99));
    }

    public function testGenerarTokenConstanciaFormatoSha256(): void
    {
        $tokenA = $this->acreditacionService->generarTokenConstancia(1, 10);
        $tokenB = $this->acreditacionService->generarTokenConstancia(1, 10);

        $this->assertMatchesRegularExpression('/^[0-9a-f]{64}$/', $tokenA);
        $this->assertSame(64, strlen($tokenA));
        $this->assertNotSame($tokenA, $tokenB);
    }

    public function testPuedeAbrirGrupo(): void
    {
        $this->assertFalse($this->inscripcionService->puedeAbrirGrupo(0));
        $this->assertFalse($this->inscripcionService->puedeAbrirGrupo(24));
        $this->assertTrue($this->inscripcionService->puedeAbrirGrupo(25));
        $this->assertTrue($this->inscripcionService->puedeAbrirGrupo(35));
    }

    public function testPuedeAbrirGrupoNegativoLanzaExcepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->inscripcionService->puedeAbrirGrupo(-1);
    }
}
