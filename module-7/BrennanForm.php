<?php
// ============================================================
//  Brennan Cheatwood
//  CSD440 - Assignment 7.2 - PHP Portion
//  5/3/26
//
//  BrennanForm.php
//  Validates form input from BrennanForm.html and displays
//  a confirmation page or a detailed error report.
// ============================================================

// ---------- 1. Collect & sanitize ----------

$full_name       = trim($_POST['full_name']       ?? '');
$email           = trim($_POST['email']           ?? '');
$age_raw         = trim($_POST['age']             ?? '');
$gpa_raw         = trim($_POST['gpa']             ?? '');
$enrollment_date = trim($_POST['enrollment_date'] ?? '');
$enrolled        = trim($_POST['enrolled']        ?? '');
$major           = trim($_POST['major']           ?? '');

// ---------- 2. Validation ----------

$errors = [];

// Field 1 — Full Name (text)
if ($full_name === '') {
    $errors[] = 'Full Name is required.';
} elseif (!preg_match("/^[a-zA-Z\s'\-]{2,80}$/", $full_name)) {
    $errors[] = 'Full Name may only contain letters, spaces, hyphens, or apostrophes (2–80 characters).';
}

// Field 2 — Email
if ($email === '') {
    $errors[] = 'Email Address is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "\"" . htmlspecialchars($email) . "\" is not a valid email address.";
}

// Field 3 — Age (integer, 1–120)
if ($age_raw === '') {
    $errors[] = 'Age is required.';
} elseif (!ctype_digit($age_raw) || (int)$age_raw < 1 || (int)$age_raw > 120) {
    $errors[] = 'Age must be a whole number between 1 and 120.';
} else {
    $age = (int)$age_raw;
}

// Field 4 — GPA (float, 0.00–4.00)
if ($gpa_raw === '') {
    $errors[] = 'GPA is required.';
} elseif (!is_numeric($gpa_raw) || (float)$gpa_raw < 0 || (float)$gpa_raw > 4.0) {
    $errors[] = 'GPA must be a number between 0.00 and 4.00.';
} else {
    $gpa = number_format((float)$gpa_raw, 2);
}

// Field 5 — Enrollment Date (valid past/present date)
if ($enrollment_date === '') {
    $errors[] = 'Enrollment Date is required.';
} else {
    $date_obj = DateTime::createFromFormat('Y-m-d', $enrollment_date);
    $today    = new DateTime('today');
    if (!$date_obj || $date_obj->format('Y-m-d') !== $enrollment_date) {
        $errors[] = 'Enrollment Date is not a valid date.';
    } elseif ($date_obj > $today) {
        $errors[] = 'Enrollment Date cannot be in the future.';
    } else {
        $display_date = $date_obj->format('F j, Y');
    }
}

// Field 6 — Enrolled (boolean radio)
if ($enrolled === '') {
    $errors[] = 'Please indicate whether you are currently enrolled.';
} elseif ($enrolled !== 'yes' && $enrolled !== 'no') {
    $errors[] = 'Invalid enrollment status.';
} else {
    $enrolled_display = ($enrolled === 'yes') ? 'Yes — Full-time' : 'No / Part-time';
    $enrolled_bool    = ($enrolled === 'yes');
}

// Field 7 — Major (string, whitelist)
$allowed_majors = [
    'Computer Science', 'Information Technology',
    'Business Administration', 'Mathematics', 'Engineering', 'Other'
];
if ($major === '') {
    $errors[] = 'Major / Program is required.';
} elseif (!in_array($major, $allowed_majors, true)) {
    $errors[] = 'Please select a valid Major from the list.';
}

// ---------- 3. Shared page shell ----------

