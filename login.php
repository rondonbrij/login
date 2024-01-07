<?php
// Start the session
session_start();

interface UserRepositoryInterface
{
    public function getUserByUsername($username);
}

class UserRepository implements UserRepositoryInterface
{
    public function getUserByUsername($username)
    {
        // Connect to the database and fetch user by username
        // Return the user data or null if not found
        // Database connection details
        $host = 'localhost';
        $port = 3306;
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName = 'cse1';

        // Create a new PDO instance
        $dsn = "mysql:host=$host;port=$port;dbname=$dbName;charset=utf8mb4";
        $pdo = new PDO($dsn, $dbUsername, $dbPassword);

        // Prepare the SQL statement
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);

        // Bind the parameter and execute the query
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the user data or null if not found
        return $user ? $user : null;
    }
}

interface AuthenticationServiceInterface
{
    public function authenticate($username, $password);
}

class AuthenticationService implements AuthenticationServiceInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // Caesar cipher function
    private function caesarCipher($string, $shift)
    {
        $output = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            if (ctype_alpha($char)) {
                $ascii = ord(ctype_upper($char) ? 'A' : 'a');
                $output .= chr(fmod((ord($char) + $shift - $ascii), 26) + $ascii);
            } else {
                $output .= $char;
            }
        }
        return $output;
    }

    public function authenticate($username, $password)
    {
        $user = $this->userRepository->getUserByUsername($username);

        // Apply Caesar cipher to the password with a shift of 3
        $cipheredPassword = $this->caesarCipher($password, 3);

        // Then apply MD5 hash
        $hashedPassword = md5($cipheredPassword);

        if ($user && $user['password'] === $hashedPassword) {
            return true;
        }

        return false;
    }
}

class LoginController
{
    private $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function login($username, $password)
    {
        if ($this->authenticationService->authenticate($username, $password)) {
            // Set a session variable to remember the user's login status
            $_SESSION['loggedin'] = true;

            // Redirect to the successful login page
            header("Location: success.php");
            exit();
        } else {
            // Redirect back to the login page with an error message
            header("Location: index.php?error=true");
            exit();
        }
    }
}

// Usage example
$userRepository = new UserRepository();
$authenticationService = new AuthenticationService($userRepository);
$loginController = new LoginController($authenticationService);

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginController->login($username, $password);
}
?>