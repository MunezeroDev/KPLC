
//Display alert function
function displayAlert(message, duration = 10000) {
    const alertElement = document.querySelector('.full-width-alert');
    const messageElement = alertElement.querySelector('.message');

    const parsedMessage = JSON.parse(message);
    messageElement.textContent = parsedMessage.message;

    alertElement.classList.remove('success', 'error', 'warning', 'info');
    alertElement.classList.add(parsedMessage.status);

    alertElement.classList.add('display');

    const actionButton = alertElement.querySelector('.action-button');
    actionButton.addEventListener('click', () => {
        alertElement.classList.remove('display');
    });

    if (duration) {
        setTimeout(() => {
            alertElement.classList.remove('display');
        }, duration);
    }
}



// send message,  staffId & connectionId data to another file 
function sendNotification(staffId, connectionId) {
    const message = "Connection Task of ID " + connectionId + " Assigned To You";
    const params = `staff_id=${encodeURIComponent(staffId)}&connection_id=${encodeURIComponent(connectionId)}&message=${encodeURIComponent(message)}`;
    const xhr = new XMLHttpRequest();

    xhr.open("POST", "staff/notification.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                console.log("Response:", response);
                if (response.status === 'success') {
                    console.log(response.message);
                } else {
                    console.error("Error:", response.message);
                }
            } catch (e) {
                console.error("JSON parsing error:", e.message);
                console.log("Raw response:", xhr.responseText);
            }
        } else {
            console.log("Error:", xhr.status, xhr.statusText);
        }
    };

    // console.log("Sending notification...");
    // console.log("Assigned staff ID:", staffId);
    // console.log("Connection ID:", connectionId);
    // console.log("Message:", message);

    xhr.send(params);
}