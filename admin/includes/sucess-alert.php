<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            display: flex;
            justify-content: center;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .notification {
            background-color: #ff3366;
            color: white;
            padding: 12px 24px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.3s ease-out;
        }

        .notification-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .check-icon {
            width: 16px;
            height: 16px;
        }

        /* Animation for the checkmark drawing effect */
        .check-path {
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
            animation: drawCheck 0.6s ease forwards;
            animation-delay: 0.3s;
        }

        .message {
            font-size: 14px;
            font-weight: 500;
        }

        .action-button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            padding: 0;
            text-decoration: underline;
        }

        .action-button:hover {
            opacity: 0.9;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes drawCheck {
            to {
                stroke-dashoffset: 0;
            }
        }
    </style>
</head>

<body>

</body>

</html>


<script>
   
</script>