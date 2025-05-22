<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'name' => 'Jornada de Limpieza en Refugio Canino',
            'creation_date' => '2025-05-18',
            'time_date_start' => '2025-06-01 09:00:00',
            'time_date_end' => '2025-06-01 14:00:00',
            'description' => 'Ayuda a limpiar y acondicionar las instalaciones del refugio para perros abandonados.',
            'location' => 'Refugio Canino Esperanza, Madrid',
            'directions' => 'Calle de los Animales 123, Madrid. Metro: Estación Esperanza.'
        ]);

        Event::create([
            'name' => 'Paseo Solidario con Mascotas',
            'creation_date' => '2025-05-18',
            'time_date_start' => '2025-06-10 10:00:00',
            'time_date_end' => '2025-06-10 13:00:00',
            'description' => 'Únete a nuestro paseo solidario y ayuda a socializar a perros y gatos del albergue.',
            'location' => 'Parque Central, Barcelona',
            'directions' => 'Entrada principal del parque, junto a la fuente central.'
        ]);

        Event::create([
            'name' => 'Campaña de Adopción y Concienciación',
            'creation_date' => '2025-05-18',
            'time_date_start' => '2025-06-15 11:00:00',
            'time_date_end' => '2025-06-15 17:00:00',
            'description' => 'Participa en nuestra campaña para promover la adopción responsable de animales y educar sobre el bienestar animal.',
            'location' => 'Plaza Mayor, Valencia',
            'directions' => 'Carpa informativa frente al ayuntamiento.'
        ]);
        Event::create([
            'name' => 'Recogida de Alimentos para Animales sin Hogar',
            'creation_date' => '2025-05-22',
            'time_date_start' => '2025-06-05 10:00:00',
            'time_date_end' => '2025-06-05 16:00:00',
            'description' => 'Colabora donando pienso, mantas o productos de higiene para perros y gatos sin hogar.',
            'location' => 'Centro Cívico La Solidaridad, Sevilla',
            'directions' => 'Avenida de la Paz 45, junto al Parque de los Príncipes.'
        ]);

        Event::create([
            'name' => 'Voluntariado en Albergue Felino',
            'creation_date' => '2025-05-22',
            'time_date_start' => '2025-06-12 09:30:00',
            'time_date_end' => '2025-06-12 13:30:00',
            'description' => 'Ven a ayudar en el cuidado, limpieza y atención de gatos rescatados. ¡Tu ayuda es fundamental!',
            'location' => 'Albergue Felino Los Bigotes, Zaragoza',
            'directions' => 'Camino de las Flores s/n, acceso por la calle del Campo Verde.'
        ]);

        Event::create([
            'name' => 'Taller Infantil: Cuidando a Nuestros Amigos Peludos',
            'creation_date' => '2025-05-22',
            'time_date_start' => '2025-06-20 17:00:00',
            'time_date_end' => '2025-06-20 19:00:00',
            'description' => 'Actividad educativa para niños sobre el respeto, cuidado y protección de los animales domésticos.',
            'location' => 'Biblioteca Municipal de Málaga',
            'directions' => 'Plaza de la Cultura 2, Sala de Actividades Infantiles.'
        ]);
    }
}
