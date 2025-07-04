<?php
require_once("Model.php");

class user extends Model{

    private int $id; 
    private string $fullname; 
    private string $email; 
    private string $mobile_number; 
    private string $password; 
    private string $date_of_birth; 
    private string $communication_prefs; 
    private string $membership_level;
    private string $created_at; 
    private int $age_verified; 
    
    protected static string $table = "users";

    public function __construct(array $data){
        $this->id = $data["id"] ?? 0;
        $this->fullname = $data["fullname"] ?? '';
        $this->email = $data["email"] ?? '';
        $this->mobile_number = $data["mobile_number"] ?? '';
        $this->password = $data["password"] ?? '';
        $this->date_of_birth = $data["date_of_birth"] ?? '';
        $this->communication_prefs = $data["communication_prefs"] ?? '';
        $this->membership_level = $data["membership_level"] ?? '';
        $this->created_at = $data["created_at"] ?? '';
        $this->age_verified = $data["age_verified"] ?? 0;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getFullname(): string {
        return $this->fullname;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getMobileNumber(): string {
        return $this->mobile_number;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getDateOfBirth(): string {
        return $this->date_of_birth;
    }

    public function getCommunicationPrefs(): string {
        return $this->communication_prefs;
    }

    public function getMembershipLevel(): string {
        return $this->membership_level;
    }

    public function getCreatedAt(): string {
        return $this->created_at;
    }

    public function getAgeVerified(): int {
        return $this->age_verified;
    }

    public function setFullname(string $fullname){
        $this->fullname = $fullname;
    }

    public function setEmail(string $email){
        $this->email = $email;
    }

    public function setMobileNumber(string $mobile_number){
        $this->mobile_number = $mobile_number;
    }

    public function setPassword(string $password){
        $this->password = $password;
    }

    public function setDateOfBirth(string $date_of_birth){
        $this->date_of_birth = $date_of_birth;
    }

    public function setCommunicationPrefs(string $communication_prefs){
        $this->communication_prefs = $communication_prefs;
    }

    public function setMembershipLevel(string $membership_level){
        $this->membership_level = $membership_level;
    }

    public function toArray(){
        return [
            $this->id,
            $this->fullname,
            $this->email,
            $this->mobile_number,
            $this->password,
            $this->date_of_birth,
            $this->communication_prefs,
            $this->membership_level,
            $this->created_at,
            $this->age_verified
        ];
    }

    public static function findByEmail(mysqli $mysqli, string $email) {
        $sql = sprintf("SELECT * FROM %s WHERE email = ?", static::$table);
        
        $query = $mysqli->prepare($sql);
        $query->bind_param("s", $email);  
        $query->execute();
    
        $data = $query->get_result()->fetch_assoc();
    
        return $data ? new static($data) : null;
    }

    public function verifyPassword(string $providedPassword): bool {
        $hashedPasswordFromDb = $this->password;
        return password_verify($providedPassword, $hashedPasswordFromDb);
    }


    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }

 
    public static function delete(mysqli $mysqli, int $id): bool
    {
        $sql = sprintf("DELETE FROM %s WHERE %s = ?", static::$table, static::$primary_key);
        
        $query = $mysqli->prepare($sql);
        if ($query === false) {
            error_log("Failed to prepare delete statement: " . $mysqli->error);
            return false;
        }

        $query->bind_param("i", $id);
        
        $executeResult = $query->execute();
        
        if ($executeResult === false) {
            error_log("Failed to execute delete statement: " . $query->error);
        }

        $rowsAffected = $query->affected_rows;
        $query->close();

        return $rowsAffected > 0;
    }

  
    }






    

