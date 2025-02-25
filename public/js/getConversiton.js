document.addEventListener("DOMContentLoaded", function () {
    // Auto scroll to bottom
    const messagesContainer = document.getElementById("chat-messages");
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    let searchTimer;

    // Handle search input
    $("#searchInput").on("input", function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => searchUsers(), 300);
    });

    // Search users via AJAX
    function searchUsers() {
        const searchTerm = $("#searchInput").val(); // Get the current value of the input
        if (searchTerm.trim())
            $.ajax({
                url: "/chat",
                type: "GET",
                dataType: "json",
                data: {
                    search: searchTerm,
                },
                success: function (response) {
                    console.log(response);
                    $("#conversation_list").addClass("hidden");
                    $("#search_conversation_list").removeClass("hidden");
                    $("#search_conversation_list").html(
                        response.new_conversations_html
                    );
                },
                error: function (xhr, status, error) {
                    console.error(error);

                    alert(
                        "An error occurred while searching. Please try again."
                    );
                },
            });
        else {
            $("#conversation_list").removeClass("hidden");
            $("#search_conversation_list").addClass("hidden");
            $("#search_conversation_list").empty();
        }
    }
    // function createConversation(userId){

    //     $.ajax({
    //         url: `/chat`,
    //         type: "post",
    //         data:{
    //             user_two_id:userId,
    //         },
    //         success: function (response) {
    //             console.log(response);
    //         },
    //         error: function (xhr, status, error) {
    //             console.error(error);
    //             alert(
    //                 "An error occurred while searching. Please try again."
    //             );
    //         },
    //     });
    // }
    // function getMessageConversation(conversationId){
    //     $.ajax({
    //         url: `/chat/${conversationId}`,
    //         type: "get",
    //         success: function (response) {
    //             console.log(response);
    //         },
    //         error: function (xhr, status, error) {
    //             console.error(error);
    //             alert(
    //                 "An error occurred while searching. Please try again."
    //             );
    //         },
    //     })
    // }
});
let conversation_id = null;
function getMessageConversation(conversationId) {
    $.ajax({
        url: `/chat/${conversationId}`,
        type: "get",
        success: function (response) {
            conversation_id = conversationId || null;
            $("#unread_count").remove();
            console.log(response);
            $("#chat_area").empty();
            $("#chat_area").html(response.messages_conversation_html);
        },
        error: function (xhr, status, error) {
            console.error(error);
            alert("An error occurred while searching. Please try again.");
        },
    });
}
function createConversation(userId) {
    $.ajax({
        url: `/chat`,
        type: "post",
        data: {
            user_two_id: userId,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            $("#conversation_list").append(response.new_conversation_html);
            $("#chat_area").empty();

            $("#chat_area").html(response.messages_conversation_html);

            $("#searchInput").val("");

            $("#conversation_list").removeClass("hidden");
            $("#search_conversation_list").addClass("hidden");
            $("#search_conversation_list").empty();
        },
        error: function (xhr, status, error) {
            console.error(error);
            alert("An error occurred while searching. Please try again.");
        },
    });
}
function sendmessage() {
    let text = $("#messageInput").val();
    $.ajax({
        url: `/chat/${conversation_id}/message`,
        type: "post",
        data: {
            text: text,
            conversation_id: conversation_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            $("#messageInput").val("");
            $("#chat-messages").append(response.new_message_html);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error(error);
            alert("An error occurred while searching. Please try again.");
        },
    });
}
