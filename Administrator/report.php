
<?php
// Include the FPDF library
require('../FPDF/fpdf.php');
include '../dbconfig.php';
session_start();
// Create a new PDF document


if(isset($_GET['action']) && isset($_SESSION['admin_id'])){
    // Get the donor ID from the AJAX request
    // $bank_id = $_GET['bank_id'];
    
    $today = new DateTime();
    $pdf = new FPDF();
    $sql = "SELECT a_role, fname, lname FROM admin WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['admin_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Fetch the results and store the patient details in a variable
    if ($row = mysqli_fetch_assoc($result)) {
      $admin_details = $row;
    }


// Close the statement and database connection
mysqli_stmt_close($stmt);
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
$pdf->SetFont('Times','B',12);
$pdf->cell(200,10,'SYSTEM REPORTS',0,1,'C');
$pdf->Ln(5);


// Set font and font size
$pdf->SetFont('Times','B',9);
$pdf->Cell(20, 5, "Address: 333 - 40100, Maseno", 0, 0, 'L');
$pdf->Cell(160, 5, "Mail: sotieno443@gmail.com", 0, 1, 'R');
$pdf->Cell(20, 5, "County: KISUMU", 0, 0, 'L');
$pdf->Cell(160, 5, "Phone:  +254799699300", 0, 1, 'R');

$pdf->Ln(1.5);
if( $_GET['action'] == 'donor-donations'){
    // Build the SQL query
    $sql = "SELECT donor_donation.`don_date`, donor.`fname`, donor.`lname`, donor.`email`, donor.`phone`, blood_type.`b_name`, pouch.`id`, blood_bank.bank_name
            FROM donor_donation LEFT OUTER JOIN donor ON donor_donation.`donor_id` = donor.`id`
            JOIN blood_type ON donor.`blood_id` = blood_type.`id`
            JOIN blood_bank on blood_bank.id = donor_donation.bank_id
            JOIN pouch ON pouch.`donation_id` = donor_donation.`id`
            WHERE donor_donation.`don_status` = 4";

     // Prepare a select statement
     $stmt = mysqli_prepare($conn, $sql);
          
     // Execute the statement
     mysqli_stmt_execute($stmt);

     // Bind the result variables
     mysqli_stmt_bind_result($stmt, $don_date, $don_fname, $don_lname, $don_mail, $don_phone, $don_blood, $don_pouch, $bankName);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Donations', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(30,10,'Date',1,0);
$pdf->Cell(30,10,'Donor',1,0);
$pdf->Cell(40,10,'Bank',1,0);
$pdf->Cell(40,10,'Contact',1,0);
$pdf->Cell(20,10,'Type',1,0);
$pdf->Cell(20,10,'Pouch',1,1);
$pdf->SetFont('Arial','',9);
    
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,10,$count,1,0);
  $pdf->Cell(30,10,$don_date,1,0);
  $pdf->Cell(30,10,$don_fname." ".$don_lname,1,0);
  $pdf->Cell(40,10,$bankName,1,0);
  $pdf->Cell(40,10,$don_mail,1,0);
  $pdf->Cell(20,10,$don_blood,1,0);
  $pdf->Cell(20,10,"#".$don_pouch,1,1);
  $count++;
  // Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
}else if($_GET['action'] == 'banks'){
 // Prepare a select statement
 $sql = "SELECT blood_bank.`bank_name`, blood_bank.`email`, blood_bank.`phone`, blood_bank.`address`, 
 blood_bank.`county`,  blood_bank.`bank_status`, blood_bank.`officer_id`, CONCAT(officer.`fname`,' ',officer.`lname`) AS full_name
 FROM blood_bank LEFT OUTER JOIN officer ON officer.`id` = blood_bank.`officer_id`";

$stmt = mysqli_prepare($conn, $sql);

// Execute the statement
mysqli_stmt_execute($stmt);

// Bind the result variables
mysqli_stmt_bind_result($stmt, $bank_name, $email, $phone, $address, $county, $bank_status, $officerid, $officername);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Blood Banks', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(5,10,'#',1,0);
$pdf->Cell(30,10,'Bank name',1,0);
$pdf->Cell(35,10,'Address',1,0);
$pdf->Cell(35,10,'Mail',1,0);
$pdf->Cell(25,10,'Phone',1,0);
$pdf->Cell(20,10,'County',1,0);
$pdf->Cell(25,10,'Officer',1,0);
$pdf->Cell(15,10,'Status',1,1);
$pdf->SetFont('Arial','',8);
  
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(5,5,$count,1,0);
  $pdf->Cell(30,5,$bank_name,1,0);
  $pdf->Cell(35,5,trim($address),1,0);
  $pdf->Cell(35,5,$email,1,0);
  $pdf->Cell(25,5,$phone,1,0);
  $pdf->Cell(20,5,$county,1,0);
  $pdf->Cell(25,5,($officerid == Null)? "Not assigned" : "$officername",1,0);
  $pdf->Cell(15,5,userStatus($bank_status),1,1);
$count++;
// Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
}else if($_GET['action'] == 'request-approval'){
  // Prepare a select statement
  $sql = "SELECT req_role,fname,lname,email, phone, reg_date, req_status FROM reg_request";
 
  // Prepare a select statement
  $stmt = mysqli_prepare($conn, $sql);

  // Execute the statement
  mysqli_stmt_execute($stmt);

  // Bind the result variables
  mysqli_stmt_bind_result($stmt, $role, $fname, $lname, $email, $phone, $reg_date, $req_status);
 
 $pdf->SetFont('Times', 'B', 14);
 $pdf->Cell(0, 10, 'Registration Requests', 0, 1, 'C');
 $pdf->Ln(1.5);
 $pdf->SetFont('Arial','B',10);
 
 // Add table headers to the PDF
 $pdf->Cell(10,10,'#',1,0);
 $pdf->Cell(25,10,'Date',1,0);
 $pdf->Cell(35,10,'Full Name',1,0);
 $pdf->Cell(20,10,'Role',1,0);
 $pdf->Cell(50,10,'Mail',1,0);
 $pdf->Cell(25,10,'Phone',1,0);
 $pdf->Cell(25,10,'Status',1,1);
 $pdf->SetFont('Arial','',8);
   
 // Loop through the results and add table rows to the PDF
 $count = 1;
 while (mysqli_stmt_fetch($stmt)) {
   $pdf->Cell(10,5,$count,1,0);
   $pdf->Cell(25,5,$reg_date,1,0);
   $pdf->Cell(35,5,$fname." ".$lname,1,0);
   $pdf->Cell(20,5,($role == "admin")?"Administrator":"Bank Oficer",1,0);
   $pdf->Cell(50,5,$email,1,0);
   $pdf->Cell(25,5,$phone,1,0);
   $pdf->Cell(25,5,getStatus($req_status),1,1);
 $count++;
 // Close the statement and database connection
 //   mysqli_stmt_close($stmt);
 }
 }else if($_GET['action'] == 'patient-appeals'){
    // Build the SQL query
    $sql = "SELECT transfusion.`trans_date`, transfusion.`pouch_id`,blood_bank.bank_name,
            patient.`fname`, patient.lname, patient.`email`, patient.`phone`,
            blood_type.`b_name`
            FROM transfusion LEFT OUTER JOIN patient_appeal ON patient_appeal.`id` = transfusion.`app_id`
            JOIN patient ON patient.`id` = patient_appeal.`patient_id`
            JOIN blood_bank ON blood_bank.id = patient_appeal.bank_id
            JOIN blood_type ON blood_type.`id` = patient_appeal.`blood_id`
            WHERE patient_appeal.`app_status` = 4";
  
     // Prepare a select statement
     $stmt = mysqli_prepare($conn, $sql);
            
     // Execute the statement
     mysqli_stmt_execute($stmt);

     // Bind the result variables
     mysqli_stmt_bind_result($stmt, $app_date, $pat_pouch,$bank_name, $pat_fname, $pat_lname, $pat_mail, $pat_phone, $pat_blood);


$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Patient Transfusions', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(30,10,'Date',1,0);
$pdf->Cell(30,10,'Patient',1,0);
$pdf->Cell(40,10,'Bank Name',1,0);
$pdf->Cell(40,10,'Contact',1,0);
$pdf->Cell(20,10,'Blood',1,0);
$pdf->Cell(20,10,'Pouch',1,1);
$pdf->SetFont('Arial','',9);
    
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,10,$count,1,0);
  $pdf->Cell(30,10,$app_date,1,0);
  $pdf->Cell(30,10,$pat_fname." ".$pat_lname,1,0);
  $pdf->Cell(40,10,$bank_name,1,0);
  $pdf->Cell(40,10,$pat_mail,1,0);
  $pdf->Cell(20,10,$pat_blood,1,0);
  $pdf->Cell(20,10,"#".$pat_pouch,1,1);
  $count++;
  // Close the statement and database connection
