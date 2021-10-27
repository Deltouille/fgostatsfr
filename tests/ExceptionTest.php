<?php
# tests/Util/CalculatriceTest.php
namespace Tests\Util;
use App\Util\Calculatrice;
use PHPUnit\Framework\TestCase;
class ExceptionTest extends TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testException()
    {
        $calculatrice = new Calculatrice();
        $calculatrice->carre("test");
    }
}