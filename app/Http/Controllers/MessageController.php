<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;

use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use App\Thread;

class MessageController extends Controller
{
    public function index()
    {
        // All threads, ignore deleted/archived participants
        // $threads = Thread::getAllLatest()->get();

        // All threads that user is participating in
        $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();

        // All threads that user is participating in, with new messages
        // $threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();
        // dd($threads);
        return view('message.index')->with([
            'threads' => $threads,
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'parent_id' => ['filled', 'integer'],
            'type' => ['required', 'string', Rule::in(array_keys(Thread::$types))],
        ]);

        $user = Auth::user();
        switch ($request->type) {
            case 'product':
                $product = Product::findOrFail($request->parent_id);
                if ($user->id == $product->user->id ) {
                    $type = 'support';
                }
                // All threads for Product on Auth user
                $threads = $user->threads()->where('parent_id', '=', $request->parent_id)->where('type', '=', $request->type)->get();
                foreach ($threads as $thread) {
                    $count_participants_thread = $thread->participants()->where('user_id', '=', $product->user->id)->count();
                    if ($count_participants_thread == 1) {
                        return redirect()->route('home.messages.show', $thread);
                    }
                }
                break;

            case 'support':
                if ($request->has('parent_id')) {
                    $product = Product::findOrFail($request->parent_id);
                    $subject = $product->title;
                }  else {
                    $subject = 'Support help';
                }
            default:
                return redirect()->route('home.index')->with('warning', '404 | Not Found');
                break;
        }
        $parent_id = $product->id;
        $subject = $product->title;
        $type = $request->type;

        return view('message.create')->with([
            'parent_id' => $parent_id,
            'type' => $type,
            'subject' => $subject,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string'],
            'type' => ['required', 'string', Rule::in(array_keys(Thread::$types))],
            'parent_id' => ['filled', 'integer'],
        ]);

        switch ($request->type) {
            case 'product':
                $parent = Product::findOrFail($request->parent_id);
                $subject = $parent->title;
                break;

            case 'support':
                if ($request->has('parent_id')) {
                    $parent = Product::findOrFail($request->parent_id);
                    $subject = $parent->title;
                }  else {
                    $subject = 'Support help';
                }
            default:
                return redirect()->route('home.index')->with('warning', '404 | Not Found');
                break;
        }

        $subject = $subject;

        $thread = Thread::create([
            'subject' => $subject,
            'parent_id' => $parent->id,
            'type' => $request->type,
        ]);

        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $request->message,
        ]);

        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'last_read' => new Carbon(),
        ]);

        // Recipients
        $thread->addParticipant([$parent->user->id]);

        return redirect()->route('home.messages.index')->with('success', 'Message sended');
    }

    public function show(Request $request, $id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('home.messages.index')->with('warning', 'The thread with ID: ' . $id . ' was not found.');
        }

        $thread->markAsRead(Auth::id());

        return view('message.show', compact('thread'));
    }

    public function edit(Message $message)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'message' => ['required', 'string', 'min:5'],
        ]);

        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('home.messages.index')->with('warning', 'The thread with ID: ' . $id . ' was not found.');
        }

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
        $participant->last_read = new Carbon();
        $participant->save();

        // Recipients
        // if (Request::has('recipients')) {
        //     $thread->addParticipant(Request::input('recipients'));
        // }

        return redirect()->route('home.messages.show', $id);
    }

    public function destroy(Message $message)
    {
        //
    }
}