//   mysqli_stmt_close($stmt);
  }
}else if($_GET['action'] == 'inter-transfers'){
  // Build the SQL query
  $sql = "SELECT transfer.trans_date, (SELECT bank_name FROM blood_bank WHERE id = transfer.appr_bank) AS approving_bank,  transfer.req_bank, transfer.pouch_id ,pouch.units, inter_bank.quantity, blood_type.b_name,
            blood_bank.bank_name, blood_bank.email, blood_bank.phone
            FROM transfer
            LEFT OUTER JOIN inter_bank ON inter_bank.id = transfer.`inter_bank_id`
            JOIN pouch ON pouch.id = transfer.`pouch_id`
            JOIN blood_type ON blood_type.id = pouch.blood_id
            JOIN blood_bank ON blood_bank.id = transfer.`req_bank`
            WHERE inter_bank.req_status = 1";

   // Prepare a select statement
   $stmt = mysqli_prepare($conn, $sql);
            
   // Execute the statement
   mysqli_stmt_execute($stmt);

   // Bind the result variables
   mysqli_stmt_bind_result($stmt, $trans_date, $appr_bank, $req_bank, $pouch_id, $units, $requested_qty, $blood_name, $bank_name,$bank_mail, $bank_phone);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Inter Bank Transfers', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(20,10,'Date',1,0);
$pdf->Cell(40,10,'Approving Bank',1,0);
$pdf->Cell(40,10,'Requesting Bank',1,0);
$pdf->Cell(30,10,'Blood Type',1,0);
$pdf->Cell(30,10,'Quantity(Q-R)',1,0);
$pdf->Cell(20,10,'Pouch',1,1);
$pdf->SetFont('Arial','',9);
  
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,10,$count,1,0);
  $pdf->Cell(20,10,$trans_date,1,0);
  $pdf->Cell(40,10,$appr_bank,1,0);
  $pdf->Cell(40,10,$bank_name,1,0);
  $pdf->Cell(30,10,$blood_name,1,0);
  $pdf->Cell(30,10,$units." - ".$requested_qty,1,0);
  $pdf->Cell(20,10,"#".$pouch_id,1,1);
