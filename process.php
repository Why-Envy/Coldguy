<?php
// process.php

// 1. Database Configuration
$db_host = 'localhost';
$db_user = 'root'; // Update with your DB username
$db_pass = '';     // Update with your DB password
$db_name = 'codeman_db'; // Update with your DB name

// 2. SMS Gateway Configuration (e.g., Arkesel, mNotify, Hubtel)
// You must sign up for an API key with a provider to make this work in production.
$sms_api_key = 'YOUR_API_KEY_HERE';
$sms_sender_id = 'CODEMAN';
$admin_phone = '024XXXXXXX'; // The number that receives the alert

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize Inputs
    $name = filter_var(trim($_POST['client_name']), FILTER_SANITIZE_STRING);
    $phone = filter_var(trim($_POST['client_phone']), FILTER_SANITIZE_STRING);
    $service = filter_var(trim($_POST['service_type']), FILTER_SANITIZE_STRING);
    $details = filter_var(trim($_POST['details']), FILTER_SANITIZE_STRING);

    // Validate
    if (empty($name) || empty($phone) || empty($service)) {
        die("Error: Required fields are missing. Please go back and try again.");
    }

    // --- A. Database Insertion ---
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }

    // Prepared Statement for security against SQL Injection
    $stmt = $conn->prepare("INSERT INTO service_requests (client_name, phone_number, service_type, project_details) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $service, $details);
    
    if ($stmt->execute()) {
        $db_success = true;
    } else {
        die("Database Error: " . $stmt->error);
    }
    
    $stmt->close();
    $conn->close();

    // --- B. SMS Alert via cURL ---
    if ($db_success) {
        $message = "NEW LEAD: $name requires $service. Phone: $phone. Log in to dashboard for details.";
        
        // Example payload for a standard REST SMS API
        $sms_data = [
            'sender' => $sms_sender_id,
            'message' => $message,
            'recipients' => [$admin_phone]
        ];

        // API Endpoint (Replace with your chosen provider's URL)
        $url = 'https://sms.api.provider.com/v2/sms/send';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sms_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'api-key: ' . $sms_api_key
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);

        // 3. Success Redirect
        // In a real application, you redirect back to contact.html with a success message
        echo "<div style='font-family: Arial; text-align: center; margin-top: 50px;'>";
        echo "<h2 style='color: #5BC0BE;'>Request Submitted Successfully</h2>";
        echo "<p>Your database entry was recorded, and the dispatch center has been notified via SMS.</p>";
        echo "<a href='index.html'>Return to Homepage</a>";
        echo "</div>";
    }
} else {
    // If accessed directly without POST data
    header("Location: contact.html");
    exit();
}
?>