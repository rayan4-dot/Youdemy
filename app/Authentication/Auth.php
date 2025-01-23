 <?php


require_once __DIR__ . '/AuthBase.php';

class Auth extends AuthBase
{
    public function login($email, $password)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password_hash'])) {
    
                if ($user['status'] === 'suspended') {

                    header("Location: ../Student/suspended.php");
                    exit;
                }
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                // var_dump($_SESSION); die;
                if ($_SESSION['role'] === 'student') {
                    header("Location: ../Student/student.php");
                } elseif ($_SESSION['role'] === 'teacher') {
                    if ($user['status'] === 'pending') {
                        header("Location: ../Teacher/awaitingApproval.php");
                        exit();
                    } else {
                        header("Location: ../Teacher/teacher.php");
                        exit();
                    } 
                } elseif ($_SESSION['role']=== 'admin') {
                    // var_dump("helooo"); die;
                    header("Location: ../Admin/dashboard.php");
                    exit;
                }
                exit;
            } else {
                throw new Exception("Invalid credentials");
            }
        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    public function register($username, $email, $password, $role = 'student', $profile_picture_url = null)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                throw new Exception("Email already in use.");
            }
    
            $status = ($role === 'teacher') ? 'pending' : 'active';
    
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);


            if ($profile_picture_url) {
                $sql = "INSERT INTO users (username, email, password_hash, role, status, profile_picture_url) 
                        VALUES (:username, :email, :password_hash, :role, :status, :profile_picture_url)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':profile_picture_url', $profile_picture_url);
            } 
    
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $passwordHash);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
