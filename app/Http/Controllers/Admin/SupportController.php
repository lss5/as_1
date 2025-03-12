<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public static $type = 'support';

    public function index()
    {
        $threads = Thread::where('type', '=', $this::$type)->latest('updated_at')->get();

        return view('admin.support.index', ['threads' => $threads]);
    }

    public function show(Request $request, Thread $thread)
    {
        $thread->markAsRead(Auth::id());

        return view('admin.support.show', ['thread' => $thread]);
    }

    public function create(Request $request)
    {
        return view('admin.support.create', [
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:30000'],
            'user' => ['required', 'integer', 'exists:users,id'],
        ]);

        $thread = Thread::create([
            'subject' => $request->input('subject'),
            'type' => $this::$type,
        ]);

        $thread->addParticipant($request->input('user'));

        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $request->input('message'),
        ]);

        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'last_read' => new Carbon(),
        ]);

        return redirect()->route('admin.support.index')->with('success', 'Help request is sended');
    }

    public function update(Request $request, Thread $thread)
    {
        $request->validate([
            'message' => ['required', 'string'],
        ]);

        $thread->activateAllParticipants();

        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $request->message,
        ]);

        // Add replier as a participant
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
        ]);

        $participant->fill([
            'last_read' => new Carbon(),
        ])->save();

        return redirect()->route('admin.support.show', $thread);
    }

    public function destroy($id)
    {
        //
    }
}