function html_open(string $title): void { ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($title) ?></title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg:       #141416;
      --surface:  #1e1e22;
      --surface2: #26262c;
      --border:   #333338;
      --ink:      #e8e8ec;
      --muted:    #888896;
      --accent:   #7b8cde;
      --danger:   #e0635a;
      --success:  #5abf8a;
    }
    body {
      background: var(--bg);
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-weight: 300;
      color: var(--ink);
      min-height: 100vh;
      display: flex; align-items: center; justify-content: center;
      padding: 2.5rem 1rem;
    }
    .card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 6px;
      max-width: 580px; width: 100%;
      padding: 2.8rem 3rem;
    }
    .eyebrow {
      font-size: 0.68rem; font-weight: 500; letter-spacing: 0.14em;
      text-transform: uppercase; margin-bottom: 0.5rem;
    }
    .eyebrow.ok  { color: var(--success); }
    .eyebrow.err { color: var(--danger); }
    h1 { font-size: 1.65rem; font-weight: 300; letter-spacing: -0.02em; margin-bottom: 1.8rem; }
    /* ---- Success table ---- */
    table { width: 100%; border-collapse: collapse; }
    tr { border-bottom: 1px solid var(--border); }
    tr:last-child { border-bottom: none; }
    td { padding: 0.85rem 0; vertical-align: middle; font-size: 0.92rem; }
    td:first-child {
      width: 40%; font-size: 0.7rem; font-weight: 500; letter-spacing: 0.09em;
      text-transform: uppercase; color: var(--muted); padding-right: 1rem;
    }
    td:last-child { color: var(--ink); }
    .tag {
      display: inline-block; font-size: 0.6rem; background: var(--surface2);
      color: #666678; border: 1px solid var(--border);
      padding: 1px 5px; border-radius: 3px; margin-left: 5px;
      letter-spacing: 0.04em; font-weight: 400; vertical-align: middle;
    }
    .pill-yes {
      display: inline-block; background: rgba(90,191,138,0.15);
      color: var(--success); border: 1px solid rgba(90,191,138,0.3);
      border-radius: 20px; padding: 2px 10px; font-size: 0.82rem;
    }
    .pill-no {
      display: inline-block; background: var(--surface2);
      color: var(--muted); border: 1px solid var(--border);
      border-radius: 20px; padding: 2px 10px; font-size: 0.82rem;
    }
    /* ---- Error list ---- */
    .err-box {
      background: rgba(224,99,90,0.08);
      border: 1px solid rgba(224,99,90,0.25);
      border-radius: 5px; padding: 1.1rem 1.3rem; margin-bottom: 1.8rem;
    }
    .err-box p { font-size: 0.82rem; color: var(--danger); margin-bottom: 0.7rem; font-weight: 500; }
    .err-box ul { list-style: none; padding: 0; }
    .err-box li {
      font-size: 0.88rem; color: #cc8a87; padding: 0.3rem 0;
      border-bottom: 1px solid rgba(224,99,90,0.12);
      display: flex; align-items: flex-start; gap: 0.5rem;
    }
    .err-box li:last-child { border-bottom: none; }
    .err-box li::before { content: '—'; color: var(--danger); flex-shrink: 0; }
    /* ---- Back link ---- */
    .back {
      display: inline-block; margin-top: 2rem;
      font-size: 0.75rem; letter-spacing: 0.09em; text-transform: uppercase;
      color: var(--accent); text-decoration: none;
    }
    .back:hover { color: #a0aeee; }
  </style>
</head>
<body><div class="card">
<?php }

function html_close(): void { ?>
</div></body></html>
<?php }

// ---------- 4a. Error page ----------

if (!empty($errors)) {
    html_open('Submission Error'); ?>
    <p class="eyebrow err">Registration — Error</p>
    <h1>Let's fix a few things.</h1>
    <div class="err-box">
      <p><?= count($errors) ?> issue<?= count($errors) > 1 ? 's' : '' ?> found</p>
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <a href="BrennanForm.html" class="back">← Back to the form</a>
<?php html_close();
    exit;
}

// ---------- 4b. Success page ----------

html_open('Registration Confirmed'); ?>
    <p class="eyebrow ok">Registration — Confirmed</p>
    <h1>You're all set.</h1>

    <table>
      <tr>
        <td>Full Name <span class="tag">text</span></td>
        <td><?= htmlspecialchars($full_name) ?></td>
      </tr>
      <tr>
        <td>Email <span class="tag">email</span></td>
        <td><?= htmlspecialchars($email) ?></td>
      </tr>
      <tr>
        <td>Age <span class="tag">integer</span></td>
        <td><?= htmlspecialchars((string)$age) ?></td>
      </tr>
      <tr>
        <td>GPA <span class="tag">float</span></td>
        <td><?= htmlspecialchars($gpa) ?> <span style="color:var(--muted);font-size:.82rem">/ 4.00</span></td>
      </tr>
      <tr>
        <td>Enrollment Date <span class="tag">date</span></td>
        <td><?= htmlspecialchars($display_date) ?></td>
      </tr>
      <tr>
        <td>Enrolled <span class="tag">boolean</span></td>
        <td>
          <?php if ($enrolled_bool): ?>
            <span class="pill-yes"><?= htmlspecialchars($enrolled_display) ?></span>
          <?php else: ?>
            <span class="pill-no"><?= htmlspecialchars($enrolled_display) ?></span>
          <?php endif; ?>
        </td>
      </tr>
      <tr>
        <td>Major <span class="tag">string</span></td>
        <td><?= htmlspecialchars($major) ?></td>
      </tr>
    </table>

    <a href="BrennanForm.html" class="back">← Submit another response</a>
<?php html_close(); ?>