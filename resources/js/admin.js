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

window.Echo.private('message.' + USER.id).listen(
  "MessageEvent",
  (e) => {
    const mainChatBox = $('.chat-content');
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
  }
)
