<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Planeta;
use App\Models\Nave;
use App\Models\Piloto;
use App\Models\Mantenimiento;

class FuncionalidadesVariasTest extends TestCase
{
    // Esto hace que la BBDD se resetee en cada test.
    use RefreshDatabase;

    protected function loginAsAdmin()
    {
        $adminUser = User::factory()->create([
            'rol' => 'admin'
        ]);
        $this->actingAs($adminUser);
    }

  

    public function test_se_puede_registrar_una_nave()
    {

        $this->loginAsAdmin();

        // Para registrar una nave, la validación nos pide un planeta_id que exista.
        // Así que creamos uno falso primero.
        $planeta = Planeta::factory()->create();

        $naveData = [
            'nombre' => 'Halcón Milenario',
            'modelo' => 'YT-1300',
            'tripulacion' => 2,
            'pasajeros' => 6,
            'clase_nave' => 'Carguero',
            'planeta_id' => $planeta->id,
        ];

        
        $response = $this->postJson('/api/insertarNave', $naveData);

        $response->assertStatus(201); 
        $this->assertDatabaseHas('naves', [
            'nombre' => 'Halcón Milenario'
        ]);
    }

    public function test_se_puede_borrar_un_piloto()
    {

        $this->loginAsAdmin();

        $piloto = Piloto::factory()->create();


        $response = $this->deleteJson("/api/eliminarPiloto/{$piloto->id}");

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('pilotos', [
            'id' => $piloto->id
        ]);
    }


    public function test_se_puede_modificar_un_mantenimiento()
    {
        $this->loginAsAdmin();

        
        $planeta = Planeta::factory()->create();
        $nave = Nave::factory()->create([
            'planeta_id' => $planeta->id
        ]);
        $mantenimiento = Mantenimiento::factory()->create([
            'nave_id' => $nave->id
        ]);

        $datosNuevos = [
            'descripcion' => 'Hiperimpulsor reparado',
            'fecha' => now()->format('Y-m-d H:i:s'),
            'coste' => $mantenimiento->coste,
            'nave_id' => $mantenimiento->nave_id,
        ];

        $response = $this->putJson("/api/modificarMantenimiento/{$mantenimiento->id}", $datosNuevos);

        $response->assertStatus(200);
        $this->assertDatabaseHas('mantenimientos', [
            'id' => $mantenimiento->id,
            'descripcion' => 'Hiperimpulsor reparado'
        ]);
    }
}