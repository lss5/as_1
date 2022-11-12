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
        $thread = Thread::findOrFail($id);
        if (Auth::user()->can('view', $thread)) {
            $thread->markAsRead(Auth::id());
            return view('message.show', compact('thread'));
        }

        return redirect()->route('home.messages.index')->with('warning', 'The thread with ID: ' . $id . ' was not found.');
    }

    public function create(Request $request)
    {
        $request->validate([
            'parent_id' => ['filled', 'integer'],
            'type' => ['required', 'string', Rule::in(array_keys(Thread::$types))],
        ]);

        $participants = [];
        $user = Auth::user();
        $participant = User::getFirstAdmin();
        $type = $request->has('type') ? $request->type : false;
        $parent_id = $request->has('parent_id') ? $request->parent_id : false;

        switch ($type) {
            case 'product':
                $exist_thread_id = $user->getDialog(false, $parent_id, $type);
                if ($exist_thread_id) {
                    return redirect()->route('home.messages.show', $exist_thread_id);
                }

                $product = Product::findOrFail($parent_id);
                // if current user is owner
                if ($user->id == $product->user->id ) {
                    return redirect()->route('home.index')->with('warning', '404 | Not Found');
                    break;
                }
                $participant = $product->user;
                break;

            case 'support':
                if ($parent_id) {
                    $exist_thread_id = $user->getDialog(false, $parent_id, $type);
                    if ($exist_thread_id) {
                        return redirect()->route('home.messages.show', $exist_thread_id);
                    }
                } else {
                    $exist_thread_id = $user->getDialog($participant->id, false, $type);
                    if ($exist_thread_id) {
                        return redirect()->route('home.messages.show', $exist_thread_id);
                    }
                }
                break;

            case 'person':
                if ($parent_id) {
                    $exist_thread_id = $user->getDialog($parent_id, false, $type);
                    if ($exist_thread_id) {
                        return redirect()->route('home.messages.show', $exist_thread_id);
                    }
                    $participant = User::findOrFail($parent_id);
                    $parent_id = $participant->id;
                }
                break;

            case 'plaint':
                if ($parent_id) {
                    $exist_thread_id = $user->getDialog(false, $parent_id, $type);
                    if ($exist_thread_id) {
                        return redirect()->route('home.messages.show', $exist_thread_id);
                    }
                }
                break;
            default:
                return redirect()->route('home.index')->with('warning', '404 | Not Found');
                break;
        }

        $participants[] = $participant;
        return view('message.create')->with([
            'parent_id' => $parent_id,
            'type' => $type,
            'participants' => $participants,
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
        $user = Auth::user();
        $admin = User::getFirstAdmin();
        $type = $request->has('type') ? $request->type : false;
        $parent_id = $request->has('parent_id') ? $request->parent_id : false;

        switch ($type) {
            case 'product':
                if ($parent_id) {
                    $product = Product::findOrFail($parent_id);
                    $parent_id = $product->id;
                    $subject = $product->title;
                    $participants[] = $product->user->id;
                } else {
                    return redirect()->route('home.index')->with('warning', '404 | Not Found');
                }
                break;

            case 'support':
                $participants[] = $admin->id;
                $subject = 'Help request';
                if ($parent_id) {
                    $product = Product::findOrFail($parent_id);
                    $subject = $product->title;
                }
                break;

            case 'person':
                $person = User::findOrFail($parent_id);
                $participants[] = $person->id;
                $subject = 'Person';
                break;

            case 'plaint':
                $participants[] = $admin->id;
                if ($parent_id) {
                    $product = Product::findOrFail($parent_id);
                    $subject = $product->title;
                    $participants[] = $product->user->id;
                } else {
                    return redirect()->route('home.index')->with('warning', '404 | Not Found');
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
            // For type "Person"
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
            $participant->last_read = new Carbon();
            $participant->save();

            // Recipients
            // if (Request::has('recipients')) {
            //     $thread->addParticipant(Request::input('recipients'));
            // }

            return redirect()->route('home.messages.show', $id);
        }
        return redirect()->route('home.messages.index')->with('warning', 'The thread with ID: ' . $id . ' was not found.');

    }

    public function destroy(Request $request, $id)
    {
        $thread = Thread::findOrFail($id);
        $thread->removeParticipant(Auth::id());
        return redirect()->route('home.messages.index')->with('success', 'The thread "' . $thread->subject . '" archived.');
    }
}