$count++;
// Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
}else if($_GET['action'] == 'patients'){
  // Build the SQL query
  $sql = "SELECT patient.id, fname, lname, email, phone, bday, address, county, gender, blood_id, p_status, blood_type.b_name 
  FROM patient 
  LEFT OUTER JOIN blood_type ON blood_type.id = patient.blood_id";

  // Prepare a select statement
  $stmt = mysqli_prepare($conn, $sql);

 // Execute the statement
 mysqli_stmt_execute($stmt);

 // Bind the result variables
 mysqli_stmt_bind_result($stmt, $id, $fname, $lname, $email, $phone, $bday, $address, $county, $gender, $blood_id, $pat_status, $blood_name);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Donors', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(5,10,'#',1,0);
$pdf->Cell(30,10,'Patient name',1,0);
$pdf->Cell(45,10,'Address',1,0);
$pdf->Cell(40,10,'Mail',1,0);
$pdf->Cell(5,10,'G',1,0);
$pdf->Cell(10,10,'BG',1,0);
$pdf->Cell(20,10,'County',1,0);
$pdf->Cell(20,10,'Born',1,0);
$pdf->Cell(15,10,'Status',1,1);
$pdf->SetFont('Arial','',8);
  
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(5,5,$count,1,0);
  $pdf->Cell(30,5,$fname." ".$lname,1,0);
  $pdf->Cell(45,5,$address,1,0);
  $pdf->Cell(40,5,$email,1,0);
  $pdf->Cell(5,5,($gender == "male")?"M":"F",1,0);
  $pdf->Cell(10,5,$blood_name,1,0);
  $pdf->Cell(20,5,$county,1,0);
  $pdf->Cell(20,5,$bday,1,0);
  $pdf->Cell(15,5,userStatus($pat_status),1,1);
$count++;
// Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
}else if($_GET['action'] == 'donors'){
  // Build the SQL query
  $sql = "SELECT donor.id, fname, lname, email, phone, bday, address, county, gender, blood_id, d_status, blood_type.b_name 
          FROM donor  
          LEFT OUTER JOIN blood_type ON blood_type.id = donor.blood_id";

  // Prepare a select statement
  $stmt = mysqli_prepare($conn, $sql);

 // Execute the statement
 mysqli_stmt_execute($stmt);

 // Bind the result variables
 mysqli_stmt_bind_result($stmt, $id, $fname, $lname, $email, $phone, $bday, $address, $county, $gender, $blood_id, $don_status, $blood_name);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Donors', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(5,10,'#',1,0);
$pdf->Cell(30,10,'Donor name',1,0);
$pdf->Cell(45,10,'Address',1,0);
$pdf->Cell(40,10,'Mail',1,0);
$pdf->Cell(5,10,'G',1,0);
$pdf->Cell(10,10,'BG',1,0);
$pdf->Cell(20,10,'County',1,0);
$pdf->Cell(20,10,'Born',1,0);
$pdf->Cell(15,10,'Status',1,1);
$pdf->SetFont('Arial','',8);
  
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(5,5,$count,1,0);
  $pdf->Cell(30,5,$fname." ".$lname,1,0);
  $pdf->Cell(45,5,$address,1,0);
  $pdf->Cell(40,5,$email,1,0);
  $pdf->Cell(5,5,($gender == "male")?"M":"F",1,0);
  $pdf->Cell(10,5,$blood_name,1,0);
  $pdf->Cell(20,5,$county,1,0);
  $pdf->Cell(20,5,$bday,1,0);
  $pdf->Cell(15,5,userStatus($don_status),1,1);
$count++;
// Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
}else if($_GET['action'] == 'officers'){
  // Build the SQL query
// Prepare a select statement
$stmt = mysqli_prepare($conn, "SELECT officer.`fname` AS o_fname, officer.`lname` AS o_lname, 
officer.`email` AS o_mail, officer.`phone` AS o_phone, officer.`o_status`, blood_bank.`id` AS b_id, blood_bank.`bank_name` AS bank_name
FROM officer LEFT OUTER JOIN blood_bank ON  officer.id = blood_bank.`officer_id`");

// Execute the statement
mysqli_stmt_execute($stmt);

// Bind the result variables
mysqli_stmt_bind_result($stmt, $fname, $lname, $email, $phone, $o_status, $bid,$bankname);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Blood Bank Officers', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(30,10,'Officer name',1,0);
$pdf->Cell(45,10,'Email',1,0);
$pdf->Cell(40,10,'Phone',1,0);
$pdf->Cell(40,10,'Bank Name',1,0);
$pdf->Cell(25,10,'Status',1,1);
$pdf->SetFont('Arial','',8);
  
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,5,$count,1,0);
  $pdf->Cell(30,5,$fname." ".$lname,1,0);
  $pdf->Cell(45,5,$email,1,0);
  $pdf->Cell(40,5,$phone,1,0);
  $pdf->Cell(40,5,($bid == Null)? "Not assigned" : "$bankname",1,0);
  $pdf->Cell(25,5,userStatus($o_status),1,1);
$count++;
// Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
}else if($_GET['action'] == 'admins'){
  // Build the SQL query
  $stmt = mysqli_prepare($conn, "SELECT a_role, fname, lname, email, phone, admin_status FROM admin WHERE admin_status = 1");

  // Execute the statement
  mysqli_stmt_execute($stmt);

  // Bind the result variables
  mysqli_stmt_bind_result($stmt, $role, $fname, $lname, $email, $phone, $admin_status);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Administrator', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(30,10,'Admin name',1,0);
$pdf->Cell(45,10,'Email',1,0);
$pdf->Cell(40,10,'Phone',1,0);
$pdf->Cell(40,10,'Role',1,0);
$pdf->Cell(25,10,'Status',1,1);
$pdf->SetFont('Arial','',8);
  
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,5,$count,1,0);
  $pdf->Cell(30,5,$fname." ".$lname,1,0);
  $pdf->Cell(45,5,$email,1,0);
  $pdf->Cell(40,5,$phone,1,0);
  $pdf->Cell(40,5,($role == 'admin')?'Administrator':(($role == 'approval')? 'Approval':'Not Assigned'),1,0);
  $pdf->Cell(25,5,userStatus($admin_status),1,1);
