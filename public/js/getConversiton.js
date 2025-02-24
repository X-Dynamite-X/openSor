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
                    $("#search_conversation_list").html(response.new_conversations_html);

                    // Update the UI with the search results
                    // updateConversationList(response);
                },
                error: function (xhr, status, error) {
                    console.error(error);

                    // Show an error message to the user
                    alert(
                        "An error occurred while searching. Please try again."
                    );
                },
            });
            else{
                $("#conversation_list").removeClass("hidden");
                $("#search_conversation_list").addClass("hidden");
                $("#search_conversation_list").empty();

            }
    }

  
     
});
