<?php
session_start();
require_once __DIR__ . "/../../env/host.php";
require_once "../../env/DTO.php";

header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION["user"])) {
    header("Location:/login");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION["error"] = "Invalid Request.";
    header("Location:/profile");
    exit;
}

$id = $_SESSION["user"]["id"];
$name = htmlspecialchars(trim($_POST["name"] ?? ""));
$email = htmlspecialchars(trim($_POST["email"] ?? ""));
$phone = htmlspecialchars(trim($_POST["phone"] ?? ""));
$age = htmlspecialchars(trim($_POST["age"] ?? ""));
$age = htmlspecialchars(trim($_POST["age"] ?? ""));

// Basic validation replaced by Request file
require_once "../requests/updateProfileRequest.php";

    try {
    $updateData = [
        "name" => $name,
        "email" => $email,
        "phone" => $phone,
        "age" => $age
    ];

    // --- Photo Upload Logic ---
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileSize = $_FILES['photo']['size'];
        $fileType = $_FILES['photo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            if ($fileSize < 2097152) { // 2MB
                // Create unique filename
                $newFileName = time() . '_' . $id . '.' . $fileExtension;
                // Changed from frontend/assets/uploads/users/ to backend/storage/images/
                $uploadFileDir = __DIR__ . '/../storage/images/'; 
                $dest_path = $uploadFileDir . $newFileName;
                
                // Ensure directory exists
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }

                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    // Update DB path - make sure it is relative to web root
                    $updateData['photo'] = $newFileName;
                } else {
                     DTO::session_error("Error moving uploaded file.");
                     header("Location:/edit_profile");
                     exit;
                }
            } else {
                DTO::session_error("File is too big. Max 2MB.");
                header("Location:/edit_profile");
                exit;
            }
        } else {
            DTO::session_error("Invalid file type. Allowed: jpg, png, gif.");
            header("Location:/edit_profile");
            exit;
        }
    }

    // --- GLOBAL SECURITY CHECK ---
    // User must ANY changes with current password
    $current_password = $_POST["current_password"] ?? "";
    
    if (empty($current_password)) {
        DTO::session_error("Current password is required to save changes.");
        header("Location:/edit_profile");
        exit;
    }

    $dbUser = DB::select("users")->where("id", $id)->get()[0];
    if (!password_verify($current_password, $dbUser["password"])) {
        DTO::session_error("Incorrect current password.");
        header("Location:/edit_profile");
        exit;
    }

    // Password Update Logic (Optional)
    $new_password = $_POST["new_password"] ?? "";
    if (!empty($new_password)) {
        $updateData["password"] = password_hash($new_password, PASSWORD_DEFAULT);
    }

    // Check Email and Atomic Update Logic
    if ($email !== $_SESSION["user"]["email"]) {
        // --- 1. Validate Uniqueness ---
        $existingUser = DB::select("users")->where("email", $email)->first();
        if ($existingUser) {
             DTO::session_error("Email is already taken.");
             header("Location:/edit_profile");
             exit;
        }

        // --- 2. Prepare Pending Data ---
        // Capture Instructor Data if applicable
        $instructorPending = null;
        if ($_SESSION["user"]["role"] === 'instructor') {
             $instructorPending = [
                 "skills" => $skills ?? $_POST["skills"] ?? "", // Ensure vars are defined
                 "experience_years" => $experience_years ?? $_POST["experience_years"] ?? "",
                 "price" => $price ?? $_POST["price"] ?? "",
                 "available" => $available ?? (isset($_POST["available"]) ? 1 : 0)
             ];
             
             // Variables might not be set if we moved the logic block validation
             // Let's ensure we grab values if they weren't set above (since we moved the block)
             // Actually, I'll move the variable extraction up or just use POST here safely.
             // Refactoring: The user role check block above actually sets these vars?
             // No, I moved that block. Wait. 
             // In previous step I moved instructor logic UP. 
             // Now I need to prevent it from running IF email is executing.
             // OR, better: Gather the data first, then decide to Update or Defer.
        }

        require_once __DIR__ . "/../../mail/mail.php";
        
        $token = bin2hex(random_bytes(32));
        $expiredAt = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        // Bundle everything
        $pendingPayload = [
            'user' => $updateData, // Contains name, phone, age, password (if set)
            'instructor' => $instructorPending
        ];

        // Insert into email_verification with PENDING DATA
        DB::table("email_verification")->insert([
            "user_id" => $id,
            "email" => $email, // New email
            "token" => $token,
            "expired_at" => $expiredAt,
            "pending_data" => json_encode($pendingPayload)
        ]);
        
        // Send Email
        sendVerificationEmail($email, $token);
        $_SESSION['pending_verification_email'] = $email;
        
        DTO::session_success("Profile update pending. Please verify your new email to apply changes.");
        // Redirect WITHOUT updating DB
        header("Location:/verification_sent");
        exit;
    }

    // --- NO Email Change: Execute Updates Immediately ---

    // 1. Update Instructor
    if ($_SESSION["user"]["role"] === 'instructor') {
         // (Same validation/extraction logic as originally)
         $skills = htmlspecialchars(trim($_POST["skills"] ?? ""));
         $experience_years = htmlspecialchars(trim($_POST["experience_years"] ?? ""));
         $price = htmlspecialchars(trim($_POST["price"] ?? ""));
         $available = isset($_POST["available"]) ? 1 : 0;
         
         $instructor = DB::select('instructors')->where('user_id', $id)->get();
         if (!empty($instructor)) {
            DB::table("instructors")->where("user_id", $id)->update([
                "skills" => $skills,
                "experience_years" => $experience_years,
                "price" => $price,
                "available" => $available
            ]);
         } else {
            DB::table("instructors")->insert([
                "user_id" => $id,
                "skills" => $skills,
                "experience_years" => $experience_years,
                "price" => $price,
                "available" => $available
            ]);
         }
    }

    // 2. Update User
    DB::table('users')->where('id' , $id)->update($updateData);

    // Update session
    $user = DB::select("users")->where("id", $id)->get()[0];
    $_SESSION["user"] = $user;

    DTO::session_success("Profile updated successfully!");
    header("Location:/profile");

} catch (Exception $e) {
    DTO::session_error("Error updating profile. Please try again.");
    header("Location:/edit_profile");
}
