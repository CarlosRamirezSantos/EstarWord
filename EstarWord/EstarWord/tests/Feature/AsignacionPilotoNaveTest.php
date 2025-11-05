<?php

namespace Tests\Feature;

use App\Models\Piloto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Planeta;


class AsignacionPilotoNaveTest extends TestCase
{
    use RefreshDatabase;


    public function test_flujo_completo_de_registro_y_asignacion()
    {
        $adminUser = User::factory()->create([
            'rol' => 'admin'
        ]);
        $this->actingAs($adminUser);

        $planeta = Planeta::factory()->create();

        $piloto = Piloto::factory()->create();


        $responsePiloto = $this->postJson('/api/insertarPiloto', $piloto->toArray());

        $responsePiloto->assertStatus(201);
        // Guardamos el ID del piloto que acabamos de crear
        $pilotoId = $responsePiloto->json('id');


        $naveData = [
            'nombre' => 'Black One',
            'modelo' => 'T-70 X-wing',
            'tripulacion' => 1,
            'pasajeros' => 0,
            'clase_nave' => 'Combate',
            'planeta_id' => $planeta->id, // Usamos el ID del planeta de arriba
        ];

        // Llamamos a tu ruta /api/insertarNave
        $responseNave = $this->postJson('/api/insertarNave', $naveData);

        $responseNave->assertStatus(201);
        // Guardamos el ID de la nave que acabamos de crear
        $naveId = $responseNave->json('id');

        // Llamamos a tu ruta: POST /api/asignarPilotoANave/{idNave}
        $responseAsignacion = $this->postJson(
            "/api/asignarPilotoANave/{$naveId}", 
            ['id' => $pilotoId] 
        );

        $responseAsignacion->assertStatus(200);
        $responseAsignacion->assertJson(['mensaje' => 'Piloto asignado correctamente']);


    
        $this->assertDatabaseHas('piloto_nave', [
            'piloto_id' => $pilotoId,
            'nave_id' => $naveId,
            'fecha_fin' => null 
        ]);
    }
}