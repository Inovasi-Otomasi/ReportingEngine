<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PhpSpreadsheetLibrary {
    public function __construct() {
        // Composer autoloader should already be included in index.php
    }

    public function load($filePath) {
        // Use PhpSpreadsheet's IOFactory to load the file
        $spreadsheet = IOFactory::load($filePath);
        return $spreadsheet;
    }

    public function getSheetNames($spreadsheet) {
        // Get the sheet names
        return $spreadsheet->getSheetNames();
    }
}