$count++;
// Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
}

else if($_GET['action'] == 'total-blood'){
  // Build the SQL query
    $sql = "SELECT bb.id AS bank_id, bb.bank_name,
            COALESCE(A_pos_total, 0) AS A_pos_total,
            COALESCE(A_neg_total, 0) AS A_neg_total,
            COALESCE(B_pos_total, 0) AS B_pos_total,
            COALESCE(B_neg_total, 0) AS B_neg_total,
            COALESCE(AB_pos_total, 0) AS AB_pos_total,
            COALESCE(AB_neg_total, 0) AS AB_neg_total,
            COALESCE(O_pos_total, 0) AS O_pos_total,
            COALESCE(O_neg_total, 0) AS O_neg_total
            FROM blood_bank bb
            LEFT JOIN (
            SELECT pouch.bank_id,
                SUM(CASE WHEN blood_type.`id` = 1 THEN pouch.units ELSE 0 END) AS A_pos_total,
                SUM(CASE WHEN blood_type.`id` = 2 THEN pouch.units ELSE 0 END) AS A_neg_total,
                SUM(CASE WHEN blood_type.`id` = 3 THEN pouch.units ELSE 0 END) AS B_pos_total,
                SUM(CASE WHEN blood_type.`id` = 4 THEN pouch.units ELSE 0 END) AS B_neg_total,
                SUM(CASE WHEN blood_type.`id` = 5 THEN pouch.units ELSE 0 END) AS AB_pos_total,
                SUM(CASE WHEN blood_type.`id` = 6 THEN pouch.units ELSE 0 END) AS AB_neg_total,
                SUM(CASE WHEN blood_type.`id` = 7 THEN pouch.units ELSE 0 END) AS O_pos_total,
                SUM(CASE WHEN blood_type.`id` = 8 THEN pouch.units ELSE 0 END) AS O_neg_total
        FROM pouch
        LEFT JOIN blood_type ON pouch.blood_id = blood_type.id
        WHERE DATEDIFF(NOW(), fill_date) <= 35 AND pouch_status = 1
        GROUP BY pouch.bank_id
        ) blood_totals ON bb.id = blood_totals.bank_id WHERE bb.bank_status != 2";
    $stmt = mysqli_prepare($conn, $sql);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind the result variables
    mysqli_stmt_bind_result($stmt, $bank_id, $bank_name,$A_pos, $A_neg, $B_pos, $B_neg, $AB_pos, $AB_neg,$O_pos, $O_neg);



$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Blood Across Banks', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(45,10,'Bank Name',1,0);
$pdf->Cell(15,10,'A+',1,0);
$pdf->Cell(15,10,'A-',1,0);
$pdf->Cell(15,10,'B+',1,0);
$pdf->Cell(15,10,'B-',1,0);
$pdf->Cell(15,10,'AB+',1,0);
$pdf->Cell(15,10,'AB-',1,0);
$pdf->Cell(15,10,'O+',1,0);
$pdf->Cell(15,10,'O-',1,0);
$pdf->Cell(15,10,'Total',1,1);
$pdf->SetFont('Arial','',9);
  
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
$total = $A_pos + $A_neg + $B_pos + $B_neg + $AB_pos + $AB_neg + $O_pos + $O_neg;
$pdf->Cell(10,10,$count,1,0);
$pdf->Cell(45,10,$bank_name,1,0);
$pdf->Cell(15,10,$A_pos,1,0);
$pdf->Cell(15,10,$A_neg,1,0);
$pdf->Cell(15,10,$B_pos,1,0);
$pdf->Cell(15,10,$B_neg,1,0);
$pdf->Cell(15,10,$AB_pos,1,0);
$pdf->Cell(15,10,$AB_neg,1,0);
$pdf->Cell(15,10,$O_pos,1,0);
$pdf->Cell(15,10,$O_neg,1,0);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,10,$total,1,1);
$pdf->SetFont('Arial','',9);
$count++;
// Close the statement and database connection
//   mysqli_stmt_close($stmt);
}

 // Build the SQL query
 $sql = "SELECT pouch.`id`, pouch.`fill_date`, (35 - (DATEDIFF(NOW(), fill_date))) AS rem_days, pouch.`units`, pouch.`pouch_status`, blood_bank.`bank_name`, blood_type.`b_name` 
 FROM  pouch
 LEFT OUTER JOIN blood_bank ON pouch.`bank_id` = blood_bank.`id`
 JOIN blood_type ON pouch.`blood_id` = blood_type.`id`
 ORDER BY fill_date ASC";

