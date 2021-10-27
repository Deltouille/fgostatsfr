<?php
# tests/Util/CalculatriceTest.php
namespace Tests\Util;
use App\Util\Calculatrice;
use PHPUnit\Framework\TestCase;
class CalculatriceTest extends TestCase {
    public function testCarre() {
        $calculatrice = new Calculatrice();
        $this->assertEquals(4, $calculatrice->carre(2));
        $this->assertEquals(16, $calculatrice->carre(4));
        $this->assertEquals(25, $calculatrice->carre(5));
    }

    public function testCarre2($n, $expected){
        $calculatrice = new Calculatrice();
        $this->assertSame($expected, $calculatrice->carre($n));
    }

    public function carreProvider(){
        return [
            [2, 4],
            [4, 16],
            [5, 25]
        ];
    }
}