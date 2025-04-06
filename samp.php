\*<?php
   $value="sivakasi";
   $check="east street sithurajapuram Sivakasi";
   if (stripos($check,$value) !== false) {
    echo "1";   
   }
	elseif(stripos($check,"sivaksi")!=false) {
    echo "2";
}
?>*\
<?php
// Define an array with options
$fruits = ["Apple", "Banana", "Cherry", "Mango", "Orange"];

echo "<select name='fruits'>"; // Start dropdown
foreach ($fruits as $fruit) {
    echo "<option value='$fruit'>$fruit</option>"; // Create options from array
}
echo "</select>"; // End dropdown
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule a Call - Kovai Realtors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            background: url('your-image.jpg') no-repeat center center/cover;
        }
        .form-box {
            background-color: #0a2540;
            color: white;
            padding: 40px;
            border-radius: 10px;
            width: 450px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .form-box h2 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 26px;
        }
        input {
            width: calc(100% - 20px);
            padding: 14px;
            border-radius: 5px;
            border: none;
            display: block;
            font-size: 16px;
        }
        .name-inputs {
            display: flex;
            gap: 12px;
        }
        .radio-group {
            margin: 15px 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .radio-group label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            cursor: pointer;
            position: relative;
            padding-left: 30px;
        }
        .radio-group input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        .radio-group label::before {
            content: "";
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid white;
            position: absolute;
            left: 0;
            top: 2px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .radio-group input[type="radio"]:checked + label::before {
            background-color: #e63946;
            border-color: #e63946;
            transform: scale(1.2);
        }
        .checkbox {
            display: flex;
            align-items: center;
            font-size: 14px;
            margin-top: 15px;
        }
        .submit-btn {
            width: 100%;
            background-color: #e63946;
            color: white;
            border: none;
            padding: 14px;
            font-size: 18px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        .submit-btn:hover {
            background-color: #b02a36;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Schedule a Call</h2>
            <form>
                <div class="name-inputs">
                    <input type="text" placeholder="First Name" required>
                    <input type="text" placeholder="Last Name" required>
                </div>
                <input type="email" placeholder="Enter your email address" required>
                <input type="tel" placeholder="Phone Number" required>
                <label>Best time to call?</label>
                <div class="radio-group">
                    <input type="radio" id="today" name="call-time" value="Today" required>
                    <label for="today">Today</label>
                    <input type="radio" id="tomorrow" name="call-time" value="Tomorrow">
                    <label for="tomorrow">Tomorrow</label>
                    <input type="radio" id="weekend" name="call-time" value="Weekend">
                    <label for="weekend">Weekend</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" required> By clicking Submit, you agree to our Terms.
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
