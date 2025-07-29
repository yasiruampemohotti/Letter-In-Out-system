<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LocationModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function registerForm()
    {
        // Load the registration form view
        return view('register');
    }

    public function register()
    {
        $validationRules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|max_length[100]',
            'password' => 'required|min_length[6]',
        ];
    
        if (!$this->validate($validationRules)) {
            return redirect()->back()->with('error', $this->validator->getErrors());
        }
    
        $userModel = new \App\Models\UserModel();
    
        $dataToInsert = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'account_status' => 'deactivate',  // Default account status
            'user_type' => 'normal',           // Default user type
            'location' => 'none',              // Default location set to 'none'
        ];
    
        if ($userModel->insert($dataToInsert)) {
            return redirect()->to('/login')->with('success', 'Registration successful');
        }
    
        return redirect()->back()->with('error', 'Registration failed');
    }
    


    public function loginForm()
    {
        // Load the login form view
        return view('login');
    }

    public function login()
{
    // Initialize the UserModel
    $userModel = new UserModel();

    // Retrieve email and password from POST data
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // Fetch the user by email
    $user = $userModel->where('email', $email)->first();

    // Check if the account exists, is active, and the password is valid
    if ($user && $user['account_status'] === 'active' && password_verify($password, $user['password'])) {
        // Set session data for the logged-in user
        session()->set([
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'user_type' => $user['user_type'], // Add user_type to session
            'isLoggedIn' => true,
        ]);

        // Redirect based on user_type
        if ($user['user_type'] === 'auth') {
            return redirect()->to('auth'); // Redirect to auth.php for 'auth' users
        }
        if ($user['user_type'] === 'admin') {
            return redirect()->to('/admin'); // Redirect to auth.php for 'auth' users
        }
        // Redirect to default homepage for other users
        return redirect()->to('/dashboard');
    }

    // Redirect back with an error message on failure
    return redirect()->back()->with('error', 'Invalid login credentials or inactive account');
}

    public function logout()
    {
        // Destroy the session
        session()->destroy();

        // Redirect to the login page with a success message
        return redirect()->to('/login')->with('success', 'Logged out successfully');
    }


    public function addLetter()
{
    // Assuming you're getting the user type from session or authentication
    $userType = session()->get('user_type');  // Example: 'normal' or 'admin'

    return view('addLetter', ['userType' => $userType]);
}


public function userlist()
{
    // Check if the user is logged in
    if (!session()->has('email')) {
        return redirect()->to('/login')->with('error', 'Please login to access this page');
    }

    $userModel = new UserModel();

    // Retrieve all users along with their location names
    $users = $userModel->select('users.*, locations.location_name')
                       ->join('locations', 'users.location_id = locations.id', 'left') // Left join to include users without locations
                       ->findAll();

    // Pass data to the view
    return view('admin', [
        'users' => $users,
    ]);
}


public function editUserForm($id)
{
    $userModel = new UserModel();
    $locationModel = new LocationModel(); // Assuming you have a LocationModel

    // Fetch the user by ID
    $user = $userModel->find($id);
    if (!$user) {
        return redirect()->to('/admin')->with('error', 'User not found');
    }

    // Fetch all locations for the select dropdown
    $locations = $locationModel->findAll();

    // Pass the user and locations to the view
    return view('action', [
        'user' => $user,
        'locations' => $locations
    ]);
}


public function updateUser($id)
{
    $validationRules = [
        'user_type' => 'required|in_list[normal,admin,auth,officer]',
        'account_status' => 'required|in_list[active,deactivate]',
        'location_id' => 'required|integer', // Assuming location_id is a foreign key from the locations table
    ];

    if (!$this->validate($validationRules)) {
        return redirect()->back()->with('error', $this->validator->getErrors());
    }

    $userModel = new UserModel();
    $locationModel = new LocationModel(); // Create the model for locations table

    // Retrieve the location ID from the post data
    $locationId = $this->request->getPost('location_id');

    // Fetch location details from the locations table using the location ID
    $location = $locationModel->find($locationId);

    if (!$location) {
        return redirect()->back()->with('error', 'Invalid location ID');
    }

    // Prepare updated data
    $updatedData = [
        'user_type' => $this->request->getPost('user_type'),
        'account_status' => $this->request->getPost('account_status'),
        'location_id' => $locationId, // Update with the location_id, not the location name
    ];

    if ($userModel->update($id, $updatedData)) {
        return redirect()->to('/admin')->with('success', 'User updated successfully');
    }

    return redirect()->back()->with('error', 'Failed to update user');
}

public function aboutUs()
{
    return view('aboutUs');
}

public function loadDashboard()
{
    $session = session();

    // Check if the user is logged in
    if (!$session->has('email')) {
        return redirect()->to('/login')->with('error', 'Please log in to access this page.');
    }

    // Retrieve user details from session
    $userName = $session->get('username');
    $location = $session->get('location');
    $userType = $session->get('user_type');
    $userEmail = $session->get('email'); // Get the logged-in user's email

    // Load the letter model and user log model
    $letterModel = new \App\Models\LetterModel();
    $userLogModel = new \App\Models\UserLogModel(); // Load UserLogModel

    // Fetch letter IDs associated with the user from the user_log table
    $userLogEntries = $userLogModel->where('user_email', $userEmail)->findAll();

    if (empty($userLogEntries)) {
        // No associated letters found, return an empty list
        return view('dashboard', [
            'username' => $userName,
            'location' => $location,
            'user_type' => $userType,
            'letters' => [],
            'letter_counts' => [],
            'filter' => null
        ]);
    }

    // Extract letter IDs from the user log entries
    $letterIds = array_column($userLogEntries, 'letter_id');

    // Get the selected filter from GET request
    $filter = $this->request->getGet('filter');

    // Query for recent letters associated with the user
    $query = $letterModel->whereIn('id', $letterIds)->orderBy('created_at', 'DESC');

    // Apply filtering based on selected option
    if ($filter === 'today') {
        $query->where('DATE(created_at)', date('Y-m-d'));
    } elseif ($filter === 'last7days') {
        $query->where('created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')));
    } elseif ($filter === 'thismonth') {
        $query->where('MONTH(created_at)', date('m'))
              ->where('YEAR(created_at)', date('Y'));
    }

    // Fetch the filtered letters
    $letters = $query->findAll();

    // Extract letter statuses and count occurrences
    $letterStatuses = array_column($letters, 'letter_status');
    $letterCounts = array_count_values($letterStatuses);

    // Load the dashboard view with data
    return view('dashboard', [
        'username' => $userName,
        'location' => $location,
        'user_type' => $userType,
        'letters' => $letters,
        'letter_counts' => $letterCounts,
        'filter' => $filter
    ]);
}


public function add() {
    return view('add_location');
}


public function addLocation() {
    $locationModel = new LocationModel();
    $locationModel->insert([
        'location_name' => $this->request->getPost('location_name')
    ]);
    return redirect()->to('/admin')->with('success', 'Location added successfully.');
}


}
