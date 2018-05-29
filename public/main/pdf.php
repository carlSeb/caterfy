<?php  
  require '../pdf/fpdf.php';

  /*
  A4 width: 219mm
  default margin: 10mm each side
  writable horizontal: 219 (10*2) = 189mm
  */

  $pdf = new FPDF('P','mm', 'A4');
  $pdf -> AddPage();

  // set font arial to bold 14pt
  $pdf -> SetFont('Arial', 'B', 14);

  // Cell (width, height, text, border, end line, [align = L C R])
  $pdf -> Cell(130, 5, "Caterfy", 0, 0);
  $pdf -> Cell(59, 5, "Invoice", 0, 1); //end of line
  // set font to arial regular 12pt
  $pdf ->SetFont('Arial','', 12);
  $pdf -> Cell(130, 5, "Real Street", 0, 0);
  $pdf -> Cell(59, 5, "", 0, 1); //end of line

  $pdf -> Cell(130, 5, "Tacloban City", 0, 0);
  $pdf -> Cell(25, 5, "Date: ", 0, 0); 
  $pdf -> Cell(34, 5, date('d-M-Y'), 0, 1); //end of line

  $pdf -> Cell(130, 5, "Contact: ", 0, 0);
  $pdf -> Cell(25, 5, "Invoice No.: ", 0, 0); 
  $pdf -> Cell(34, 5, "[1234567]", 0, 1); //end of line

  $pdf -> Cell(130, 5, "Fax: [1234567] ", 0, 0);
  $pdf -> Cell(25, 5, "Customer ID: ", 0, 0); 
  $pdf -> Cell(34, 5, "[1234567]", 0, 1); //end of line

  // make a dummy empty cell as a vertical spacer
  $pdf -> Cell(189, 10, '', 0, 1);
  
  // billing address
  $pdf -> Cell(100, 10, 'Bill to: ', 0, 1);

  // add dummy cell at beginning of each line for indentation
  $pdf -> Cell(10, 5, '', 0, 0);
  $pdf -> Cell(90, 5, '[Name]', 0, 1);

  $pdf -> Cell(10, 5, '', 0, 0);
  $pdf -> Cell(90, 5, '[Company Name]', 0, 1);

  $pdf -> Cell(10, 5, '', 0, 0);
  $pdf -> Cell(90, 5, '[Address]', 0, 1);

  $pdf -> Cell(10, 5, '', 0, 0);
  $pdf -> Cell(90, 5, '[Phone]', 0, 1);

  // make a dummy empty cell as a vertical spacer
  $pdf -> Cell(189, 10, '', 0, 1); //end line

  // invoice contents
  $pdf -> SetFont('Arial', 'B', 12);

  $pdf -> Cell(130, 5, 'Description: ', 1, 0);
  $pdf -> Cell(25, 5, 'Taxable: ', 1, 0);
  $pdf -> Cell(34, 5, 'Amount: ', 1, 1);
  $pdf -> SetFont('Arial', '', 12);

  // Numbers are right aligned so we give 'R' after new line parameter
  $pdf -> Cell(130, 5, 'Ultra Cool Fridge ', 1, 0);
  $pdf -> Cell(25, 5, '-', 1, 0);
  $pdf -> Cell(34, 5, '3,240', 1, 1, 'R'); //end line

  $pdf -> Cell(130, 5, 'Super Clean Dishwasher', 1, 0);
  $pdf -> Cell(25, 5, '-', 1, 0);
  $pdf -> Cell(34, 5, '1,200', 1, 1, 'R'); //end line

  $pdf -> Cell(130, 5, 'Someething Else', 1, 0);
  $pdf -> Cell(25, 5, '-', 1, 0);
  $pdf -> Cell(34, 5, '1,200', 1, 1, 'R'); //end line

  // summary
  $pdf -> Cell(130, 5, '', 0, 0);
  $pdf -> Cell(25, 5, 'Subtotal: ', 0, 0);
  $pdf -> Cell(4, 5, 'P', 0, 0);
  $pdf -> Cell(30, 5, '1,200', 1, 1, 'R'); //end line

  $pdf -> Cell(130, 5, '', 0, 0);
  $pdf -> Cell(25, 5, 'Taxable: ', 0, 0);
  $pdf -> Cell(4, 5, 'P', 0, 0);
  $pdf -> Cell(30, 5, '0', 1, 1, 'R'); //end line

  $pdf -> Cell(130, 5, '', 0, 0);
  $pdf -> Cell(25, 5, 'Tax Rate: ', 0, 0);
  $pdf -> Cell(4, 5, 'P', 0, 0);
  $pdf -> Cell(30, 5, '10%', 1, 1, 'R'); //end line

  $pdf -> Cell(130, 5, '', 0, 0);
  $pdf -> Cell(25, 5, 'Total Due: ', 0, 0);
  $pdf -> Cell(4, 5, 'P', 0, 0);
  $pdf -> Cell(30, 5, '10,000', 1, 1, 'R'); //end line

  $pdf -> Output();

?>