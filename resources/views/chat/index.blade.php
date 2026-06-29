@extends('layouts.app')

@section('title', 'Messages | InternLink')

@section('content')

<div class="page-header">
    <h3 class="fw-bold mb-1">Messages</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ url('/dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Messages</a></li>
    </ul>
</div>

<div class="chat-wrapper" style="display:flex;height:calc(100vh - 220px);min-height:500px;background:#fff;border-radius:14px;border:1px solid #eaebf0;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden;">

    {{-- ── Contacts sidebar ── --}}
    <div style="width:280px;flex-shrink:0;border-right:1px solid #f0f0f5;display:flex;flex-direction:column;background:#fff;">
        <div style="padding:16px 20px;border-bottom:1px solid #f0f0f5;">
            <h6 class="fw-bold mb-0" style="font-size:14px;color:#1a1a2e;">Contacts</h6>
            <div style="font-size:11px;color:#aaa;margin-top:2px;">{{ count($contacts) }} assigned</div>
        </div>
        <ul class="list-unstyled mb-0" style="overflow-y:auto;flex-grow:1;">
            @forelse($contacts as $contact)
                <li class="contact-item px-4 py-3"
                    data-id="{{ $contact->id }}"
                    style="cursor:pointer;display:flex;align-items:center;gap:12px;border-bottom:1px solid #f8f8fb;transition:background .15s;">
                    <div style="width:38px;height:38px;border-radius:50%;background:#5867dd;color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($contact->name, 0, 2)) }}
                    </div>
                    <div style="overflow:hidden;">
                        <div class="fw-semibold" style="font-size:13px;color:#1a1a2e;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $contact->name }}</div>
                        <div style="font-size:11px;color:#aaa;text-transform:capitalize;">
                            <i class="fa fa-circle text-success" style="font-size:7px;"></i> {{ $contact->role }}
                        </div>
                    </div>
                </li>
            @empty
                <li class="p-4 text-center" style="font-size:13px;color:#aaa;">No contacts assigned yet.</li>
            @endforelse
        </ul>
    </div>

    {{-- ── Chat area ── --}}
    <div style="flex-grow:1;display:flex;flex-direction:column;background:#fafbfc;overflow:hidden;">

        {{-- Header --}}
        <div id="chat-header" style="padding:14px 20px;border-bottom:1px solid #f0f0f5;background:#fff;display:flex;align-items:center;gap:12px;">
            <div id="chat-header-avatar" style="display:none;width:36px;height:36px;border-radius:50%;background:#5867dd;color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;"></div>
            <div>
                <div id="active-contact-name" style="font-size:14px;font-weight:600;color:#1a1a2e;">Select a contact to start messaging</div>
                <div id="active-contact-role" style="font-size:11px;color:#aaa;display:none;"></div>
            </div>
        </div>

        {{-- Messages --}}
        <div id="chat-box" style="flex-grow:1;overflow-y:auto;padding:20px;display:flex;flex-direction:column;gap:12px;">
            <div id="chat-placeholder" class="text-center my-auto" style="color:#ccc;">
                <i class="fas fa-comments fa-3x mb-3 d-block"></i>
                <p style="font-size:13px;">Choose a contact from the left to view conversation history.</p>
            </div>
        </div>

        {{-- Input --}}
        <div id="message-input-area" style="display:none;padding:14px 20px;border-top:1px solid #f0f0f5;background:#fff;">
            <form id="chat-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="receiver_id" name="receiver_id">

                <div id="file-preview-container" style="display:none;background:#f4f5f7;border-radius:8px;padding:8px 12px;margin-bottom:10px;font-size:12px;color:#555;align-items:center;gap:8px;">
                    <i class="fas fa-paperclip" style="color:#5867dd;"></i>
                    <span id="file-name-preview" style="flex-grow:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"></span>
                    <button type="button" id="cancel-file" style="border:none;background:none;color:#aaa;cursor:pointer;font-size:14px;">✕</button>
                </div>

                <div class="d-flex gap-2 align-items-center">
                    <input type="file" id="file-input" name="file" style="display:none;">
                    <button type="button" id="upload-trigger-btn"
                            style="width:38px;height:38px;border-radius:50%;border:1px solid #e0e0ea;background:#fff;color:#aaa;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:border-color .15s;">
                        <i class="fa fa-paperclip"></i>
                    </button>
                    <input type="text" id="message-text" name="message"
                           class="form-control"
                           placeholder="Type a message…"
                           autocomplete="off"
                           style="height:40px;border-radius:50px;background:#f4f5f7;border-color:#f4f5f7;" />
                    <button type="submit"
                            style="width:40px;height:40px;border-radius:50%;background:#5867dd;border:none;color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;cursor:pointer;transition:background .15s;">
                        <i class="fa fa-paper-plane" style="font-size:14px;"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    let currentContactId = null;

    // File attach
    $('#upload-trigger-btn').on('click', function () { $('#file-input').click(); });
    $('#file-input').on('change', function () {
        if (this.files && this.files[0]) {
            $('#file-name-preview').text(this.files[0].name);
            $('#file-preview-container').css('display', 'flex');
        }
    });
    $('#cancel-file').on('click', function () {
        $('#file-input').val('');
        $('#file-preview-container').hide();
    });

    // Contact click
    $('.contact-item').on('click', function () {
        $('.contact-item').css('background', '');
        $(this).css('background', '#f4f5ff');

        currentContactId = $(this).data('id');
        let name = $(this).find('.fw-semibold').text();
        let role = $(this).find('[style*="text-transform"]').text().trim();

        $('#active-contact-name').text(name);
        $('#active-contact-role').text(role).show();
        $('#chat-header-avatar').text(name.substring(0, 2).toUpperCase()).css('display', 'flex');
        $('#receiver_id').val(currentContactId);
        $('#message-input-area').show();
        $('#chat-placeholder').hide();

        loadMessages(currentContactId);
    });

    function loadMessages(contactId) {
        if (!contactId) return;
        $.ajax({
            url: `/chat/messages/${contactId}`,
            type: 'GET',
            success: function (messages) {
                let box = $('#chat-box');
                box.find('.msg-bubble').remove();

                if (!messages.length) {
                    box.append('<div class="msg-bubble text-center text-muted" style="font-size:13px;margin-top:20px;">No messages yet. Say hello!</div>');
                } else {
                    messages.forEach(function (msg) {
                        let isMe = msg.sender_id == "{{ Auth::id() }}";
                        let bg   = isMe ? '#5867dd' : '#fff';
                        let clr  = isMe ? '#fff' : '#1a1a2e';
                        let brd  = isMe ? 'none' : '1px solid #eaebf0';
                        let align = isMe ? 'flex-end' : 'flex-start';
                        let radius = isMe ? '18px 18px 4px 18px' : '18px 18px 18px 4px';

                        let fileHtml = '';
                        if (msg.file_path) {
                            fileHtml = `<div class="mt-2 p-2 rounded d-flex align-items-center gap-2" style="background:rgba(0,0,0,.06);font-size:12px;">
                                <i class="fas fa-file fa-lg text-danger"></i>
                                <a href="/storage/${msg.file_path}" target="_blank" style="color:inherit;font-weight:600;">Download File</a>
                            </div>`;
                        }
                        let textHtml = msg.message && msg.message !== msg.file_path ? `<div>${msg.message}</div>` : '';
                        let time = new Date(msg.created_at).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});

                        box.append(`<div class="msg-bubble" style="display:flex;justify-content:${align};">
                            <div style="max-width:70%;background:${bg};color:${clr};border:${brd};border-radius:${radius};padding:10px 14px;font-size:13px;">
                                ${textHtml}${fileHtml}
                                <div style="font-size:10px;opacity:.6;text-align:right;margin-top:4px;">${time}</div>
                            </div>
                        </div>`);
                    });
                }
                box.scrollTop(box[0].scrollHeight);
            }
        });
    }

    // Send
    $('#chat-form').on('submit', function (e) {
        e.preventDefault();
        let fd = new FormData(this);
        $.ajax({
            url: "{{ route('chat.store') }}",
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function () {
                $('#message-text').val('');
                $('#file-input').val('');
                $('#file-preview-container').hide();
                loadMessages(currentContactId);
            },
            error: function (xhr) {
                alert((xhr.responseJSON && xhr.responseJSON.error) || 'Something went wrong.');
            }
        });
    });

    // Auto-refresh every 3s
    setInterval(function () {
        if (currentContactId) loadMessages(currentContactId);
    }, 3000);
});
</script>
@endpush