@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app" style="height: 75vh; display: flex; flex-direction: row; overflow: hidden;">
                
                {{-- Left Side: Contacts List --}}
                <div id="plist" class="people-list" style="width: 280px; border-right: 1px solid #eaeaea; display: flex; flex-direction: column; background: #fff; flex-shrink: 0;">
                    <div class="p-3 border-bottom">
                        <h5 class="mb-0 fw-bold">Contacts</h5>
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0" style="overflow-y: auto; flex-grow: 1;">
                        @forelse($contacts as $contact)
                            <li class="clearfix p-3 contact-item" data-id="{{ $contact->id }}" style="cursor: pointer; display: flex; align-items: center; border-bottom: 1px solid #f4f7f6;">
                                <div class="avatar-sm me-3" style="width: 40px; height: 40px; border-radius: 50%; background: #6861ce; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">
                                    {{ strtoupper(substr($contact->name, 0, 2)) }}
                                </div>
                                <div class="about" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 100%;">
                                    <div class="name fw-bold text-dark" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $contact->name }}</div>
                                    <div class="status text-muted text-capitalize" style="font-size: 12px;">
                                        <i class="fa fa-circle text-success" style="font-size: 9px;"></i> {{ $contact->role }}
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="p-3 text-muted text-center">No contacts assigned yet.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Right Side: Chat Box Area --}}
                <div class="chat" style="flex-grow: 1; display: flex; flex-direction: column; background: #fcfcfe; overflow: hidden;">
                    
                    {{-- Chat Header --}}
                    <div class="chat-header clearfix p-3 border-bottom bg-white" style="display: flex; align-items: center; width: 100%;">
                        <div class="chat-about">
                            <h6 class="m-b-0 fw-bold text-dark" id="active-contact-name">Select a contact to start messaging</h6>
                        </div>
                    </div>

                    {{-- Messages History Box --}}
                    <div class="chat-history p-4" id="chat-box" style="flex-grow: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 15px;">
                        <div class="text-center text-muted my-auto">
                            <i class="fas fa-comments fa-3x mb-3 text-light"></i>
                            <p>Choose a contact from the left menu to view the conversation history.</p>
                        </div>
                    </div>

                    {{-- Input Message Box with File Upload Support --}}
                    <div class="chat-message clearfix p-3 border-top bg-white" id="message-input-area" style="display: none;">
                        <form id="chat-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="receiver_id" name="receiver_id">
                            
                            {{-- File Indicator Alert Box --}}
                            <div id="file-preview-container" class="alert alert-secondary p-2 mb-2" style="display: none; font-size: 13px;">
                                <i class="fas fa-paperclip me-2"></i> Selected File: <strong id="file-name-preview"></strong>
                                <button type="button" class="btn-close float-end" id="cancel-file" style="font-size: 10px; border: none; background: transparent;">✕</button>
                            </div>

                            <div class="input-group">
                                {{-- Hidden file input element --}}
                                <input type="file" id="file-input" name="file" style="display: none;">
                                <button type="button" class="btn btn-outline-secondary" id="upload-trigger-btn" title="Attach Document / Task">
                                    <i class="fa fa-paperclip"></i>
                                </button>
                                
                                <input type="text" id="message-text" name="message" class="form-control" placeholder="Type a message or describe the task here..." autocomplete="off">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-paper-plane"></i> Send
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let currentContactId = null;

        // Pag-trigger sa file selection dialog
        $('#upload-trigger-btn').on('click', function() {
            $('#file-input').click();
        });

        // Kapag may napiling file, ipakita ang indicator preview
        $('#file-input').on('change', function() {
            if (this.files && this.files[0]) {
                $('#file-name-preview').text(this.files[0].name);
                $('#file-preview-container').show();
            }
        });

        // Pag-bura sa napiling file bago i-send
        $('#cancel-file').on('click', function() {
            $('#file-input').val('');
            $('#file-preview-container').hide();
        });

        // Pag-click sa isang contact
        $('.contact-item').on('click', function() {
            $('.contact-item').removeClass('bg-light');
            $(this).addClass('bg-light');

            currentContactId = $(this).data('id');
            let contactName = $(this).find('.name').text();

            $('#active-contact-name').text(contactName);
            $('#receiver_id').val(currentContactId);
            $('#message-input-area').show();

            loadMessages(currentContactId);
        });

        // Function para i-load ang messages at kasamang files
        function loadMessages(contactId) {
            if(!contactId) return;

            $.ajax({
                url: `/chat/messages/${contactId}`,
                type: 'GET',
                success: function(messages) {
                    let chatBox = $('#chat-box');
                    chatBox.empty();

                    if(messages.length === 0) {
                        chatBox.html('<div class="text-center text-muted my-auto">No messages yet. Send a wave!</div>');
                    } else {
                        messages.forEach(function(msg) {
                            let isMe = msg.sender_id == "{{ Auth::id() }}";
                            let alignClass = isMe ? 'align-self-end bg-primary text-white' : 'align-self-start bg-white border text-dark';
                            let marginStyle = isMe ? 'margin-left: auto;' : 'margin-right: auto;';
                            
                            // Check kung may nakalakip na file sa chat log record
                            let fileHtml = '';
                            if (msg.file_path) {
                                let linkColor = isMe ? 'text-warning fw-bold' : 'text-primary fw-bold';
                                fileHtml = `
                                    <div class="mt-2 p-2 border rounded bg-light text-dark d-flex align-items-center" style="font-size: 13px; min-width: 200px;">
                                        <i class="fas fa-file-download fa-2x me-2 text-danger"></i>
                                        <div>
                                            <span class="d-block text-truncate" style="max-width: 180px; font-weight: bold;">Attached File (.${msg.file_type})</span>
                                            <a href="/storage/${msg.file_path}" target="_blank" class="${linkColor} text-decoration-none" download="${msg.message}">
                                                <i class="fa fa-download"></i> Download File
                                            </a>
                                        </div>
                                    </div>
                                `;
                            }

                            // I-render lamang ang chat container
                            let textHtml = msg.message && msg.message !== msg.file_path ? `<div>${msg.message}</div>` : '';

                            chatBox.append(`
                                <div class="p-3 rounded-3 d-flex flex-column" style="max-width: 70%; ${marginStyle} ${alignClass}">
                                    ${textHtml}
                                    ${fileHtml}
                                    <small style="font-size: 10px; opacity: 0.8; text-align: right; margin-top: 5px; display: block; width: 100%;">
                                        ${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                    </small>
                                </div>
                            `);
                        });
                    }
                    chatBox.scrollTop(chatBox[0].scrollHeight);
                }
            });
        }

        // Pag-send gamit ang FormData para maipasa ang Multipart File data sa AJAX
        $('#chat-form').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('chat.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#message-text').val('');
                    $('#file-input').val('');
                    $('#file-preview-container').hide();
                    loadMessages(currentContactId);
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.error || 'Something went wrong. Please check file size.');
                }
            });
        });

        // Auto refresh setup
        setInterval(function() {
            if(currentContactId) {
                loadMessages(currentContactId);
            }
        }, 3000);
    });
</script>
@endsection