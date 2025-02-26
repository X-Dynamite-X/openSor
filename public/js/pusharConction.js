Pusher.logToConsole = true;

var pusher = new Pusher("5fc41df8d14e9095b055", {
    cluster: "mt1",
});
const conversationElements = document.querySelectorAll(
    "#conversation_list [id^=conversation_]"
);
const channels = {};
conversationElements.forEach((element) => {
    const conversationId = element.getAttribute("id");
    const channel = pusher.subscribe(`${conversationId}`);
    channels[conversationId] = channel;
});
function openBind(conversation_id) {
    const channelName = `conversation_${conversation_id}`;
    const channel = channels[channelName];
    if (channel) {
        channel.bind("new-message", function (data) {
            if ($("#chat_header").data("user_id") == data.message.sender_id) {
                $(`#chat_messages`).append(data.response_message_html);
            }
            $(`#last_message_text_${conversation_id}`).text(data.message.text);
            $(`#last_message_at_${conversation_id}`).text(
                data.message.created_at
            );
        });
    } else {
        console.error("Channel not found:", channelName);
    }
}
function closeBind(conversation_id) {
    const channelName = `conversation_${conversation_id}`;
    const channel = channels[channelName];

    if (channel) {
         channel.unbind("new-message");
        console.log(`Listener removed for channel: ${channelName}`);
    } else {
        console.error("Channel not found:", channelName);
    }
}

///////////
