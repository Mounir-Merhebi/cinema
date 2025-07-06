<?php 

require(__DIR__ . "/../models/User.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/UserService.php");
require(__DIR__ . "/../services/ResponseService.php");

class UserController{
    
    public function getUser(){

        global $mysqli;
        
        header('Content-Type: application/json');

        $userId = $_GET['id'] ?? null;
        
        if (!$userId || !is_numeric($userId)) {
            echo json_encode(["success" => false, "message" => "Invalid or missing user ID."]);
            exit();
        }
        
        $user = User::find($mysqli, (int)$userId); 
        
        if ($user === null) {
            echo json_encode(["success" => false, "message" => "User not found."]);
        } else {
            $userData = [
                "id" => $user->getId(),
                "fullname" => $user->getFullname(),
                "email" => $user->getEmail(),
                "mobile_number" => $user->getMobileNumber(),
                "date_of_birth" => $user->getDateOfBirth(),
                "communication_prefs" => $user->getCommunicationPrefs(),
                "membership_level" => $user->getMembershipLevel(),
                "created_at" => $user->getCreatedAt(),
                "age_verified" => $user->getAgeVerified()
            ];
        
            echo json_encode(["success" => true, "user" => $userData]);
        }
        
        $mysqli->close();
    }
 

    public function deleteUser() {
        global $mysqli;
    
        header('Content-Type: application/json');
        $userId = $_POST['id'] ?? null;
        
        if (!$userId || !is_numeric($userId)) {
            echo json_encode(["success" => false, "message" => "Invalid or missing user ID for deletion."]);
            exit();
        }
        
        try {
            $deleteSuccess = User::delete($mysqli, (int)$userId);
        
            if ($deleteSuccess) {
                echo json_encode(["success" => true, "message" => "Account deleted successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to delete account. User might not exist or a server error occurred."]);
            }
        } catch (Exception $e) {
            error_log("Error deleting user: " . $e->getMessage());
            echo json_encode(["success" => false, "message" => "An unexpected error occurred during deletion."]);
        } finally {
            $mysqli->close();
        }
    }



  public function UpdateUser() {
        global $mysqli;
    
        header('Content-Type: application/json'); 

        if (!isset($_POST['id']) || !isset($_POST['fullname']) || !isset($_POST['email']) ||
            !isset($_POST['mobile_number']) || !isset($_POST['date_of_birth']) || !isset($_POST['communication_prefs'])) {
            echo json_encode(["success" => false, "message" => "Missing required data for update."]);
            exit;
        }
        
        $id = (int)$_POST['id'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $mobile_number = $_POST['mobile_number'];
        $date_of_birth = $_POST['date_of_birth'];
        $communication_prefs = $_POST['communication_prefs'];

        $updateData = [
            'id' => $id,
            'fullname' => $fullname,
            'email' => $email,
            'mobile_number' => $mobile_number,
            'date_of_birth' => $date_of_birth,
            'communication_prefs' => $communication_prefs,
        ];

        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $hashedPassword = User::hashPassword($_POST['password']);
            $updateData['password'] = $hashedPassword; 
        }

        try {
            $success = User::update($mysqli, $updateData);
        
            if ($success) {
                echo json_encode(["success" => true, "message" => "Profile updated successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to update profile. User might not exist or a database error occurred."]);
            }
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            echo json_encode(["success" => false, "message" => "An unexpected error occurred during profile update."]);
        } finally {
            $mysqli->close();
        }
    }


} 

 
