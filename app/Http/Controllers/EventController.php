<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Participation;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function getAll()
    {
        //cogemos todos los eventos de la bd
        $events = Event::all();
        //retornsmos un json con todos los eventos
        return response()->json($events);
    }
    
    public function getById($id)
    {
        error_log("SE RECIBE LA PETICION");
        $event = Event::find($id);
        if ($event) {
            return response()->json($event);
        } else {
            return response()->json(['message' => 'Event not found'], 404);
        }
    }
    public function join(Request $request, $event_id)
    {
        $token = $request->header("Authorization");


        //Busca en la tabla personal_access_token el primer registro donde la columna token sea igual al valor $token
        $tokenData = PersonalAccessToken::findToken($token);

        $userId = $tokenData->tokenable_id;

        // error_log('User ID: ' . $userId);

        // error_log('tokenData: ' . print_r($tokenData, true));

        $participacionExistente = Participation::where([
            'id_user' => $userId,
            'id_event' => $event_id
        ])->first();

        if ($participacionExistente) {
            return response()->json(['message' => 'Ya estas apuntado previamente'], 409);
        }

        // Crear participación 
        $participation = Participation::create([
            'id_user' => $userId,
            'id_event' => $event_id
        ]);

        return response()->json([
            'message' => 'Usuario apuntado correctamente',
        ], 201);
    }

    public function leave(Request $request, $event_id)
    {
        $token = $request->header("Authorization");


        //Busca en la tabla personal_access_token el primer registro donde la columna token sea igual al valor $token
        $tokenData = PersonalAccessToken::findToken($token);

        $userId = $tokenData->tokenable_id;

        $participacionExistente = Participation::where([
            'id_user' => $userId,
            'id_event' => $event_id
        ])->first();

        if (!$participacionExistente) {
            return response()->json(['message' => 'Aún no estás apuntado'], 404);
        }

        // Eliminar participación 
        $participacionExistente->delete();

        return response()->json([
            'message' => 'Participación eliminada correctamente',
        ], 201);
    }

    public function getMyEvents(Request $request)
    {
        $token = $request->header("Authorization");
        // Busca en la tabla personal_access_token el primer registro donde la columna token sea igual al valor $token
        $tokenData = PersonalAccessToken::findToken($token);

        if (!$tokenData) {
            return response()->json(['message' => 'Token inválido'], 401);
        }

        $userId = $tokenData->tokenable_id;

        // Hacemos un join entre Participation y Event para obtener los eventos en los que participa el usuario
        $events = Event::join('participations', 'events.id', '=', 'participations.id_event')
            //filtramos para obtener solo mis eventos por mi $userId
            ->where('participations.id_user', $userId)
            //Selecciona todos los campos
            ->select('events.*')
            ->get();

        return response()->json($events);
    }
    public function createEvent(Request $request)
    {
        $token = $request->header("Authorization");
        //Busca en la tabla personal_access_token el primer registro donde la columna token sea igual al valor $token
        $tokenData = PersonalAccessToken::findToken($token);
        $userId = $tokenData->tokenable_id;

        // Validando los datos del form crear evento
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'creation_date' => 'required|date',
            'time_date_start' => 'required|date',
            'time_date_end' => 'required|date',
            'description' => 'required|string|max:200',
            'location' => 'required|string',
            'directions' => 'required|string'

        ]);
        //si en la validación hay un error devolveremos el error 422
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        // Crear evento      

        $event = Event::create([
            'name' => $request->name,
            'creation_date' => $request->creation_date,
            'time_date_start' => $request->time_date_start,
            'time_date_end' => $request->time_date_end,
            'description' => $request->description,
            'location' => $request->location,
            'directions' => $request->direction


        ]);

        $event_id = $event->id;
        //guardamos en la tabla participation que organización ha hecho el evento
        $particiation = Participation::create([
            'id_user' => $userId,
            'id_event' => $event_id
        ]);

        // Retornar respuesta evento creado
        return response()->json([
            'message' => 'Evento creado correctamente',
            'evento' => $event,
        ], 201);
    }

    public function delete(Request $request, $event_id)
    {
        $token = $request->header("Authorization");
        //Busca en la tabla personal_access_token el primer registro donde la columna token sea igual al valor $token
        $tokenData = PersonalAccessToken::findToken($token);
        $userId = $tokenData->tokenable_id;

        // Buscar la participación del usuario en el evento

        $participation = Participation::where([
            'id_user' => $userId,
            'id_event' => $event_id
        ])->first();

        if (!$participation) {
            return response()->json([
                'message' => 'Este evento no existe o no ha sido creado por ti'
            ], 404);
        } else {
            // Eliminar todas las participaciones relacionadas con el evento
            Participation::where('id_event', $event_id)->delete();

            // Eliminar el evento
            Event::where('id', $event_id)->delete();

            return response()->json([
                'message' => 'Evento eliminado correctamente'
            ], 200);
        }
    }
    public function editEvent(Request $request, $event_id)
    {
        $token = $request->header("Authorization");
        //Busca en la tabla personal_access_token el primer registro donde la columna token sea igual al valor $token
        $tokenData = PersonalAccessToken::findToken($token);
        $userId = $tokenData->tokenable_id;

        // Validando los datos del form editar evento
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'creation_date' => 'required|date',
            'time_date_start' => 'required|date',
            'time_date_end' => 'required|date',
            'description' => 'required|string|max:200',
            'location' => 'required|string',
            'directions' => 'nullable|string'

        ]);
        //si en la validación hay un error devolveremos el error 422
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }    

        $participation = Participation::where('id_user', $userId)
            ->where('id_event', $event_id)
            ->first();

        if (!$participation) {
            return response()->json([
                'message' => 'No tienes permisos para editar este evento o no existe'
            ], 403);
        }

        $event = Event::where('id', $event_id)->first();

        $event->update([
            'name' => $request->name,
            'time_date_start' => $request->time_date_start,
            'time_date_end' => $request->time_date_end,
            'description' => $request->description,
            'location' => $request->location,
            'directions' => $request->directions,
        ]);

        return response()->json([
            'message' => 'Evento actualizado correctamente',
            'evento' => $event,
        ], 200);
    }
    public function getParticipantsByEvent(Request $request, $event_id)
    {
        $token = $request->header("Authorization");
        //Busca en la tabla personal_access_token el primer registro donde la columna token sea igual al valor $token
        $tokenData = PersonalAccessToken::findToken($token);
        $userId = $tokenData->tokenable_id;

        $participants = Participation::join('users', 'users.id', '=', 'participations.id_user')
            //filtramos para obtener todos los participantes de un evento
            ->where('participations.id_event', $event_id)
            ->where('users.userTypeId', 1)
            //Selecciona todos los campos
            ->select('users.id','users.name', 'users.email')
            ->get();

        return response()->json([
            'participants' => $participants,
        ], 200);
        
    }
}
