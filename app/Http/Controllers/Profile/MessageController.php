<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cmgmyr\Messenger\Models\Participant;
use App\User;
use App\Product;
use App\Thread;
use App\Message;

class MessageController extends Controller
{
    public function index()
    {
        // All threads, ignore deleted/archived participants
        // $threads = Thread::getAllLatest()->get();

        // All threads that user is participating in
        $threads = Thread::forUser(Auth::id())->whereNull('type')->orWhere('type', '!=', SupportController::$type)->latest('updated_at')->get();

        // All threads that user is participating in, with new messages
        // $threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();

        return view('profile.messages.index')->with([
            'threads' => $threads,
        ]);
    }

    public function show(Request $request, Thread $thread)
    {
        if (Auth::user()->can('view', $thread)) {
            $thread->markAsRead(Auth::id());
            return view('profile.messages.show', compact('thread'));
        }

        return redirect()->route('profile.message.index')->with('warning', 'The thread with ID: ' . $thread->id . ' was not found.');
    }

    public function create(Request $request, User $participant)
    {
        $request->validate([
            'parent_id' => ['filled', 'integer'],
        ]);

        $parent_id = $request->has('parent_id') ? $request->input('parent_id') : null;

        if ($parent_id) {
            $product = Product::findOrFail($parent_id);
            if ($product->user->id != $participant->id) {
                return redirect()->route('profile.index')->with('warning', '404 | Not Found');
            }
            $thread = Thread::Between([$participant->id, Auth::user()->id])->where('parent_id', '=', $product->id)->get();
        } else {
            $thread = Thread::Between([$participant->id, Auth::user()->id])->whereNull('parent_id')->get();
        }

        if ($thread->count() > 0) {
            return redirect()->route('profile.message.show', $thread->first());
        }

        return view('profile.messages.create')->with([
            'participant' => $participant,
            'parent_id' => $parent_id,
            'subject' => isset($product) ? $product->title : '',
        ]);
    }

    public function store(Request $request, User $participant)
    {
        $request->validate([
            'message' => ['required', 'string'],
            'subject' => ['required', 'string'],
            'parent_id' => ['filled', 'integer'],
        ]);

        $parent_id = $request->has('parent_id') ? $request->parent_id : null;
        if ($parent_id) {
            $product = Product::findOrFail($parent_id);
            if ($product->user->id != $participant->id) {
                return redirect()->route('profile.index')->with('warning', '404 | Not Found');
            }
        }

        $thread = Thread::create([
            'subject' => $request->input('subject'),
            'parent_id' => $parent_id,
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

        // Recipients
        $thread->addParticipant($participant->id);

        return redirect()->route('profile.message.index')->with('success', 'Message sended');
    }

    public function update(Request $request, Thread $thread)
    {
        $request->validate([
            'message' => ['required', 'string'],
        ]);

        if (Auth::user()->can('update', $thread)) {

            $thread->activateAllParticipants();

            // Message
            Message::create([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                'body' => $request->input('message'),
            ]);

            // Add replier as a participant and mark as Read
            $participant = Participant::firstOrCreate([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
            ]);
            $participant->last_read = new Carbon();
            $participant->save();

            // Recipients
            // if (Request::has('recipients')) {
            //     $thread->addParticipant(Request::input('recipients'));
            // }

            return redirect()->route('profile.message.show', $thread);
        }
        return redirect()->route('profile.message.index')->with('warning', 'The thread with ID: ' . $thread->id . ' was not found.');

    }

    public function destroy(Request $request, Thread $thread)
    {
        $thread->removeParticipant(Auth::id());
        return redirect()->route('profile.message.index')->with('success', 'The thread "' . $thread->subject . '" archived.');
    }
}
