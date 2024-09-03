<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use App\Http\Controllers\Controller;
use App\Thread;
use App\User;

class SupportController extends Controller
{
    public static $type = 'support';

    public function index()
    {
        $threads = Thread::where('type', '=', $this::$type)->latest('updated_at')->get();

        return view('admin.support.index')->with(['threads' => $threads]);
    }

    public function show(Request $request, $id)
    {
        $thread = Thread::findOrFail($id);
        if (Auth::user()->can('view', $thread)) {
            $thread->markAsRead(Auth::id());
            return view('profile.messages.support.show', compact('thread'));
        }

        return redirect()->route('profile.support.index')->with('warning', 'The thread with ID: ' . $id . ' was not found.');
    }

    public function create(Request $request)
    {
        return view('profile.messages.support.create');
    }

    public function store(Request $request, User $participant)
    {
        $request->validate([
            'message' => ['required', 'string'],
            'subject' => ['required', 'string'],
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

        return redirect()->route('profile.support.index')->with('success', 'Help request is sended');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'message' => ['required', 'string'],
        ]);

        $thread = Thread::findOrFail($id);
        if (Auth::user()->can('update', $thread)) {

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

            return redirect()->route('profile.support.show', $id);
        }
        return redirect()->route('profile.support.index')->with('warning', 'The thread with ID: ' . $id . ' was not found.');

    }

    public function destroy($id)
    {
        //
    }
}
