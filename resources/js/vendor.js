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
function enableSoundMessage() {
  const audio = document.getElementById('message_send_audio');
  audio.autoplay = true;
  audio.load();
}

window.Echo.private('message.' + USER.id).listen(
  "MessageEvent",
  (e) => {

    if(mainChatBox.attr('data-inbox') == e.sender_id) {
      var message = `<div class="wsus__chat_single">
                      <div class="wsus__chat_single_img">
                          <img src="${e.sender_image}"
                              alt="user" class="img-fluid">
                      </div>
                      <div class="wsus__chat_single_text">
                          <p>${e.message}</p>
                          <span>${formatDateTime(e.send_date)}</span>
                      </div>
                    </div>`;

    }

    mainChatBox.append(message);
    scrollToBottom();

    // add notification circle when received message
    $('.chat_user_profile').each(function() {
      let profileUserId = $(this).data('id');
      if(profileUserId == e.sender_id) {
        $(this).find('.wsus_chat_list_img').addClass('msg-notification');
      }
    })

    // increase value unseen message
    let unseenMessage = parseInt($('#message-count').text());
    unseenMessage += 1;
    $('#message-count').text(unseenMessage);

    // set sender id to input for remove css unseen message
    $('#sender_id_real_time').val(e.sender_id);

    //add sound
    enableSoundMessage();
  }
)
