<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editor extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('auths');
        $this->load->model('dbconfig');
        $this->db = $this->dbconfig->db();
    }

    public function index(){
        
    }

    public function download(){
        $file = $this->input->post('file');
        $spreadsheet = $this->reader($file);
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->setIncludeCharts(true);
        $writer->setPreCalculateFormulas(false);
        
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$this->input->post('name').'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); 
        
        unlink($file);
    }

    public function generate(){
        $file = $this->input->post('file');
        $spreadsheet = $this->reader($file);
        $style = [];
        $data = json_decode( $this->input->post('data'), true);
        foreach($data as $sheet => $cell ){
            $activeWorksheet = $spreadsheet->getSheetByName($sheet);
            foreach($cell as $co => $ce){
                $activeWorksheet->setCellValue($co, $ce['value']);
                if(isset($style['id'.$ce['id']])){
                    $activeWorksheet->getStyle($co)->applyFromArray($style['id'.$ce['id']]);
                } else {
                    $sty = $this->db->select('style')->where('id',$ce['id'])->get('itterate')->result()[0]->style;
                    $sty = json_decode($sty,true);
                    $style['id'.$ce['id']] = $this->style($sty);
                    $activeWorksheet->getStyle($co)->applyFromArray($style['id'.$ce['id']]);
                }
            }
        }

        $path = $this->tempSave($spreadsheet, $file);

        echo $path;
    }

    private function reader($file_path){
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setIncludeCharts(true);

        $ss = $reader->load($file_path);
        return $ss;
    }

    private function tempSave($ss, $file) {
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($ss, 'Xlsx');
        $writer->setIncludeCharts(true);
        $writer->setPreCalculateFormulas(false);
        
        $filePath = './template/temp/' . bin2hex(openssl_random_pseudo_bytes(32)) . '.xlsx';
        
        $writer->save($filePath);
        
        $explode = explode('/template/temp', $file);

        if(count($explode) > 1){
            unlink($file);
        }
        return $filePath;
    }

    private function style($style){
        $style_col = [];
        $font = [];
        $alignment = [];
        $borders = [];
        $fill = [];

        if($style['color'] != ""){
            $font['color'] = array('argb' => $style['color']);
        }

        if($style['bold'] == "true"){
            $font['bold'] = true;
        }
        if($style['italic'] == "true"){
            $font['italic'] = true;
        }
        if($style['underline'] == "true"){
            $font['underline'] = true;
        }
        if($style['strikethrough'] == "true"){
            $font['strikethrough'] = true;
        }


        if($style['horizontal'] == "left"){
            $alignment['horizontal'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT;
        }
        if($style['horizontal'] == "center"){
            $alignment['horizontal'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;
        }
        if($style['horizontal'] == "right"){
            $alignment['horizontal'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT;
        }

        if($style['vertical'] == "top"){
            $alignment['vertical'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP;
        }
        if($style['vertical'] == "center"){
            $alignment['vertical'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER;
        }
        if($style['vertical'] == "bottom"){
            $alignment['vertical'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM;
        }

        if($style["top"] == "true"){
            $borders['top'] = ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN];
        }
        if($style["right"] == "true"){
            $borders['right'] = ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN];
        }
        if($style["left"] == "true"){
            $borders['left'] = ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN];
        }
        if($style["bottom"] == "true"){
            $borders['bottom'] = ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN];
        }
        
        
        if($style["cell"] != ""){
            $fill = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => $style["cell"]]
            ];
        }
        
        if(count($font) > 0){
            $style_col['font'] = $font;
        }
        if(count($alignment) > 0){
            $style_col['alignment'] = $alignment;
        }
        if(count($borders) > 0){
            $style_col['borders'] = $borders;
        }
        if(count($fill) > 0){
            $style_col['fill'] = $fill;
        }
        
        return $style_col;
    }


}