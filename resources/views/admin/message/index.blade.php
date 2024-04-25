@extends('admin.layouts.master')

@section('content')

<section class="section">
  <div class="section-header">
    <h1>Messages</h1>
    <div class="section-header-breadcrumb">

    </div>
  </div>

  <div class="section-body">

    <div class="row align-items-center justify-content-center">
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card" style="height: 70vh">
          <div class="card-header">
            <h4>Who's Online?</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled list-unstyled-border">
              @foreach ($chatUsers as $chatUser )
                <li class="media chat_user_profile p-2 rounded align-items-center" data-id="{{ $chatUser->senderProfile->id }}" style="cursor: pointer">
                  <img alt="image" class="mr-3 rounded-circle" width="50" src="{{ asset($chatUser->senderProfile->image) }}">
                  <div class="media-body">
                    <div class="mt-0 mb-1 font-weight-bold sender_name">{{ $chatUser->senderProfile->name }}</div>
                    {{-- <div class="text-success text-small font-600-bold"><i class="fas fa-circle"></i> Online</div> --}}
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-9">
        <div class="card chat-box" id="mychatbox" style="height: 70vh">
          <div class="card-header">
            <h4 id="chat_inbox_title"></h4>
          </div>
          <div class="card-body chat-content" data-inbox="" style="position: relative">


          </div>
          <div class="card-footer chat-form d-none">
            <form id="chat-form" class="message_modal" method="POST">
              @csrf
              <input type="text" class="form-control message_box" placeholder="Type a message" name="message">
              <input type="hidden" name="receiver_id" id="receiver_id" value="">
              <button class="btn btn-primary send_btn" disabled>
                <i class="far fa-paper-plane"></i>
              </button>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection


@push('scripts')

<script>
  const mainChatBox = $('.chat-content');

  function formatDateTime(dateTimeString) {
    const options = {
      year: 'numeric',
      month: 'short',
      day: '2-digit',
      hour: '2-digit',
      minute: '2-digit'
    }
    const formatedDateTime = new Intl.DateTimeFormat('en-us', options).format(new Date(dateTimeString));
    return formatedDateTime;
  }

  function scrollToBottom() {
    mainChatBox.scrollTop(mainChatBox.prop('scrollHeight'));
  }

  $(document).ready(function() {

    // show all message between sender and receiver
    $('.chat_user_profile').on('click', function() {

      // style when click
      $('.chat_user_profile').removeClass('active');
      $(this).addClass('active');

      // get sender id
      let senderId = $(this).data('id');
      //get sender image
      let senderImage = $(this).find('img').attr('src');
      //bind sender name
      let chatUserName = $(this).find('.sender_name').text();
      // set id to box chat
      mainChatBox.attr('data-inbox', senderId);
      // set receriver id
      $('#receiver_id').val(senderId);
      $.ajax({
        method: 'GET',
        url: "{{ route('admin.get-messages') }}",
        data: {
          sender_id: senderId
        },
        beforeSend: function() {
          mainChatBox.html("");
          let spinner = `<div class="d-flex justify-content-center align-items-center text-info" style="position:absolute;    top:45%;left:45%">
                            <div class="spinner-border" role="status">
                              <span class="visually-hidden">Loading...</span>
                            </div>
                          </div>`;

          mainChatBox.html(spinner);
          $('#chat_inbox_title').text(`Chat With ${chatUserName}`);
        },
        success: function(response) {
          $('.card-footer').removeClass('d-none');
          $('.send_btn').prop('disabled', false);
          mainChatBox.html("");
          $.each(response, function(i, value) {
            if(value.sender_id == senderId) {
              var message = `<div class="chat-item chat-left" style="">
                                <img src="${senderImage}">
                                <div class="chat-details">
                                  <div class="chat-text">${value.message}</div>
                                  <div class="chat-time">${formatDateTime(value.created_at)}</div>
                                </div>
                              </div>`;
            }
            else {
              var message = `<div class="chat-item chat-right" style="">
                                <img src="${USER.image}">
                                <div class="chat-details">
                                  <div class="chat-text">${value.message}</div>
                                  <div class="chat-time">${formatDateTime(value.created_at)}</div>
                                </div>
                              </div>`;
            }

            mainChatBox.append(message);
          });

          scrollToBottom();
        },
        error: function(xhr, status, err) {
          console.log(err);
          mainChatBox.html("");
        },
        complete: function() {

        }
      })
    })

    // send message
    $('.message_modal').on('submit', function(e) {
      e.preventDefault();
      let formData = $(this).serialize();
      let messageData = $('.message_box').val();

      var formSubmitting = false;

      if(formSubmitting || messageData == "") {
        return;
      }

      // set mesage in inbox before getting response

      let message = `<div class="chat-item chat-right" style="">
                        <img src="${USER.image}">
                        <div class="chat-details">
                          <div class="chat-text">${messageData}</div>
                          <div class="chat-time">${formatDateTime(new Date())}</div>
                        </div>
                      </div>`;
      mainChatBox.append(message);
      scrollToBottom();

      $.ajax({
        method: 'POST',
        url: "{{ route('admin.send-meesage') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: formData,
        beforeSend: function() {
          $('.message_box').val('');
          $('.send_btn').prop('disabled', true);
          formSubmitting = true;
        },
        success: function(response) {
          if(response.status == 'success') {
            $('.message_box').val('');
          }
        },
        error: function(xhr, status, err) {
          $('.send_btn').prop('disabled', false);
          let errors = xhr.responseJSON.errors;
          console.log(errors);
          $.each(errors, function(i, e) {
            toastr.error(e);
          })
          formSubmitting = false;
        },
        complete: function() {
          $('.send_btn').prop('disabled', false);
          formSubmitting = false;
        }
      })
    })

  })
</script>

@endpush
