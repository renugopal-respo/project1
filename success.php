
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Page</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        }

        /* Success Container */
        .success-container {
            text-align: center;
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
            animation: fadeIn 1s ease-in-out;
        }

        /* Success Message */
        .success-message {
            font-size: 24px;
            font-weight: 600;
            color: #155724;
            margin-bottom: 20px;
        }

        /* Back Button */
        .back-btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            color: #fff;
            background: linear-gradient(135deg, #007BFF, #0056b3);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #0056b3, #007BFF);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <!-- Success Message -->
        <div class="success-message">
            🎉 Form submitted successfully! 🎉
        </div>

        <!-- Back Button -->
        <a href="javascript:history.back()" class="back-btn">⬅ Go Back</a>
    </div>

    <script>
        // Add smooth transition when navigating back
        document.querySelector('.back-btn').addEventListener('click', function (e) {
            e.preventDefault();
            history.back();
        });
    </script>
</body>
</html>