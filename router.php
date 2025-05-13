<?php

// --- Security Headers ---
// header('X-Content-Type-Options: nosniff');                      // Prevent MIME sniffing
// header('X-Frame-Options: DENY');                                // Prevent clickjacking
// header('X-XSS-Protection: 1; mode=block');                      // Basic XSS protection (legacy)
// header('Referrer-Policy: no-referrer');                         // Hide referrer info
// header('Permissions-Policy: geolocation=(), microphone=()');    // Limit browser features
// header('Strict-Transport-Security: max-age=63072000; includeSubDomains; preload'); // Force HTTPS
// header('Cache-Control: no-store, no-cache, must-revalidate');   // Prevent caching
// header('Pragma: no-cache');
header_remove('X-Powered-By');                                  // Remove "X-Powered-By: PHP"

// API route
$requestUri = $_SERVER['REQUEST_URI'];

if (str_starts_with($requestUri, '/api/todos')) {
    header('Content-Type: application/json');

    // Pagination parameters
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $limit = 10; // Number of todos per page

    $todos = [
        ['id' => 1, 'title' => 'Buy milk', 'completed' => false, 'description' => 'Go to the store and buy milk.', 'date' => '2025-05-15'],
        ['id' => 2, 'title' => 'Clean room', 'completed' => true, 'description' => 'Vacuum the floor and tidy up the desk.', 'date' => '2025-05-16'],
        ['id' => 3, 'title' => 'Do laundry', 'completed' => false, 'description' => 'Wash clothes and fold them afterward.', 'date' => '2025-05-17'],
        ['id' => 4, 'title' => 'Write code', 'completed' => true, 'description' => 'Finish writing the feature for the app.', 'date' => '2025-05-18'],
        ['id' => 5, 'title' => 'Call mom', 'completed' => false, 'description' => 'Catch up with mom on the phone.', 'date' => '2025-05-19'],
        ['id' => 6, 'title' => 'Read a book', 'completed' => true, 'description' => 'Read at least two chapters of the new book.', 'date' => '2025-05-20'],
        ['id' => 7, 'title' => 'Exercise', 'completed' => false, 'description' => 'Go for a jog in the morning.', 'date' => '2025-05-21'],
        ['id' => 8, 'title' => 'Buy groceries', 'completed' => true, 'description' => 'Pick up groceries for the week.', 'date' => '2025-05-22'],
        ['id' => 9, 'title' => 'Watch movie', 'completed' => false, 'description' => 'Watch a movie in the evening to relax.', 'date' => '2025-05-23'],
        ['id' => 10, 'title' => 'Cook dinner', 'completed' => true, 'description' => 'Prepare a healthy dinner.', 'date' => '2025-05-24'],
        ['id' => 11, 'title' => 'Meet friends', 'completed' => false, 'description' => 'Hang out with friends at the park.', 'date' => '2025-05-25'],
        ['id' => 12, 'title' => 'Go shopping', 'completed' => true, 'description' => 'Buy clothes and some accessories.', 'date' => '2025-05-26'],
        ['id' => 13, 'title' => 'Learn a new skill', 'completed' => false, 'description' => 'Take an online course on Python.', 'date' => '2025-05-27'],
        ['id' => 14, 'title' => 'Meditate', 'completed' => true, 'description' => 'Meditate for at least 15 minutes.', 'date' => '2025-05-28'],
        ['id' => 15, 'title' => 'Clean the kitchen', 'completed' => false, 'description' => 'Wash dishes and wipe down counters.', 'date' => '2025-05-29'],
        ['id' => 16, 'title' => 'Organize closet', 'completed' => true, 'description' => 'Sort clothes and organize the closet.', 'date' => '2025-05-30'],
        ['id' => 17, 'title' => 'Write journal', 'completed' => false, 'description' => 'Write down thoughts in the journal.', 'date' => '2025-05-31'],
        ['id' => 18, 'title' => 'Plan trip', 'completed' => true, 'description' => 'Start planning a vacation to the beach.', 'date' => '2025-06-01'],
        ['id' => 19, 'title' => 'Call plumber', 'completed' => false, 'description' => 'Call plumber for a check-up on the sink.', 'date' => '2025-06-02'],
        ['id' => 20, 'title' => 'Fix the leak', 'completed' => true, 'description' => 'Fix the leak in the roof before the rainy season.', 'date' => '2025-06-03'],
        ['id' => 21, 'title' => 'Update resume', 'completed' => false, 'description' => 'Update the resume with new skills and experience.', 'date' => '2025-06-04'],
        ['id' => 22, 'title' => 'Bake cookies', 'completed' => true, 'description' => 'Bake chocolate chip cookies for the family.', 'date' => '2025-06-05'],
        ['id' => 23, 'title' => 'Wash car', 'completed' => false, 'description' => 'Wash the car and clean the interior.', 'date' => '2025-06-06'],
        ['id' => 24, 'title' => 'Take out trash', 'completed' => true, 'description' => 'Take out the trash before pickup.', 'date' => '2025-06-07'],
        ['id' => 25, 'title' => 'Check emails', 'completed' => false, 'description' => 'Sort through and reply to important emails.', 'date' => '2025-06-08'],
        ['id' => 26, 'title' => 'Go to gym', 'completed' => true, 'description' => 'Lift weights at the gym for an hour.', 'date' => '2025-06-09'],
        ['id' => 27, 'title' => 'Attend meeting', 'completed' => false, 'description' => 'Attend the weekly team meeting.', 'date' => '2025-06-10'],
        ['id' => 28, 'title' => 'Pay bills', 'completed' => true, 'description' => 'Pay the monthly utility bills.', 'date' => '2025-06-11'],
        ['id' => 29, 'title' => 'Prepare lunch', 'completed' => false, 'description' => 'Prepare a healthy lunch for the day.', 'date' => '2025-06-12'],
        ['id' => 30, 'title' => 'Relax at home', 'completed' => true, 'description' => 'Take a day off to relax and recharge.', 'date' => '2025-06-13'],
    ];


    // Calculate the starting index based on the current page
    $start = ($page - 1) * $limit;

    // Slice the todos array to return only the todos for the current page
    $pagedTodos = array_slice($todos, $start, $limit);

    // Calculate total pages
    $totalPages = ceil(count($todos) / $limit);

    // Response data
    echo json_encode([
        'todos' => $pagedTodos,
        'pagination' => [
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]
    ]);
    exit;
}

// Serve static files
$filePath = __DIR__ . parse_url($requestUri, PHP_URL_PATH);
if (file_exists($filePath) && !is_dir($filePath)) {
    return false; // Let web server serve static files
}

// SPA fallback
readfile(__DIR__ . '/index.html');
