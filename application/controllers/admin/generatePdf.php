<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class generatePdf extends CI_Controller {
        public function createPDF()
        {
            // $string = substr($string,20);
            // $fees_id = base64_decode($string);
            // echo $this->input->post('reference_number'); exit;
            $this->load->library('pdf');
            // $html = $this->load->view('GeneratePdfView', [], true);
            $html = '<!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Fees Receipt</title>
                    <style>
                        h1{
                            text-align: center;
                        }
                        table, td{
                            padding: 8px;
                            border: 1px solid black;
                        }
                        .non_amount{
                            text-align: left;
                        }
                        .amount{
                            text-align: right;
                        }
                        table{
                            height: 40% !important;
                        }
                        #headerContent p:nth-child(2){
                            text-align: right;
                        }
                        #headerContent p{
                            display: inline-flex;
                            width: 49.7% !important;
                            margin: 0 auto;
                            // border: 1px solid red;
                        }
                        #headerContent{
                            font-weight: bold;
                            // border: 1px solid green;
                            display: flex;
                            width: 100%;
                            // text-align: right;
                        }
                    </style>
                </head>
                <body>
                    <h1>Birsa Munda Tribal University, Vocational Training Center (V.T.C.) Beside R.T.O. Office, Vavdi Road, Vavdi - Rajpipla, Dist. Narmada, Gujarat</h1>
                    <table width="100%">
                        <thead>
                            <tr>
                                <th colspan="2"><h2>Fee Receipt <hr></h2></th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <div id="headerContent">
                                        <p class="date" style="text-align: left;">Date : '.$this->input->post('date').'</p>
                                        <p class="reference_number">Reference Number : '.$this->input->post('reference_number').'</p>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2" style="border: none;"></td>
                            </tr>
                            <th>Student Name</th>
                            <th class="amount">Fees Amount (<span style="font-family: DejaVu Sans; sans-serif;">₹</span>)</th>
                        </thead>
                        <tbody>
                            <td class="non_amount">'.$this->input->post('student_name').'</td>
                            <td class="amount">'.$this->input->post('fees_amount').'</td>
                        </tbody>
                        <tfoot sytle="bottom: 0;">
                            <tr>
                                <td style="text-align: right; font-weight: bold; border: none;">Total (<span style="font-family: DejaVu Sans; sans-serif;">₹</span>)</td>
                                <td style="text-align: right; font-weight: bold; border: none;">'.$this->input->post('fees_amount').'/-</td>
                            </tr>
                                <td style="border: none; margin: 0; padding: 0;" colspan="2">
                                    <hr style="width: 100%;">
                                </td>
                        </tfoot>
                    </table>
                    <label style="text-align: center; font-style: italic;">This is system generated fee receipt</label>
                </body>
            </html>';
            $this->pdf->createPDF($html, 'Fees_receipt_'.$this->input->post('reference_number'), false);
            $this->pdf->stream('Fees_receipt_'.$this->input->post('reference_number').'.pdf');
        }
    }