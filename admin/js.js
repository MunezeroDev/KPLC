

function changeAvailability(connectionId) {
    document.querySelectorAll('.assign-staff-link').forEach(link => {
        link.addEventListener('click', function () {
            const staffId = this.dataset.staffId;
            console.log('Assigned staff ID:', staffId);
            console.log('Connection ID:', connectionId);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_staff_availability.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Update the UI to reflect the new status
                            alert(response.message);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    } catch (e) {
                        alert('Catch: Error processing response');
                    }
                } else {
                    alert('Error updating staff availability');
                }
            };

            // Send both staff ID and connection ID to the server
            const data = 'staff_id=' + encodeURIComponent(staffId) +
                '&connection_id=' + encodeURIComponent(connectionId);
            xhr.send(data);
        });
    });
    // end of document selector 
}


function changeAvailability(connectionId) {
    document.querySelectorAll('.assign-staff-link').forEach(link => {
        link.addEventListener('click', function () {
            const staffId = this.dataset.staffId;
            console.log('Assigned staff ID:', staffId);
            console.log('Connection ID:', connectionId);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_staff_availability.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        // Check for 'status' instead of 'success'
                        if (response.status === 'success') {
                            alert(response.message);
                            // You might want to update the UI here
                            // For example, disable the button or update the status display
                        } else {
                            alert('Error: ' + response.message);
                        }
                    } catch (e) {
                        console.error('JSON parsing error:', e);
                        alert('Error processing response');
                    }
                } else {
                    alert('Server error: ' + xhr.status);
                }
            };

            const data = 'staff_id=' + encodeURIComponent(staffId) +
                '&connection_id=' + encodeURIComponent(connectionId);
            xhr.send(data);
        });
    });
}