@extends('shipper.layouts.master')

@section('title')
  {{ $settings->site_name }} || Message
@endsection


@section('content')

<audio id="message_send_audio">
  <source src="{{ asset('sounds/message-send.mp3') }}" type="audio/mpeg"/>
</audio>

<input type="hidden" name="" id="sender_id_real_time" value="">


  <section id="wsus__dashboard">
    <div class="container-fluid">
      @include('shipper.layouts.sidebar')
      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h4><i class="far fa-comment mb-2"></i> Message</h4>
                <div class="wsus__dashboard_review">
                    <div class="row">
                        <div class="col-xl-4 col-md-5">
                            <div class="wsus__chatlist d-flex align-items-start">
                                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <h2>Customer List</h2>
                                    <div class="wsus__chatlist_body">
                                      @foreach ($chatUsers as $chatUser )
                                      @php
                                        $unseenMessages = \App\Models\Chat::where(['sender_id' => $chatUser->receiverProfile->id, 'receiver_id' => auth()->user()->id, 'seen' => 0])->exists();
                                      @endphp
                                        <button class="nav-link chat_user_profile" data-id="{{ $chatUser->receiverProfile->id }}" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-home" type="button" role="tab"
                                            aria-controls="v-pills-home" aria-selected="true">
                                            <div class="wsus_chat_list_img {{ $unseenMessages ? 'msg-notification' : '' }}">
                                                <img src="{{ asset($chatUser->receiverProfile->image) }}"
                                                    alt="user" class="img-fluid">
                                                <span class="pending d-none" id="pending-6">0</span>
                                            </div>
                                            <div class="wsus_chat_list_text">
                                                <h4>{{ $chatUser->receiverProfile->name }}</h4>
                                            </div>
                                        </button>

                                      @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-7">
                            <div class="wsus__chat_main_area" style="position: relative;" data-inbox="">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show" id="v-pills-home" role="tabpanel"
                                        aria-labelledby="v-pills-home-tab">
                                        <div id="chat_box">
                                            <div class="wsus__chat_area">
                                                <div class="wsus__chat_area_header">
                                                    <h2 id="chat_inbox_title">Chat with Customer</h2>
                                                </div>
                                                <div class="wsus__chat_area_body" data-inbox="">

                                                </div>
                                                <div class="wsus__chat_area_footer" style="margin-top: 50px; position: absolute; width:100%; bottom: 0">
                                                    <form class="message_modal" method="POST">
                                                      @csrf
                                                        <input type="text" class="message_box" placeholder="Type Message"
                                                            name="message" autocomplete="off">
                                                        <input type="hidden" name="receiver_id" id="receiver_id" value="5">
                                                        <button type="submit" class="send_btn"><i class="fas fa-paper-plane"
                                                                aria-hidden="true"></i></button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
  </section>



@endsection

@push('scripts')

<script>
  const mainChatBox = $('.wsus__chat_area_body');

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

    // show messages
    $('.chat_user_profile').on('click', function() {
      $('.chat_user_profile').removeClass('active');
      $(this).addClass('active');
      let receiverId = $(this).data('id');
      let receiverImage = $(this).find('img').attr('src');
      let chatUserName = $(this).find('h4').text();
      mainChatBox.attr('data-inbox', receiverId);
      $('.wsus__chat_main_area').attr('data-inbox', receiverId);
      $('#receiver_id').val(receiverId);
      //remove css mesage notification
      $(this).find('.wsus_chat_list_img').removeClass('msg-notification');

      $.ajax({
        method: 'GET',
        url: "{{ route('shipper.get-messages') }}",
        data: {
          receiver_id: receiverId
        },
        beforeSend: function() {
          mainChatBox.html("");
          let spinner = `<div class="d-flex justify-content-center align-items-center text-info" style="position:absolute; top:45%;left:45%">
                            <div class="spinner-border" role="status">
                              <span class="visually-hidden">Loading...</span>
                            </div>
                          </div>`;
          mainChatBox.html(spinner);
          $('#chat_inbox_title').text(`Chat With ${chatUserName}`);
        },
        success: function(response) {
          mainChatBox.html("");
          $.each(response, function(i, value) {
            if(value.sender_id == USER.id) {
              var message = `<div class="wsus__chat_single single_chat_2">
                            <div class="wsus__chat_single_img">
                                <img src="${USER.image}"
                                    alt="user" class="img-fluid">
                            </div>
                            <div class="wsus__chat_single_text">
                                <p>${value.message}</p>
                                <span>${formatDateTime(value.created_at)}</span>
                            </div>
                          </div>`;
            }
            else {
              var message = `<div class="wsus__chat_single">
                            <div class="wsus__chat_single_img">
                                <img src="${receiverImage}"
                                    alt="user" class="img-fluid">
                            </div>
                            <div class="wsus__chat_single_text">
                                <p>${value.message}</p>
                                <span>${formatDateTime(value.created_at)}</span>
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
      let message = `<div class="wsus__chat_single single_chat_2">
                        <div class="wsus__chat_single_img">
                            <img src="${USER.image}"
                                alt="user" class="img-fluid">
                        </div>
                        <div class="wsus__chat_single_text">
                            <p>${messageData}</p>
                            <span>${formatDateTime(new Date())}</span>
                        </div>
                      </div>`;
      mainChatBox.append(message);
      scrollToBottom();

      $.ajax({
        method: 'POST',
        url: "{{ route('shipper.send-message') }}",
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

    // remove css unseen message
    $('.wsus__chat_main_area').on('click', function() {
      if($(this).attr('data-inbox') == $('#sender_id_real_time').val()) {
        $('.wsus_chat_list_img').removeClass('msg-notification');
      }
      else return;
    })

  })
</script>

@endpush
