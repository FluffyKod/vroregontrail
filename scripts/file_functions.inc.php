<?php

// Include wp_core
require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

// Include helpful functions
include_once('helpful_functions.php');

require_once 'Classes/PHPExcel.php';
require_once 'Classes/PHPExcel/IOFactory.php';

if (isset($_POST['download-member-list'])) {

  global $wpdb;

  // Will contain all data to be written to the file
  $data = array();

  // Get all students
  $students = $wpdb->get_results("SELECT * FROM vro_users");

  // Go through and add a row for each student
  foreach ($students as $s) {

    $student_row = array();
    $student_row['Förnamn'] = $s->first_name;

    array_push($data, $student_row);

  }

  // filename for download
  $filename = "temp_memberlist.xlsx";
  $filepath = '../misc/' . $filename;

  // Copy the member list template
  copy('../misc/listmall.xlsx', $filepath);

  // Add to the new member list
  $objPHPExcel = PHPExcel_IOFactory::load($filepath);
  $objPHPExcel->setActiveSheetIndex(0);
  $row = $objPHPExcel->getActiveSheet()->getHighestRow()+1;
  //echo $row;
  $objPHPExcel->getActiveSheet()->SetCellValue('A'.$row, 'Anders');
  $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row, 'Karlson');
  $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row, '2002');
  $objPHPExcel->getActiveSheet()->SetCellValue('D'.$row, 'Man');
  $objPHPExcel->getActiveSheet()->SetCellValue('E'.$row, 'Stockholm');
  $objPHPExcel->getActiveSheet()->SetCellValue('F'.$row, '2015-01-01');
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  $objWriter->save($filepath);

  // Download the new member list

  // Remove the new member list

  // Redirect

  echo 'Here';
  exit();

} else {
  send_header('/panel/dashboard');
}
