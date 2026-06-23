$.ajax({
    url: '/chat/messages/' + contactId,
    type: 'GET',
    success: function(messages) {
        console.log(messages); // Para makita mo sa Console (F12) kung ano ang nakukuha mo
        // Dito mo ilalagay ang logic para i-display ang messages sa chat-box
    },
    error: function(xhr) {
        console.log("Error:", xhr.responseText); // Para madaling ma-debug kung may error
    }
});
