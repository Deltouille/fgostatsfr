<?php
# src/Util/Calculatrice.php
namespace App\Util;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class Calculatrice {
    public function carre($n) {
        if(!is_int($n)) {
            throw new InvalidArgumentException("La méthode 'carre()' accepte uniquement un entier en entrée.");
        }
        return $n * $n;
    }
}