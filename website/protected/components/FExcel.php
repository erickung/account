<?php
require Yii::getPathOfAlias('application.components.PHPExcel') . DS . 'PHPExcel.php';
class FExcel
{
	
	public static function buildWriter($title='下载', $subject='下载')
	{
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
		->setLastModifiedBy("erickung")
		->setTitle("Office 2007 XLSX Test Document")
		->setSubject("Office 2007 XLSX Test Document")
		->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
		
		$obj = new self();
		$obj->objPHPExcel = $objPHPExcel;
		return $obj;
	}
	
	public static function buildReader($file)
	{
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load($file);
		$obj = new self();
		$obj->objPHPExcel = $objPHPExcel;
		return $obj;
	}
	
	public function getExcelData()
	{
		$rnt = array();
		foreach ($this->objPHPExcel->getWorksheetIterator() as $worksheet) {
			foreach ($worksheet->getRowIterator() as $i => $row) {
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
				foreach ($cellIterator as $j => $cell) {
					if (!is_null($cell)) {
						if (!is_null($v = $cell->getCalculatedValue()))
							$rnt[$i][$j] = $v;
					//echo '        Cell - ' , $cell->getCoordinate() , ' - ' , $cell->getCalculatedValue() , EOL;
					}
				}
			}
		}
		
		return $rnt;
	}
	
	private $objPHPExcel;
}