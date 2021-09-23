<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Developer;

class DeveloperTest extends TestCase
{
    
    /**
     * Verifica se todas as colunas fillable do model estão corretas
     *
     * @return void
     */
    public function test_if_developer_columns_is_correct()
    {
        $developer = new Developer;

        $expected = [
            'nome',
            'sexo',
            'idade',
            'hobby',
            'datanascimento'
        ];

        $arrayCompared = array_diff($expected, $developer->getFillable());

        $this->assertEquals(0, count($arrayCompared));
    }
}
