@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Internal Chat</h4>
                        <button class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#startChatModal">
                            <i class="fa fa-plus"></i> New Chat
                        </button>
                    </div>
                    <div class="card-body p-0 d-flex" style="height: 65vh;">
                        <div class="border-end" style="width: 320px; overflow-y: auto;">
                            <div class="p-3">
                                <input type="text" class="form-control" placeholder="Search contacts...">
                            </div>
                            <ul class="list-group list-group-flush" id="contacts-list">
                                @foreach($contacts as $contact)
                                    <li class="list-group-item contact-item p-3" data-id="{{ $contact->id }}" data-name="{{ $contact->name }}" style="cursor: pointer;">
                                        <div class="fw-bold">{{ $contact->name }}</div>
                                        <small class="text-muted">{{ $contact->role }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="flex-grow-1 d-flex flex-column">
                            <div class="p-3 border-bottom">
                                <h5 id="active-contact-name" class="mb-0">Select a conversation</h5>
                            </div>
                            <div id="chat-messages" class="flex-grow-1 p-3" style="overflow-y: auto; background: #f9f9f9;">
                                </div>
                            <form id="chat-form" class="p-3 border-top d-flex">
                                @csrf
                                <input type="hidden" id="receiver_id" name="receiver_id">
                                <input type="text" name="message" id="message-text" class="form-control me-2" placeholder="Type a message...">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="startChatModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Start New Chat</h5></div>
            <div class="modal-body">
                @foreach($allUsers as $user)
                    @if($user->id !== Auth::id())
                        <div class="directory-user-trigger p-2 border-bottom" data-id="{{ $user->id }}" data-name="{{ $user->name }}" style="cursor: pointer;">
                            {{ $user->name }} - <small>{{ $user->role }}</small>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    $(document).on('click', '.contact-item, .directory-user-trigger', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');

        $('#receiver_id').val(id);
        $('#active-contact-name').text(name);
        $('#startChatModal').modal('hide');
        loadMessages(id);
    });

    function loadMessages(id) {
        $.ajax({
            url: '/chat/messages/' + id,
            type: 'GET',
            success: function(res) {
                $('#chat-messages').empty();
                res.forEach(msg => {
                    let isMe = msg.sender_id == "{{ Auth::id() }}";
                    $('#chat-messages').append(`<div class="mb-2 ${isMe ? 'text-end' : ''}">
                        <span class="p-2 rounded ${isMe ? 'bg-primary text-white' : 'bg-white border'}">${msg.message}</span>
                    </div>`);
                });
            }
        });
    }

    $('#chat-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('chat.store') }}",
            type: 'POST',
            data: $(this).serialize(),
            success: function() {
                $('#message-text').val('');
                loadMessages($('#receiver_id').val());
            }
        });
    });
});
</script>
@endsection
