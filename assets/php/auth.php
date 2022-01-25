<?php

require_once 'config.php';

/**
 * Auth Class
 */
class Auth extends Database
{
    
    // Register new user
    public function register($name,$email,$password){
    	$sql = "INSERT INTO users (name,email,password) VALUES (:name, :email, :pass)";
    	$stmt = $this->conn->prepare($sql);
    	$stmt->execute(['name'=>$name, 'email'=>$email, 'pass'=>$password]);
    	return true;
    }

    // check if user already registered
    public function user_exists($email){
    	$sql = "SELECT email FROM users WHERE email =:email";
    	$stmt = $this->conn->prepare($sql);
    	$stmt->execute(['email'=>$email]);
    	$result = $stmt->fetch(PDO::FETCH_ASSOC);

    	return $result;
    }

    // Login Existing User
    public function login($email){
        $sql = "SELECT email,password FROM users WHERE email = :email AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // Current User details in Session

    public function currentUser($email){
        $sql = "SELECT * FROM users WHERE email = :email AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row; 
    }

    // Forgot Password
    public function forgotPassword($token,$email){
        $sql = "UPDATE users SET token = :token, token_expire = DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['token'=>$token,'email'=>$email]);

        return true;
    }

    // Reset Password

    public function resetPassword($email, $token){
        $sql = "SELECT id FROM users WHERE email = :email AND token = :token AND token != '' AND token_expire > NOW() AND deleted != 0"   ;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email, 'token'=>$token]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // Update new password

    public function updatePassword($pass, $email){
        $sql = "UPDATE users SET token='', password = :pass WHERE email = :email AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['pass'=>$pass,'email'=>$email]);
        return true;
    }

    // Add New Note
    public function addNewNote($uid,$title,$note){
        $sql = "INSERT INTO notes(uid,title,notes) VALUES (:uid, :title, :note)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid, 'title'=>$title, 'note'=>$note]);

        return true;
    }

    // Display All Note

    public function getNotes($uid){
       $sql = "SELECT * FROM notes WHERE uid = :uid";
       $stmt = $this->conn->prepare($sql);
       $stmt->execute(['uid' => $uid]);

       $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

       return $result;
    }

    // Edit Note of an User
    public function editNote($id){
        $sql = "SELECT * FROM notes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    // Update note of an user
    public function updateNote($id,$title,$note){
        $sql = "UPDATE notes SET title = :title, notes= :notes, updated_at = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['title' => $title, 'notes'=>$note, 'id'=>$id]);
        return true;
    }

    // Delete note of an user

    public function deleteNote($id){
        $sql = "DELETE FROM notes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }

    // Update profile for an user
    public function updateProfile($name,$gender,$dob,$phone,$photo,$id){
        $sql = "UPDATE users SET name = :name, gender = :gender, dob = :dob, phone = :phone, photo = :photo WHERE id = :id AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['name'=>$name, 'gender'=>$gender,'dob'=>$dob,'phone'=>$phone,'photo'=>$photo,'id'=>$id]);
        return true;
    }

    // Change Password for an user
    public function chnagePassword($pass,$id){
        $sql = "UPDATE users SET password = :pass WHERE id = :id AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['pass'=>$pass, 'id'=>$id]);
        return true;
    }

    // Verify email of an user

    public function verifyEmail($email){
        $sql = "UPDATE users SET verified = 1 WHERE email = :email AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return true;
    }

    // Send feedback by a user to admin
    public function sendFeedback($subject, $feedback, $id){
        $sql = "INSERT INTO feedback(uid,subject,feedback)VALUES(:uid,:subject, :feedback)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$id,'subject'=>$subject,'feedback'=>$feedback]);
        return true;
    }

    // Insert Notifications

    public function notification($uid,$type,$message){
     $sql = "INSERT INTO notification (uid,type,message) VALUES (:uid, :type, :message)";
     $stmt = $this->conn->prepare($sql);
     $stmt->execute(['uid'=>$uid, 'type'=>$type, 'message'=>$message]);
     return true;
    }

    // Fetch Notifications
    public function fetchNotification($uid){
        $sql = "SELECT * FROM notification WHERE uid = :uid AND type= 'user'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid' => $uid]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    // Remove Notification
    public function removeNotification($id){
        $sql = "DELETE FROM notification WHERE id = :id AND type = 'user'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }

}


?>