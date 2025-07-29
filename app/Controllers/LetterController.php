<?php

namespace App\Controllers;

use App\Models\LetterModel;
use App\Models\UserModel;
use App\Models\UserLogModel;
use App\Models\LocationModel;
use CodeIgniter\Controller;
use TCPDF;  // Add this line at the top along with other imports


class LetterController extends Controller
{
    
    public function store()
{
    $letterModel = new LetterModel();
    $userLogModel = new \App\Models\UserLogModel(); // Load UserLogModel
    $userEmail = session()->get('email');
    $userModel = new UserModel();
    $locationModel = new LocationModel(); // Load the LocationModel
    
    // Fetch user information
    $user = $userModel->where('email', $userEmail)->first();
    $userType = $user['user_type'];  // Assuming the 'user_type' field stores the user role
    $accountStatus = $user['account_status'];  // Check the account status
    $locationId = $user['location_id']; // Assuming the location_id field is in the user table
    
    // Fetch the location name from the locations table using the location_id
    $location = $locationModel->find($locationId); // Get the location details
    
    // If location doesn't exist
    if (!$location) {
        return redirect()->back()->with('error', 'Location not found.');
    }

    // Validate officer type and active status
    if ($userType === 'Officer' && $accountStatus === 'active') {
        if (!$this->request->getPost('letter_in')) {
            return redirect()->back()->with('error', 'You must confirm the letter is in.');
        }
    }
    
    $referenceNumber = mt_rand(10000, 99999);
    
    // Get the letter type from the radio button
    $letterType = $this->request->getPost('letter_type');
    $letterStatus = $letterType === 'Letter In' ? 'Letter In' : 'Added'; // Set the status based on the letter type
    
    $data = [
        'title' => $this->request->getPost('title'),
        'sender_address' => $this->request->getPost('sender_address'),
        'receiver_address' => $this->request->getPost('receiver_address'),
        'reference_number' => $referenceNumber,
        'letter_status' => $letterStatus, // Add the letter status
        'location' => $location['location_name'], // Use the location name from the locations table
    ];
    
    // Insert letter data into the letters table and retrieve the inserted ID
    $letterModel->insert($data);
    $letterId = $letterModel->getInsertID();
    
    // Log user email and letter ID into the user_log table
    $userLogData = [
        'user_email' => $userEmail,
        'letter_id' => $letterId, // Use the retrieved letter ID
        'timestamp' => date('Y-m-d H:i:s'), // Current timestamp
    ];
    $userLogModel->insert($userLogData);
    
    return view('addLetter', [
        'userType' => $userType, // Pass userType to the view
        'accountStatus' => $accountStatus, // Pass accountStatus to the view
        'location' => $location['location_name'], // Pass the location to the view
    ]);
}

    
    public function updateForm()
{
    // Fetch the current session
    $session = session();

    // Check if the user is logged in
    if (!$session->has('email')) {
        return redirect()->to('/login')->with('error', 'Please log in to access this page.');
    }

    // Retrieve user type from session
    $userType = $session->get('user_type');

    // Check if the user is of type 'officer'
    if ($userType === 'officer') {
        // Logic for displaying the update letter form
        return view('updateLetter');
    } else {
        // Redirect non-officer users to a 'not permitted' page
        return view('notPermitted');
    }
}



public function updateLetter()
{
    // Initialize the models
    $letterModel = new LetterModel();
    $userLogModel = new \App\Models\UserLogModel(); // Load UserLogModel
    $locationModel = new LocationModel(); // Load LocationModel to fetch user location

    // Retrieve the reference number and letter type from the form input
    $referenceNumber = $this->request->getPost('reference_number');
    $letterType = $this->request->getPost('letter_type');

    // Validate that the letter exists in the database
    $existingLetter = $letterModel->where('reference_number', $referenceNumber)->first();

    if (!$existingLetter) {
        // Redirect back with an error if the reference number is not found
        return redirect()->back()->with('error', 'Invalid Reference Number. Letter not found.');
    }

    // Fetch the logged-in user's email and location_id
    $userEmail = session()->get('email');
    $userModel = new UserModel();
    $user = $userModel->where('email', $userEmail)->first();
    $locationId = $user['location_id']; // Get the location_id from the user's session or database

    // Fetch the user's location from the locations table using the location_id
    $location = $locationModel->find($locationId);

    // If location is not found, redirect with an error
    if (!$location) {
        return redirect()->back()->with('error', 'User location not found.');
    }

    // Update the letter's status
    $updateData = [
        'letter_status' => $letterType,
        'user_location' => $location['location_name'], // Store the location name in the letter
    ];

    if ($letterType === "Finished") {
        $updateData['completed_at'] = date('Y-m-d H:i:s'); // Save completion timestamp
    }

    if ($letterModel->update($existingLetter['id'], $updateData)) {
        // Insert user activity into the user log
        $userLogData = [
            'user_email' => $userEmail,
            'letter_id' => $existingLetter['id'], // Use the letter ID
            'timestamp' => date('Y-m-d H:i:s'), // Current timestamp
            'location' => $location['location_name'], // Log the user's location
        ];
        $userLogModel->insert($userLogData); // Log the action

        // Redirect back with a success message if the update succeeds
        return redirect()->to('/updateLetter')->with('success', 'Letter status updated successfully.');
    }

    // Redirect back with an error message if the update fails
    return redirect()->back()->with('error', 'Failed to update letter status. Please try again.');
}



