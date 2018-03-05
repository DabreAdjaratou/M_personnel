<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\PersonnelTable;
use Application\Form\PersonnelForm;
use Application\Model\Personnel;
use Zend\Session\Container;

class PersonnelController extends AbstractActionController {

    private $table;

    public function __construct(PersonnelTable $table) {
        $this->table = $table;
    }

    public function indexAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action' => 'redirection'));

        return new ViewModel([
            'personnels' => $this->table->fetchAll(),
        ]);
    }

    public function addAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action' => 'redirection'));

        $form = new PersonnelForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        $regions = $this->table->getRegions();

        if (!$request->isPost()) {
            return ['form' => $form, 'regions' => $regions];
        }

        $personnel = new Personnel();
        $form->setInputFilter($personnel->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form, 'regions' => $regions];
        }

        $personnel->exchangeArray($form->getData());
        $select_time = $request->getPost('select_time');
        $training_length = $request->getPost('select_time2');
        $personnel->time_worked = $personnel->time_worked . ' ' . $select_time;
        $personnel->length_of_training = $personnel->length_of_training . ' ' . $training_length;
        $this->table->savePersonnel($personnel);
        $container = new Container('alert');
        $container->alertMsg = 'Personnel added successfully!';
        return $this->redirect()->toRoute('personnel');
    }

    public function updateAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action' => 'redirection'));

        $id = (int) base64_decode($this->params()->fromRoute('id', 0));

        if (0 === $id) {
            return $this->redirect()->toRoute('personnel', ['action' => 'add']);
        }

        try {
            $personnel = $this->table->getPersonnel($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('personnel', ['action' => 'index']);
        }

        $form = new PersonnelForm();
        $time_worked = explode(' ', $personnel->time_worked);
        $time_worked_no = $time_worked[0];
        $time_worked_unit = $time_worked[1];

        $training_length = explode(' ', $personnel->length_of_training);
        $training_length_no = $training_length[0];
        $training_length_unit = $training_length[1];

        $personnel->time_worked = $time_worked_no;
        $personnel->length_of_training = $training_length_no;
//        die($personnel->district);
        $form->bind($personnel);
        $form->get('submit')->setAttribute('value', 'Update');
        $request = $this->getRequest();
        $regions = $this->table->getRegions();
        $district = $this->table->DistrictName($personnel->district);
        $viewData = ['id' => $id, 'form' => $form, 'regions' => $regions, 'time_worked_unit' => $time_worked_unit, 'training_length_unit' => $training_length_unit,
            'district_id' => $district['district_id'], 'district_name' => $district['district_name'],];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($personnel->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }
        $select_time = $request->getPost('select_time');
        $training_length = $request->getPost('select_time2');
        $personnel->time_worked = $personnel->time_worked . ' ' . $select_time;
        $personnel->length_of_training = $personnel->length_of_training . ' ' . $training_length;
        $this->table->savePersonnel($personnel);
        $container = new Container('alert');
        $container->alertMsg = 'Updated successfully!';

        return $this->redirect()->toRoute('personnel', ['action' => 'index']);
    }

    public function deleteAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action' => 'redirection'));

        $id = (int) base64_decode($this->params()->fromRoute('id', 0));
        if (!$id) {
            return $this->redirect()->toRoute('personnel');
        }
        $this->table->deletePersonnel($id);
        $container = new Container('alert');
        $container->alertMsg = 'Deleted successfully!';

        return $this->redirect()->toRoute('personnel');
    }

    public function districtAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action' => 'redirection'));

        $q = (int) $_GET['q'];
        $result = $this->table->getDistrict($q);
        return array(
            'result' => $result,
        );
    }

    public function reportAction() {

        $form = new PersonnelForm();
        $form->get('submit')->setValue('GET REPORT');
        $request = $this->getRequest();
        $regions = $this->table->getRegions();

        if ($request->isPost()) {
            $affiliation = $request->getPost('affiliation');
            $current_job = $request->getPost('current_jod');
            $type_of_training = $request->getPost('type_of_training');
            $region = $request->getPost('region');
            $district = $request->getPost('district');

            $personnel = $this->table->report($affiliation, $current_job, $type_of_training, $region, $district);
            $objPHPExcel = new \PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            
           
            $styleArray = array(
                'font' => array(
                    'bold' => true,
                    'size' => 11,
                    'name' => 'Verdana',
            ));
            $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($styleArray); //apply style from array style array
            $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THICK); // set cell border

//            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(17); // row dimension
            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(35);

            $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(25);

            $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFF8DC'); //column fill



            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Last name');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'First name');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Middle name');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Phone');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Email');
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Region');
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'District');
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Affiliation');
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Current job title');
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Last training date');
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Type of trainig');
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Length of training');
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Training organization');
            $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'training certificate');
            $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Date training certificate issued');
            $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Time worked as (assessor/auditor)');



//
            $ligne = 2;
            foreach ($personnel as $personnel) {
//           
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $ligne, $personnel['last_name']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $ligne, $personnel['first_name']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $ligne, $personnel['middle_name']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $ligne, $personnel['phone']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $ligne, $personnel['email']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $ligne, $personnel['region_name']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $ligne, $personnel['district_name']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $ligne, $personnel['affiliation']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $ligne, $personnel['current_jod']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $ligne, $personnel['last_training_date']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $ligne, $personnel['type_of_training']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $ligne, $personnel['length_of_training']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $ligne, $personnel['training_organization']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $ligne, $personnel['training_certificate']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $ligne, $personnel['date_certificate_issued']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $ligne, $personnel['time_worked']);
                $ligne++;
            }
            $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getAlignment()->setWrapText(true); // make a new line in cell
            $objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  //center column contain

            $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . date('d-m-Y') . '_personnel_report.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
            exit;
        }
        return array('form' => $form, 'regions' => $regions);
    }

}
