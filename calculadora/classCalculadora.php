<?php

class Calculadora
{
    private $numero1;
    private $numero2;

    public function __construct($numero1, $numero2)
    {
        $this->numero1 = floatval($numero1);
        $this->numero2 = floatval($numero2);
    }

    public function sumar()
    {
        return $this->numero1 + $this->numero2;
    }

    public function restar()
    {
        return $this->numero1 - $this->numero2;
    }

    public function multiplicar()
    {
        return $this->numero1 * $this->numero2;
    }

    public function dividir()
    {
        if ($this->numero2 == 0) {
            return "Error: no se puede dividir por cero";
        }
        return $this->numero1 / $this->numero2;
    }

    // Calcula qué es "numero1 % de numero2" (ej: 20% de 150 = 30)
    public function porcentaje()
    {
        return ($this->numero1 / 100) * $this->numero2;
    }

    public function calcular($operacion)
    {
        switch ($operacion) {
            case 'suma':
                return $this->sumar();
            case 'resta':
                return $this->restar();
            case 'multiplicacion':
                return $this->multiplicar();
            case 'division':
                return $this->dividir();
            case 'porcentaje':
                return $this->porcentaje();
            default:
                return "Operación no válida";
        }
    }

    public static function simboloOperacion($operacion)
    {
        $simbolos = [
            'suma' => '+',
            'resta' => '-',
            'multiplicacion' => '×',
            'division' => '÷',
            'porcentaje' => '% de'
        ];
        return isset($simbolos[$operacion]) ? $simbolos[$operacion] : '?';
    }

    public static function nombreOperacion($operacion)
    {
        $nombres = [
            'suma' => 'Suma',
            'resta' => 'Resta',
            'multiplicacion' => 'Multiplicación',
            'division' => 'División',
            'porcentaje' => 'Porcentaje'
        ];
        return isset($nombres[$operacion]) ? $nombres[$operacion] : 'Operación';
    }
}
?>
