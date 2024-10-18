<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Listing;
use App\Message;
use App\Thread;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::forUser(Auth::id())->whereNull('type')->orWhere('type', '!=', SupportController::$type)->latest('updated_at')->get();

        return view('profile.message.index')->with([
            'threads' => $threads,
        ]);
    }

    public function create(Request $request, Listing $listing)
    {
        $thread = Thread::Between([$listing->user->id, Auth::user()->id])->where('parent_id', $listing->id)->first();

        if ($thread) {
            return redirect()->route('profile.messages.show', $thread);
        }
        
        $thread = Thread::create([
            'subject' => $listing->product->manufacturer->name . ' ' . $listing->product->model,
            'parent_id' => $listing->id,
        ]);
        
        return redirect()->route('profile.messages.show', $thread);
    }

    public function show(Thread $thread)
    {
        $thread->markAsRead(Auth::id());

        return view('profile.message.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
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
            'body' => $request->input('message'),
        ]);

        // Add replier as a participant and mark as Read
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
        ]);

        $participant->last_read = new Carbon();
        $participant->save();

        $thread->addParticipant($thread->listing->user->id);

        return redirect()->route('profile.messages.show', $thread);
    }

    public function destroy(Thread $thread)
    {
        $thread->removeParticipant(Auth::id());
        return redirect()->route('profile.messages.index')->with('success', 'The thread "' . $thread->subject . '" archived.');
    }
}
