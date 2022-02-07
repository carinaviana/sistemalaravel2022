<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;//acesso ao model Event.php


class EventController extends Controller
{
    public function index() {

        $events = Event::all();//o all chama todos os eventos do banco

        return view('welcome',['events' => $events]);//enviando para view

    }

    public function create() {
        return view('events.create');
    }

    public function store(Request $request) {

        $event = new Event;

        $event->title = $request->title;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;

        // Image Upload
        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;//varíavel que pega do request

            $extension = $requestImage->extension();//criar a extensão com nome

            //nome concatenado com o hora de agora + a extensão do arquivo
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/events'), $imageName);

            $event->image = $imageName;

        }

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');

    }
}
