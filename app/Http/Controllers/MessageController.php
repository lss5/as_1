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

    public function create(Request $request)
    {
        $request->validate([
            'parent_id' => ['filled', 'integer'],
            'type' => ['required', 'string', Rule::in(array_keys(Thread::$types))],
        ]);

        $user = Auth::user();
        $participant = User::getAdmin();
        $type = $request->type;
        $parent_id = false;
        $subject = 'Help request';

        switch ($type) {
            case 'product':
                $product = Product::findOrFail($request->parent_id);
                // if current user is owner
                if ($user->id == $product->user->id ) {
                    return redirect()->route('home.index')->with('warning', '404 | Not Found');
                    break;
                }
                // All threads for Product on Auth user
                // Redirect on exist thread
                $threads = $user->threads()->where('parent_id', '=', $request->parent_id)->where('type', '=', $type)->get();
                foreach ($threads as $thread) {
                    $count_participants_thread = $thread->participants()->where('user_id', '=', $product->user->id)->count();
                    if ($count_participants_thread == 1) {
                        return redirect()->route('home.messages.show', $thread);
                    }
                }

                $participant = $product->user;
                $subject = $product->title;
                $parent_id = $product->id;
                break;

            case 'support':
                if ($request->has('parent_id')) {
                    $product = Product::findOrFail($request->parent_id);
                    $parent_id = $product->id;
                    $subject = $product->title;
                    // if current user is owner
                    if ($user->id == $product->user->id) {
                    }
                    // All threads for Product on Auth user
                    // Redirect on exist thread
                    $threads = $user->threads()->where('parent_id', '=', $request->parent_id)->where('type', '=', $type)->get();
                } else {
                    $threads = $user->threads()->whereNull('parent_id')->where('type', '=', $type)->get();
                }

                foreach ($threads as $thread) {
                    $count_participants_thread = $thread->participants()->where('user_id', '=', $participant->id)->count();
                    if ($count_participants_thread == 1) {
                        return redirect()->route('home.messages.show', $thread);
                    }
                }
                break;

            default:
                return redirect()->route('home.index')->with('warning', '404 | Not Found');
                break;
        }

        return view('message.create')->with([
            'parent_id' => $parent_id,
            'type' => $type,
            'subject' => $subject,
            'participant' => $participant,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string'],
            'type' => ['required', 'string', Rule::in(array_keys(Thread::$types))],
            'parent_id' => ['filled', 'integer'],
        ]);

        $participants = [];
        $admin = User::getAdmin();
        $subject = 'Help request';
        $parent_id = false;

        switch ($request->type) {
            case 'product':
                $product = Product::findOrFail($request->parent_id);
                $parent_id = $product->id;
                $subject = $product->title;
                $participants[] = $product->user->id;
                break;

            case 'support':
                $participants[] = $admin->id;
                if ($request->has('parent_id')) {
                    $product = Product::findOrFail($request->parent_id);
                    $parent_id = $product->id;
                    $subject = $product->title;
                }
                break;

            default:
                return redirect()->route('home.index')->with('warning', '404 | Not Found');
                break;
        }

        if ($parent_id) {
            $thread = Thread::create([
                'subject' => $subject,
                'parent_id' => $parent_id,
                'type' => $request->type,
            ]);
        } else {
            $thread = Thread::create([
                'subject' => $subject,
                'type' => $request->type,
            ]);
        }

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
        $thread->addParticipant($participants);

        return redirect()->route('home.messages.index')->with('success', 'Message sended');
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
