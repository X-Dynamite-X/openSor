Pusher.logToConsole = true;

var pusher = new Pusher("5fc41df8d14e9095b055", {
    cluster: "mt1",
});

const channels = {};

// تهيئة القنوات عند تحميل الصفحة
function initializeChannels() {
    const conversationElements = document.querySelectorAll(
        "#conversation_list [id^=conversation_]"
    );

    conversationElements.forEach((element) => {
        const conversationId = element.id.replace('conversation_', '');
        subscribeToConversation(conversationId);
    });
}

// دالة للاشتراك في قناة محادثة واحدة
function subscribeToConversation(conversationId) {
     if (!channels[`conversation_${conversationId}`]) {
        const channel = pusher.subscribe(`conversation_${conversationId}`);
        channels[`conversation_${conversationId}`] = channel;

         channel.bind("new-message", function(data) {
            handleNewMessage(conversationId, data);
        });
    }
    return channels[`conversation_${conversationId}`];
}


// function unsubscribeFromConversation(conversationId) {
//     const channelName = `conversation_${conversationId}`;
//     if (channels[channelName]) {
//         pusher.unsubscribe(channelName);
//         delete channels[channelName];
//     }
// }

function handleNewMessage(conversationId, data) {
    const currentUserId = $("#chat_header").data("user_id");
    const isCurrentConversationOpen = $("#chat_area").find(`#chat_messages`).length > 0;

    // تحديث آخر رسالة في قائمة المحادثات
    $(`#last_message_text_${conversationId}`).text(data.message.text);
    $(`#last_message_at_${conversationId}`).text(data.message.created_at);

    // تحريك المحادثة إلى الأعلى
    moveConversationsInLastMessage(conversationId);

    // إذا كانت المحادثة مفتوحة حالياً
    if (isCurrentConversationOpen && $("#chat_header").data("conversation_active") == conversationId) {
        if (currentUserId == data.message.sender_id) {
            $(`#chat_messages`).append(data.response_message_html);
            setTimeout(scrollToBottom, 100);
        }
    } else {
        // إذا لم تكن المحادثة مفتوحة، قم بزيادة عداد الرسائل غير المقروءة
        let unreadCount = $(`#conversation_${conversationId}`).find("#unread_count");
        if (unreadCount.length) {
            let count = parseInt(unreadCount.text()) + 1;
            unreadCount.text(count);
        } else {
            // إضافة عداد جديد إذا لم يكن موجوداً
            $(`#conversation_${conversationId}`).find(".flex.items-center.justify-between")
                .append('<span class="bg-cyan-500 text-white text-xs rounded-full px-2 py-1 ml-2" id="unread_count">1</span>');
        }
    }
}

 function moveConversationsInLastMessage(conversation_id) {
    const conversationList = $("#conversation_list");
    const conversation = $(`#conversation_${conversation_id}`);
    if (conversation.length) {
        const conversationHtml = conversation.prop("outerHTML");
        conversation.remove();
        conversationList.prepend(conversationHtml);
    }
}
function scrollToBottom() {
    const chatMessages = document.getElementById("chat_messages");
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}





 $(document).ready(function() {
    initializeChannels();
});
