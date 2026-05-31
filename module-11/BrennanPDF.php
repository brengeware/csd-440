<?php
/**
 * BrennanPDF.php
 * CSD440 - Final Project
 * Date: 5/31/2026
 * Connects to the baseball_01 db, queries all records
 * from the movies table, and generates a PDF displaying general
 * information about the topic along with the data in a formatted
 * table with a head and footer.
 */

// Include the FPDF library
require('fpdf.php');

// DB connection

$host = "localhost";
$user = "root";
$password = "";
$database = "baseball_01";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to get all records from the movies table ordered by rating descending
$sql = "SELECT * FROM movies ORDER BY rating DESC";
$result = mysqli_query($conn, $sql);

//check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

//fetch all rows into an array so we can close the connection before building the PDF
$movies = [];
while ($row = mysqli_fetch_assoc($result)) {
    $movies[] = $row;
}

//close the db connection
mysqli_close($conn);

// Create a custom PDF class that extends FPDF to add header and footer

class BrennanPDF extends FPDF
{
 //Header
 function Header()
 {
    //title bar background
    $this->SetFillColor(30,30,30);
    $this->Rect(0,0,210,18, 'F');

    //title text
    $this->SetFont('Helvetica','B',14);
    $this->SetTextColor(255,255,255);
    $this->Cell(0,10,'Brennan\'s Movie DB',0,1,'C');

    //reset text color for table header & add spacing
    $this->SetTextColor(0,0,0);
    $this->Ln(4);
 }   

 //footer
 function Footer()
 {
    //position 15mm from bottom
    $this->setY(-15);
    $this->SetFont('Helvetica','I',8);
    $this->SetTextColor(120,120,120);

    $this->Cell(0,10, 'Generated: ' . date('F j, Y'), 0, 0, 'L');

    //right side page number
    $this->Cell(0,10,'Page ' . $this->PageNo(), 0, 0, 'R');

 }
}

//BUILD THE PDF

$pdf = new BrennanPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);

//General info section

$pdf->SetFont('Helvetica','B',13);
$pdf->SetTextColor(30,30,30);
$pdf->Cell(0,8, 'About This Report', 0, 1);

$pdf->SetFont('Helvetica','',11);
$pdf->SetTextColor(60,60,60);
$pdf->MultiCell(0,6, "This report pulls data from the movies table stored in the baseball_01 " .
"MySQL Database. The table tracks a personal movie watchlist containing " .
"titles across several genres including comedy, drama, sci-fi, thriller " .
"and crime. Each record stores the movie's title, genre, release year, " .
"IMDb-style rating out of 10, and whether or not the movie has been watched. " .
"Records are ordered by rating from highest to lowest.",
0, 'L');

$pdf->Ln(5);

//table width columns

$colWidths = [12, 62, 28, 28, 26, 24];

//table header row

$pdf->SetFont('Helvetica', 'B', '9');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(30,30,30);
$pdf->SetDrawColor(200,200,200);
$pdf->SetLineWidth(0.3);

$headers = ['ID', 'Title', 'Genre', 'Release Year', 'Rating', 'Watched'];

foreach ($headers as $i => $header) {
    $pdf->Cell($colWidths[$i], 8, $header, 1, 0, 'C', true);
}
$pdf->Ln();

//table data rows

$pdf->SetFont('Helvetica', '', 9);
$pdf->SetFillColor(30, 30, 30);

$fillRow = false; //alternating row shading flag

foreach ($movies as $row) {
    if ($fillRow) {
        $pdf->SetFillColor(240, 240, 240);
    } else {
        $pdf->SetFillColor(255, 255, 255);
    }

    $watched = ($row['watched'] == 1) ? 'Yes' : 'No';

    $pdf->Cell($colWidths[0], 7, $row['movie_id'], 1, 0, 'C', true);
    $pdf->Cell($colWidths[1], 7, $row['title'], 1, 0, 'L', true);
    $pdf->Cell($colWidths[2], 7, $row['genre'], 1, 0, 'C', true);
    $pdf->Cell($colWidths[3], 7, $row['release_year'], 1, 0, 'C', true);
    $pdf->Cell($colWidths[4], 7, number_format($row['rating'], 1), 1, 0, 'C', true);
    $pdf->Cell($colWidths[5], 7, $watched, 1, 0, 'C', true);
    $pdf->Ln();

    $fillRow = !$fillRow; //toggle row shading
}

//table footer row

$pdf->SetFont('Helvetica', 'B', 9);
$pdf->SetFillColor(30,30,30);
$pdf->SetTextColor(255,255,255);

$totalMovies = count($movies);
$watchedCount = count(array_filter($movies, fn($m) => $m['watched'] == 1));
$avgRating = $totalMovies > 0
    ? number_format(array_sum(array_column($movies, 'rating')) / $totalMovies, 1) : 'N/A';


$pdf->Cell($colWidths[0] + $colWidths[1], 7, 'Totals / Averages', 1, 0, 'L', true);
$pdf->Cell($colWidths[2], 7, 'Movies: ' . $totalMovies, 1, 0, 'C', true);
$pdf->Cell($colWidths[3], 7, 'Watched: ' . $watchedCount, 1, 0, 'C', true);
$pdf->Cell($colWidths[4], 7, 'Avg Rating: ' . $avgRating, 1, 0, 'C', true);
$pdf->Cell($colWidths[5], 7, '', 1, 0, 'C', true);
$pdf->Ln();

//output the PDF to the browser
$pdf->Output('I', 'BrennanMovies.pdf');
?>