    //public function list()
    //{
        // Logic for displaying the letter list
        //return view('letterList');
    //}

    public function list()
{
    // Load the models
    $letterModel = new LetterModel();
    $userLogModel = new \App\Models\UserLogModel(); // Load UserLogModel

    // Fetch the logged-in user's email
    $userEmail = session()->get('email');

    // Fetch letter IDs associated with the user from the user_log table
    $userLogEntries = $userLogModel->where('user_email', $userEmail)->findAll();

    if (empty($userLogEntries)) {
        // No associated letters found, return an empty list
        return view('letterList', [
            'letters' => [],
        ]);
    }

    // Extract letter IDs from the user log entries
    $letterIds = array_column($userLogEntries, 'letter_id');

    // Fetch letters using the extracted IDs and order by ID descending (newest first)
    $letters = $letterModel->whereIn('id', $letterIds)
                           ->orderBy('id', 'DESC')  // Sort by ID descending
                           ->findAll();

    // Pass the letters to the view
    return view('letterList', [
        'letters' => $letters,
    ]);
}

    

public function authlist()
{
    // Check if the user is logged in
    if (!session()->has('email')) {
        return redirect()->to('/login')->with('error', 'Please login to access this page');
    }

    $letterModel = new LetterModel();

    // Get the user's location from the session
    $userLocation = session()->get('location'); // Assuming 'location' is stored in the session

    // Check if a search query is present
    $query = $this->request->getGet('query');
    
    // Retrieve letters based on the user's location
    if (!empty($query)) {
        // Perform a search on the letter's title, sender address, and location
        $letters = $letterModel->like('title', $query)
                               ->orLike('sender_address', $query)
                               ->where('location', $userLocation) // Filter by user's location
                               ->findAll();
    } else {
        // Retrieve all letters for the user's location if no query is provided
        $letters = $letterModel->where('location', $userLocation) // Filter by user's location
                               ->findAll();
    }

    // Pass data to the view
    return view('auth', [
        'letters' => $letters,
        'query' => $query, // Send the search query back to maintain the search field value
    ]);
}

    
    public function search()
{
    // Check if the user is logged in
    if (!session()->has('email')) {
        return redirect()->to('/login')->with('error', 'Please login to access this page');
    }

    $letterModel = new LetterModel();

    // Get the search query
    $query = $this->request->getGet('query');

    // Search for letters based on title or sender_address if a query exists
    if (!empty($query)) {
        $letters = $letterModel->like('title', $query)
                               ->orLike('sender_address', $query)
                               ->findAll();
    } else {
        // If no query, retrieve all letters
        $letters = $letterModel->findAll();
    }

    // Return the view with the search results
    return view('auth', [
        'letters' => $letters,
        'query' => $query,
    ]);
}


public function downloadPdf()
{
    // Load the LetterModel
    $letterModel = new LetterModel();

    // Fetch all letters from the database
    $letters = $letterModel->findAll();  // Fetch all letters from the database

    // If no letters are found, set a default message
    if (empty($letters)) {
        $letters = [
            'No letters found in the database.'
        ];
    }

    // Create a new instance of TCPDF with A4 landscape size
    $pdf = new TCPDF('L', 'mm', 'A4');  // Landscape orientation, millimeters, A4 size

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle("Letter List");

    // Set margins
    $pdf->SetMargins(10, 10, 10);  // Left, top, right margins
    $pdf->SetAutoPageBreak(true, 10);  // Bottom margin

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 10);  // Reduced font size for better fitting

    // Add title
    $pdf->Cell(0, 10, 'Letter Log', 0, 1, 'C');

    // Add a table header with adjusted widths
    $pdf->SetFillColor(200, 200, 200);  // Header background color
    $headerWidths = [35, 50, 75, 75, 40];  // Adjusted column widths to fit within A4 landscape
    $headerTitles = ['Reference Number', 'Title', 'Sender Address', 'Receiver Address'];
    foreach ($headerTitles as $index => $title) {
        $pdf->Cell($headerWidths[$index], 10, $title, 1, 0, 'C', true);
    }
    $pdf->Ln(); // Move to the next line after the header

    // Add each letter to the PDF
    foreach ($letters as $letter) {
        if (is_array($letter)) {
            $pdf->Cell($headerWidths[0], 10, esc($letter['reference_number']), 1, 0, 'C');
            $pdf->Cell($headerWidths[1], 10, esc($letter['title']), 1, 0, 'C');
            $pdf->Cell($headerWidths[2], 10, esc($letter['sender_address']), 1, 0, 'C');
            $pdf->Cell($headerWidths[3], 10, esc($letter['receiver_address']), 1, 0, 'C');
            //$pdf->Cell($headerWidths[4], 10, esc($letter['user']), 1, 0, 'C');
            $pdf->Ln(); // Move to the next line after each letter
        } else {
            // If no letters exist, print a message
            $pdf->Cell(0, 10, $letter, 0, 1, 'C');
        }
    }

    // Output the PDF to the browser for download
    $pdf->Output('letter_list.pdf', 'D');  // 'D' for download
}

  
}
