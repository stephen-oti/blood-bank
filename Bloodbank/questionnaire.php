
<?php
// Include the FPDF library
require('../FPDF/fpdf.php');
include '../dbconfig.php';

if(isset($_GET['action'])){
// Get the donor ID from the AJAX request
$question = $_GET['question'];

$today = new DateTime();

// Create a new PDF document
$pdf = new FPDF();

// Add a new page
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
    
$logo = "../dist/img/Obbs logo.png";
$stamp = "../dist/img/stamp.png";
$pdf->Image($logo, 90, $pdf->GetY()+1 ,30);
$pdf->Ln(32);
$pdf->SetFont('Times','B',15);
$pdf->cell(200,5,'ONLINE BLOOD BANK SYSTEM',0,1,'C');
$pdf->SetFont('Times', 'i', 14); // set font for subtitle
$pdf->Cell(0, 10, 'Donate Life-Save Lives: Give Blood at Your Local Blood Bank!', 0, 1, 'C'); // subtitle
$pdf->Ln(5);
if( $_GET['action'] == 'patient-questionnaire'){

$sql = "   SELECT questionnaire.id, last_update_time, p_id, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10,
            patient.`fname`, patient.`lname`, patient.`email`, patient.`address`, patient.`county`, patient.`phone`
            FROM questionnaire 
            JOIN patient ON patient.`id` = questionnaire.`p_id`
            WHERE p_id IS NOT NULL AND questionnaire.id = ?;";
// Prepare a select statement
 $stmt = mysqli_prepare($conn, $sql);
 mysqli_stmt_bind_param($stmt, 'i', $question);
 mysqli_stmt_execute($stmt);
 $results = mysqli_stmt_get_result($stmt);
 if ($rows = mysqli_fetch_assoc($results)) {
   $question = $rows;
 }

 // Bind the result variables
//  mysqli_stmt_bind_result($stmt, $qid, $update_time, $patient, $q1, $q2, $q3,$q4, $q5, $q6, $q7, $q8, $q9, $q10, $patient_fname, $patient_lname, $patient_mail, $patient_addr);


$pdf->SetFont('Times', 'B', 12);

// Set font and font size
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20, 10, "Patient:", 0, 0, 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40, 10, strtoupper($question['fname']." ".$question['lname']), 0, 0);
$pdf->Cell(100, 10, "Last Updated On:", 0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(20, 10, $question['last_update_time'] , 0, 1,'R');

$pdf->SetFont('Times','B',9);
$pdf->Cell(20, 5, "Address: ". $question['address'], 0, 0, 'L');
$pdf->Cell(160, 5, "Mail: ". $question['email'], 0, 1, 'R');
$pdf->Cell(20, 5, "County: ". $question['county'], 0, 0, 'L');
$pdf->Cell(160, 5, "Phone:  ". $question['phone'], 0, 1, 'R');

$pdf->Ln(1.5);


$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 10, 'PATIENT Questionnaire Form', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','BU',10);

// Add table headers to the PDF
$pdf->Cell(20, 10, "S/No.", 0, 0, 'L');
$pdf->Cell(40, 10, "QUESTION", 0, 0, 'L');
$pdf->Cell(0, 10, "RESPONSE" , 0, 1,'R');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(20, 10, "1", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you received a blood transfusion before?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($question['q1']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "2", 0, 0, 'L');
$pdf->Cell(20, 10, "Do you know your blood type and have you been tested for any bloodborne diseases?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($question['q2']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "3", 0, 0, 'L');
$pdf->Cell(20, 10, "Do you have any allergies, especially to medications or blood products?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($question['q3']), 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "4", 0, 0, 'L');
$pdf->Cell(20, 10, "Are you under any medication Or that  which may affect your blood clotting or blood count?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($question['q4']), 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "5", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you been through any medical procedure that may Have required transfusion recently?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($question['q5']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "6", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you recently traveled to any areas known for infectious diseases?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($question['q6']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "7", 0, 0, 'L');
$pdf->Cell(20, 10, "Do you have any medical conditions that may require a specific type of blood transfusion?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($question['q7']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "8", 0, 0, 'L');
$pdf->Cell(20, 10, "Are you pregnant or have you given birth within the last six months?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($question['q8']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "9", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you experienced any recent symptoms of infection or illness, such as fever or chills?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($question['q9']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "10", 0, 0, 'L');
$pdf->Cell(20, 10, "Do you understand or consent to the risks and benefits of a blood transfusion?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($question['q10']) , 0, 1,'R');
$pdf->Ln(1.5);

$last = $question['last_update_time'];
$convertedate = new DateTime($last);
$days = $today->diff($convertedate)->days;
$pdf->Cell(0, 10, "Last Updated: $days Days Ago", 0, 1,'C');
// $pdf->Ln(5);
$pdf->Image($stamp, 120, $pdf->GetY()-20 ,60);

$pdf->SetFont('Times', 'BI', 12);
$pdf->Cell(0, 10, "(Generated On :".$today->format('Y-m-d').")", 0, 1,'C');

} 

else if( $_GET['action'] == 'donor-questionnaire'){

$sql = " SELECT questionnaire.id, last_update_time, d_id, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10,
        donor.`fname`, donor.`lname`, donor.`email`, donor.`address`, donor.`county`, donor.`phone`
        FROM questionnaire 
        JOIN donor ON donor.`id` = questionnaire.`d_id`
        WHERE d_id IS NOT NULL AND questionnaire.id = ?;";
// Prepare a select statement
 $stmnt = mysqli_prepare($conn, $sql);
 mysqli_stmt_bind_param($stmnt, 'i', $question);
 mysqli_stmt_execute($stmnt);
 $results = mysqli_stmt_get_result($stmnt);
 if ($rows = mysqli_fetch_assoc($results)) {
   $dquestion = $rows;
 }

 // Bind the result variables
//  mysqli_stmt_bind_result($stmt, $qid, $update_time, $patient, $q1, $q2, $q3,$q4, $q5, $q6, $q7, $q8, $q9, $q10, $patient_fname, $patient_lname, $patient_mail, $patient_addr);


$pdf->SetFont('Times', 'B', 12);

// Set font and font size
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20, 10, "Donor: ", 0, 0, 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40, 10, strtoupper($dquestion['fname']." ".$dquestion['lname']), 0, 0);
$pdf->Cell(100, 10, "Last Updated On:", 0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(20, 10, $dquestion['last_update_time'] , 0, 1,'R');

$pdf->SetFont('Times','B',9);
$pdf->Cell(20, 5, "Address: ". $dquestion['address'], 0, 0, 'L');
$pdf->Cell(160, 5, "Mail: ". $dquestion['email'], 0, 1, 'R');

$pdf->Cell(20, 5, "County: ". $dquestion['county'], 0, 0, 'L');

$pdf->Cell(160, 5, "Phone:  ". $dquestion['phone'], 0, 1, 'R');

$pdf->Ln(1.5);


$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 10, 'DONOR Questionnaire RESPONSE', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','BU',10);

// Add table headers to the PDF
$pdf->Cell(20, 10, "S/No.", 0, 0, 'L');
$pdf->Cell(40, 10, "QUESTION", 0, 0, 'L');
$pdf->Cell(0, 10, "RESPONSE" , 0, 1,'R');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(20, 10, "1", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you traveled outside the country in the past 28 days?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($dquestion['q1']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "2", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you had any tattoos or body piercings in the past 12 months?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($dquestion['q2']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "3", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you had a fever or been sick in the past 48 hours?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($dquestion['q3']), 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "4", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you ever tested positive for HIV/AIDS or other STIs?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($dquestion['q4']), 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "5", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you ever used intravenous drugs, or shared needles with anyone?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($dquestion['q5']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "6", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you ever been diagnosed with hepatitis or jaundice?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($dquestion['q6']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "7", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you had sexual contact with anyone who has tested positive for HIV or hepatitis?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($dquestion['q7']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "8", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you received a blood transfusion or organ transplant in the past 12 months?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($dquestion['q8']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "9", 0, 0, 'L');
$pdf->Cell(20, 10, "Have you ever been diagnosed with a bleeding disorder or taken blood thinners?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($dquestion['q9']) , 0, 1,'R');
$pdf->Ln(1.5);

$pdf->Cell(20, 10, "10", 0, 0, 'L');
$pdf->Cell(20, 10, "Are you a lactating mother or have you given birth recently?", 0, 0, 'L');
$pdf->Cell(0, 10, strtoupper($dquestion['q10']) , 0, 1,'R');
$pdf->Ln(1.5);

$dlast = $dquestion['last_update_time'];
$dconvertedate = new DateTime($dlast);
$ddays = $today->diff($dconvertedate)->days;
$pdf->Cell(0, 10, "Last Updated: $ddays Days Ago", 0, 1,'C');
// $pdf->Ln(5);
$pdf->Image($stamp, 120, $pdf->GetY()-20 ,60);

$pdf->SetFont('Times', 'BI', 12);
$pdf->Cell(0, 10, "(Generated On :".$today->format('Y-m-d').")", 0, 1,'C');

}
}
// Output the PDF document
$pdf->Output();
?>