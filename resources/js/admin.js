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

function enableSoundMessage() {
  const audio = document.getElementById('message_send_audio');
  audio.autoplay = true;
  audio.load();
}

window.Echo.private('message.' + USER.id).listen(
  "MessageEvent",
  (e) => {

    if(mainChatBox.attr('data-inbox') == e.sender_id) {
      var message = `<div class="chat-item chat-left" style="">
                      <img src="${e.sender_image}">
                      <div class="chat-details">
                        <div class="chat-text">${e.message}</div>
                        <div class="chat-time">${formatDateTime(e.send_date)}</div>
                      </div>
                    </div>`;
    }

    mainChatBox.append(message);
    scrollToBottom();

    // add notification circle when received message
    $('.chat_user_profile').each(function() {
      let profileUserId = $(this).data('id');
      if(profileUserId == e.sender_id) {
        $(this).find('img').addClass('msg-notification');
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