// Prepare a select statement
$stmt = mysqli_prepare($conn, $sql);
   
// Execute the statement
mysqli_stmt_execute($stmt);

// Bind the result variables
mysqli_stmt_bind_result($stmt, $pouch_code, $fill_date, $rem_days, $pouch_units, $pouch_status, $blood_bank_name, $blood_name);

$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Blood Distribution Inventory', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(20,10,'Fill Date',1,0);
$pdf->Cell(20,10,'Code',1,0);
$pdf->Cell(50,10,'Bank Name',1,0);
$pdf->Cell(40,10,'Blood',1,0);
$pdf->Cell(20,10,'Units',1,0);
$pdf->Cell(30,10,'Status',1,1);
$pdf->SetFont('Arial','',9);

// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
$pdf->Cell(10,10,$count,1,0);
$pdf->Cell(20,10,$fill_date,1,0);
$pdf->Cell(20,10,"#".$pouch_code,1,0);
$pdf->Cell(50,10,$blood_bank_name,1,0);
$pdf->Cell(40,10,$blood_name,1,0);
$pdf->Cell(20,10,$pouch_units,1,0);
$pdf->Cell(30,10,($rem_days <= 0 && $pouch_status == 1)?"Expired":bloodStatus($pouch_status),1,1);
$count++;
// Close the statement and database connection
//   mysqli_stmt_close($stmt);
}

}

