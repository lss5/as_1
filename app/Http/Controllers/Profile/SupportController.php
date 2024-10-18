<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Cmgmyr\Messenger\Models\Participant;
use App\Thread;
use App\User;
use App\Message;

class SupportController extends Controller
{
    public static $type = 'support';

    public function index()
    {
        $threads = Thread::forUser(Auth::id())->where('type', $this::$type)->latest('updated_at')->get();

        return view('profile.support.index', ['threads' => $threads]);
    }

    public function show(Request $request, Thread $thread)
    {
        $thread->markAsRead(Auth::id());

        return view('profile.support.show', ['thread' => $thread]);
    }

    public function create(Request $request)
    {
        return view('profile.support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:30000'],
        ]);

        $thread = Thread::create([
            'subject' => $request->input('subject'),
            'type' => $this::$type,
        ]);

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

        return redirect()->route('profile.supports.index')->with('success', 'Help request is created');
    }

    public function update(Request $request, Thread $thread)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:30000'],
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

        return redirect()->route('profile.supports.show', $thread);
    }

    public function destroy(Thread $thread)
    {
        //
    }
}
