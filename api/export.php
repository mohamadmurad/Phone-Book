<?php

	require_once 'core/init.php';
	header('Content-Type: text/html; charset=utf-8');
	$temp = new User();
	if($temp->isLoggedIn()){

		if(Input::exists()){

			if(Input::get('op')){

				$op = Input::get('op');
	    		switch ($op) {
    				case 'create-excel':{

		                if(Input::get('data')){
		                    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		                    header("Content-Disposition: attachment; filename=abc.xls");  
		                    header("Expires: 0");
		                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		                    header("Cache-Control: private",false);
		                    echo '<table  id="all-data"  style="border: 1px solid #dee2e6;">'. Input::get('data') . '</table>'; 

		                }else{

		                    echo "Error!";
		                }

		            }

		                break;

		            case 'exportPDF':{

		                if(Input::get('data')){
		                    require_once('../Classes/TCPDF/tcpdf.php');  

				          $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
				          $obj_pdf->SetCreator(PDF_CREATOR);  
				          $obj_pdf->SetTitle("TelePhone Book");  
				          $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
				          $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
				          $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
				          $obj_pdf->SetDefaultMonospacedFont('dejavusans');  
				          $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
				          $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
				          $obj_pdf->setPrintHeader(false);  
				          $obj_pdf->setPrintFooter(false);  
				          $obj_pdf->SetAutoPageBreak(TRUE, 10);  
				          $obj_pdf->SetFont('dejavusans', '', 11);  
				          $obj_pdf->AddPage();  
				          $content = '<table  id="all-data" style="border: 1px solid #dee2e6;">';  
				          $content .= $_POST['data'];  
				          
				          $content .= '</table>';  
				          $obj_pdf->writeHTML($content,true,0,true,0);  
				          $obj_pdf->Output('telephoneBook.pdf', 'I');  

		                }else{

		                    echo "Error!";
		                }

		            }

		                break;

    				default:
    					
    					exit();
    					break;
    			}
			}else {
				exit();
		
			}
		}
	}else{
		exit();
	}