$pdf->Ln(20);
$pdf->Image($stamp, 65, $pdf->GetY()-15 ,60);
$pdf->Cell(100, 10, '_______________________', 0, 0,'C');
// $pdf->Cell(50, 10, '--------------------------------------------------------', 0, 1,'C');
$pdf->SetFont('Times','BU',16);
$pdf->Cell(50, 10, $today->format('Y-m-d') , 0, 1,'C');

$pdf->SetFont('Times','BI',12);
$pdf->Cell(100, 10, 'Signature', 0, 0,'C');

$pdf->Cell(50, 10, 'Date', 0, 1,'C');
$pdf->Cell(0, 10, "Report Generated by : ". strtoupper($admin_details['fname']." ".$admin_details['lname']), 0, 1 ,'C');
$pdf->Cell(0, 5, ($admin_details['a_role'] == "admin")?"(Administrator)":"(Approval Manager)" , 0, 1,'C');

}
function getStatus($status) {
    if($status == 0){ 
      return "Pending";
    } else if($status == 1){
      return "Approved";
    } else if($status == 2){
      return "Dissapproved";
    } else if($status == 3){
      return "Cancelled";
    } else{
      return "Completed";
    }
  }
  function bloodStatus($status) {
    if($status == 1){
      return "Active";
    } else if($status == 2){
      return "Removed";
    } else if($status == 3){
      return "Transfused";
    } else{
      return "Transfered";
    }
  }
  function userStatus($status) {
    if($status == 0){
      return "Inactive";
    } else if($status == 1){
      return "Active";
    } else if($status == 2){
      return "Removed";
    } 
  }
// Output the PDF document
$pdf->Output();
?>