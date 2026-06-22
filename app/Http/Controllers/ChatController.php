<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $contacts = collect();

        if ($user->isStudent()) {
            if ($user->teacher) $contacts->push($user->teacher);
            if ($user->supervisor) $contacts->push($user->supervisor);
        } 
        elseif ($user->isCoordinator()) {
            $contacts = $user->coordinatedStudents;
        } 
        elseif ($user->isSupervisor()) {
            $contacts = $user->supervisedStudents;
        }

        return view('chat.index', compact('contacts'));
    }

    public function show(User $contact)
    {
        /** @var User $user */
        $user = Auth::user();

        $messages = Message::where(function($query) use ($user, $contact) {
            $query->where('sender_id', $user->id)->where('receiver_id', $contact->id);
        })->orWhere(function($query) use ($user, $contact) {
            $query->where('sender_id', $contact->id)->where('receiver_id', $user->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        Message::where('sender_id', $contact->id)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:10240' // Max 10MB ang file
        ]);

        // Siguraduhing may text message o kaya ay may file na ipapadala
        if (!$request->message && !$request->hasFile('file')) {
            return response()->json(['success' => false, 'error' => 'Cannot send an empty message.'], 422);
        }

        $filePath = null;
        $fileType = null;
        $messageText = $request->message;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Kunin ang orihinal na pangalan ng file bago i-upload
            $originalName = $file->getClientOriginalName();
            
            // I-save ang file gamit ang random string para sa security at iwas overwrite
            $filePath = $file->store('chat_files', 'public');
            $fileType = $file->getClientOriginalExtension();

            // Kung walang tinapeng text message ang user, gawing text message ang mismong pangalan ng file
            if (empty($messageText)) {
                $messageText = $originalName;
            }
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $messageText ?? '',
            'file_path' => $filePath,
            'file_type' => $fileType,
            'is_read' => false
        ]);

        return response()->json(['success' => true, 'message' => $message]);
    }
}