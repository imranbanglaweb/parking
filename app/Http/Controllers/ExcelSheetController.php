<?php

namespace App\Http\Controllers;

class ExcelSheetController extends Controller
{
  /*  public function index() {
        $this->authorize('excel_import');
        return view('vendor.voyager.excel.generate-form');
    }

    public function insertExcelData() {
        $this->authorize('excel_import');
        return view('vendor.voyager.excel.insert-employee');
    }


    public function excelSheetFormDownloadForEmployee()
    {
        $this->authorize('excel_import');
        $authUser = Auth::user();
        $company = Company::findOrFail($authUser->company_id);
        $designations = $company->designations;
        $departments = Department::select('id', 'name')->where('company_id', $authUser->company_id)->where('status', 1)->get();
        $branches = Branch::select('id', 'name')->where('company_id', $authUser->company_id)->where('status', 1)->get();
        $employeeTypes = EmployeeType::select('id', 'title')->where('company_id', $authUser->company_id)->where('status', 1)->get();

        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(25);

        $objPHPExcel->getActiveSheet()->getStyle('J')
            ->getNumberFormat()
            ->setFormatCode("yyyy/mm/dd");
        $objPHPExcel->getActiveSheet()->getStyle('K')
            ->getNumberFormat()
            ->setFormatCode("yyyy/mm/dd");
        $objPHPExcel->getActiveSheet()->getStyle('L')
            ->getNumberFormat()
            ->setFormatCode("yyyy/mm/dd");
        $objPHPExcel->getActiveSheet()->getStyle('Q')
            ->getNumberFormat()
            ->setFormatCode("yyyy/mm/dd");


        $objPHPExcel->getProperties()->setCreator('Employee Excel Form')
            ->setLastModifiedBy('Employee Excel Form')
            ->setTitle("Employee Excel Upload")
            ->setSubject("Employee Excel Upload for class - " . 'Employee Excel Form')
            ->setDescription("Employee Excel Upload for class - " . 'Employee Excel Form')
            ->setKeywords("Student " . 'Employee Excel Form')
            ->setCategory("Employee Excel Upload");

        $current_date = date('Y-m-d');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'name')
            ->setCellValue('B1', 'employee_no')
            ->setCellValue('C1', 'department_id')
            ->setCellValue('D1', 'designation_id')
            ->setCellValue('E1', 'company_id')
            ->setCellValue('F1', 'branch_id')
            ->setCellValue('G1', 'att_person_id')
            ->setCellValue('H1', 'job_type')
            ->setCellValue('I1', 'employee_type_id')
            ->setCellValue('J1', 'appointment_letter_date')
            ->setCellValue('K1', 'joining_date')
            ->setCellValue('L1', 'confirmation_date')
            ->setCellValue('M1', 'probation_period')
            ->setCellValue('N1', 'salary_type')
            ->setCellValue('O1', 'provident_fund_status')
            ->setCellValue('P1', 'overtime_status')
            ->setCellValue('Q1', 'pf_start_date')
            ->setCellValue('R1', 'gender')

            ->setCellValue('S1', 'father_name')
            ->setCellValue('T1', 'mother_name')
            ->setCellValue('U1', 'mobile')
            ->setCellValue('V1', 'present_address')
            ->setCellValue('W1', 'permanent_address')
            ->setCellValue('X1', 'national_id_no')
            ->setCellValue('Y1', 'date_of_birth')
            ->setCellValue('Z1', 'religion')
            ->setCellValue('AA1', 'blood_group')
            ->setCellValue('AB1', 'marital_status');


        $objPHPExcel->createSheet(1);
        $department_increment = 1;
        foreach ($departments as $key => $department) {
            $tmpDepartment = $department->id . '|' . $department->name;
            $objPHPExcel->setActiveSheetIndex(1)
                ->setCellValue('A' . $department_increment++, $tmpDepartment);
        }

        $objPHPExcel->createSheet(2);
        $designation_increment = 1;
        foreach ($designations as $key => $designation) {
            $tmpDesignation = $designation->id . '|' . $designation->name;
            $objPHPExcel->setActiveSheetIndex(2)
                ->setCellValue('A' . $designation_increment++, $tmpDesignation);
        }

        $objPHPExcel->createSheet(3);
        $branch_increment = 1;
        foreach ($branches as $key => $branch) {
            $tmpBranch = $branch->id . '|' . $branch->name;
            $objPHPExcel->setActiveSheetIndex(3)
                ->setCellValue('A' . $branch_increment++, $tmpBranch);
        }

        $companies = $company->id.'|'. implode(' ', explode(',', $company->title));
        $jobTypes = [
            'full_time' => 'Full Time',
            'part_time' => 'Part Time',
            'contractual' => 'Contractual'
        ];

        $jobType = '';
        foreach ($jobTypes as $key => $type) {
            $jobType .= $key . '|' . $type . ",";
        }

        $employeeType = '';
        foreach ($employeeTypes as $key => $type) {
            $employeeType .= $type->id . '|' . $type->title . ",";
        }

        $salaryType = 'basic | Basic'.','.'gross | Gross';
        $overtimeStatus = 'Yes|Yes'.','.'No|No';
        $providentFundStatus = 'Yes|Yes'.','.'No|No';
        $gender = 'Male|Male'.','.'Female|Female';

        $namePrefix = 'Mr.|Mr.'.','.'Ms.|Ms.'.','.'Md.|Md.'.','.'Dr.|Dr.';

        $religion = 'Islam|Islam'.','.'Hinduism|Hinduism'.','.'Christianity|Christianity'.','.
            'Buddhism|Buddhism'.','.'Judaism|Judaism'.','.'Sikhism|Sikhism'.','.'Jainism|Jainism'.
            ','.'Confucianism|Confucianism'.','.'Others|Others';
        $bloodGroup = 'A+|A+'.','.'B+|B+'.','.'O+|O+'.','.'AB+|AB+'.','.
            'A-|A-'.','.'B-|B-'.','.'O-|O-'.','.'AB-|AB-';
        $maritalStatus = 'Married|Married'.','.'Unmarried|Unmarried'.','.'Divorced|Divorced';


        for ($i = 2; $i <= 500; $i++) {
            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('C' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $f1 = '$A:$A';
            $objValidation->setFormula1("='Worksheet 1'!$f1");

            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('D' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $f2 = '$A:$A';
            $objValidation->setFormula1("='Worksheet 2'!$f2");

            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('E' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $objValidation->setFormula1('"' . $companies . '"');

            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('F' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $f3 = '$A:$A';
            $objValidation->setFormula1("='Worksheet 3'!$f3");

            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('H' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $objValidation->setFormula1('"' . $jobType . '"');

            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('I' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $objValidation->setFormula1('"' . $employeeType . '"');

            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('N' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $objValidation->setFormula1('"' . $salaryType . '"');

            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('O' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $objValidation->setFormula1('"' . $providentFundStatus . '"');

            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('P' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $objValidation->setFormula1('"' . $overtimeStatus . '"');

            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('R' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $objValidation->setFormula1('"' . $gender . '"');


            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('Z' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $objValidation->setFormula1('"' . $religion . '"');

            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('AA' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $objValidation->setFormula1('"' . $bloodGroup . '"');

            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('AB' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $objValidation->setFormula1('"' . $maritalStatus . '"');

        }

        $fileName = 'employee-excel-form.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$fileName");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = new Xlsx($objPHPExcel);
        return $writer->save('php://output');
    }
    public function uploadEmployee(Request $request) {
        $this->authorize('excel_import');
        $user = Auth::user();
        if($request->hasFile('employee_excel')){
            $data = Excel::toArray(new ExcelImport,request()->file('employee_excel'));
            unset($data[0][0]);
            $employees = [];
            $peoples = [];
            $invalid = 0;
            foreach($data[0] as $key => $value) {
                $people = [];
                $employee = [];
                $employee['name'] = trim($value[0]);
                $employee['employee_no'] = trim($value[1]);

                $employee['department_id'] = $value[2] ? trim(explode('|', $value[2])[0]) : null;
                $employee['designation_id'] = $value[3] ? trim(explode('|', $value[3])[0]) : null;
                $employee['company_id'] = $value[4] ? trim(explode('|', $value[4])[0]) : null;
                $employee['branch_id'] = $value[5] ? trim(explode('|', $value[5])[0]) : null;

                $employee['att_person_id'] = trim($value[6]);
                $employee['job_type'] = $value[7] ? trim(explode('|', $value[7])[0]) : 'full_time';
                $employee['employee_type_id'] = $value[8] ? trim(explode('|', $value[8])[0]) : null;

                $appointment = is_numeric($value[9]) ? trim(($value[9] - 25569) * 86400) : null;
                $employee['appointment_letter_date'] = gmdate("Y-m-d", $appointment);

                $joining = is_numeric($value[10]) ? trim(($value[10] - 25569) * 86400) : null;
                $employee['joining_date'] = gmdate("Y-m-d", $joining);

                $confirmation = is_numeric($value[11]) ? trim(($value[11] - 25569) * 86400) : null;
                $employee['confirmation_date'] = gmdate("Y-m-d", $confirmation);
                $employee['probation_period'] = trim($value[12]);
                $employee['salary_type'] = $value[13] ? trim(explode('|', $value[13])[0]) : 'basic';
                $employee['provident_fund_status'] = $value[14] ? trim(explode('|', $value[14])[0]) : 'No';
                $employee['overtime_status'] = $value[15] ? trim(explode('|', $value[15])[0]) : 'No';

                $pf = is_numeric($value[16]) ? trim(($value[16] - 25569) * 86400) : null;
                $employee['pf_start_date'] = gmdate("Y-m-d", $pf);
                $employee['gender'] = $value[17] ? trim(explode('|', $value[17])[0]) : 'Male';


                if($value[0]) {
                    $name = explode(' ', $value[0]);
                }

                $people['created_company_id'] = $user->company_id;
                $people['first_name'] = isset($name[0]) ? trim($name[0]) : '.';
                $people['middle_name'] = isset($name[1]) ? trim($name[1]) : '.';
                $people['last_name'] = isset($name[2]) ? trim($name[2]) : '.';
                $people['nationality'] = 'Bangladesh';
                $people['gender'] = $value[17] ? trim(explode('|', $value[17])[0]) : 'Male';

                $people['father_name'] = trim($value[18]);
                $people['mother_name'] = trim($value[19]);
                $people['mobile'] = trim($value[20]);
                $people['present_address'] = trim($value[21]);
                $people['permanent_address'] = trim($value[22]);
                $people['national_id_no'] = trim($value[23]);
                $people['date_of_birth'] = trim($value[24]);
                $people['religion'] = $value[25] ? trim(explode('|', $value[25])[0]) : null;
                $people['blood_group'] = $value[26] ? trim(explode('|', $value[26])[0]) : null;
                $people['marital_status'] = $value[27] ? trim(explode('|', $value[27])[0]) : null;

                // Checking valid relational data.
                $company = Company::findOrFail($employee['company_id']);
                $b = count($company->branches->where('id', $employee['branch_id']));
                $t = count(EmployeeType::where('id', $employee['employee_type_id'])->where('company_id', $employee['company_id'])->get());
                $d = count(Department::where('id', $employee['department_id'])->where('company_id', $employee['company_id'])->where('branch_id', $employee['branch_id'])->get());
                $deg = count($company->designations->where('id', $employee['designation_id']));

                if($b && $t && $d && $deg) {
                    $employees[] =  $employee;
                    $peoples[] = $people;
                } else {
                    $invalid ++;
                }
            }

            $count = 0;
            $refused = 0;
            for($i = 0; $i < sizeof($peoples); $i++) {
                if(!Employee::where('employee_no', $employees[$i]['employee_no'])->exists()) {
                    DB::beginTransaction();
                    try {
                        $person = Person::create($peoples[$i]);
                        $person->employee()->create($employees[$i]);

                        DB::commit();
                        $count++;
                    } catch (\Exception $e) {
                        DB::rollback();
                        return back()->with([
                            'message' => 'Something wrong. Please try again.',
                            'alert-type' => 'error',
                        ]);
                    }
                } else {
                    $refused ++;
                }
            }
            return back()->with([
                'message' => $count. ' Data successfully uploaded. ' .$refused. ' Data Refused or already exist.! ' .$invalid. ' Invalid Data.!',
                'alert-type' => 'success'
            ]);
        }
        return back()->with(['message' => 'No data to upload. Please try again', 'alert-type' => 'error']);
    }

    public function excelSheetFormDownloadForDesignation() {
        $this->authorize('excel_import');
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(28);


        $objPHPExcel->getProperties()->setCreator('Designation Excel Form')
            ->setLastModifiedBy('Designation Excel Form')
            ->setTitle("Designation Excel Upload")
            ->setSubject("Designation Excel Upload for class - " . 'Designation Excel Form')
            ->setDescription("Designation Excel Upload for class - " . 'Designation Excel Form')
            ->setKeywords("Employee " . 'Designation Excel Form')
            ->setCategory("Designation Excel Upload");

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'code')
            ->setCellValue('B1', 'name');


        $fileName = 'designation-excel-form.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$fileName");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = new Xlsx($objPHPExcel);
        return $writer->save('php://output');
    }
    public function uploadDesignation(Request $request) {
        $this->authorize('excel_import');
        $user = Auth::user();
        if($request->hasFile('designation_excel')){
            $data = Excel::toArray(new ExcelImport,request()->file('designation_excel'));
            unset($data[0][0]);
            $designations = [];
            foreach($data[0] as $key => $value) {
                $designation = [];
                $designation['code'] = trim($value[0]);
                $designation['name'] = trim($value[1]);

                $designations[] = $designation;
            }

            $count = 0;
            $refused = 0;
            foreach($designations as $key => $designation) {
                if(!Designation::where('code', $designation['code'])->exists()) {
                    $desig = new Designation;
                    $desig->code = $designation['code'];
                    $desig->name = $designation['name'];

                    DB::beginTransaction();
                    try {
                        $desig->save();
                        DB::commit();
                        $count++;
                    } catch (\Exception $e) {
                        DB::rollback();
                        return back()->with([
                            'message' => 'Something wrong. Please try again.',
                            'alert-type' => 'error',
                        ]);
                    }
                } else {
                    $refused ++;
                }
            }
            return back()->with(['message' => $count. ' Data successfully uploaded. ' .$refused. ' Data Refused or already exist!!!', 'alert-type' => 'success']);
        }
        return back()->with(['message' => 'No data to upload. Please try again', 'alert-type' => 'error']);
    }

    public function excelSheetFormDownloadForDepartment() {
        $this->authorize('excel_import');
        $authUser = Auth::user();
        $company = Company::findOrFail($authUser->company_id);
        $branches = Branch::select('id', 'name')->where('company_id', $authUser->company_id)->where('status', 1)->get();

        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(28);


        $objPHPExcel->getProperties()->setCreator('Department Excel Form')
            ->setLastModifiedBy('Department Excel Form')
            ->setTitle("Department Excel Upload")
            ->setSubject("Department Excel Upload for class - " . 'Department Excel Form')
            ->setDescription("Department Excel Upload for class - " . 'Department Excel Form')
            ->setKeywords("Employee " . 'Department Excel Form')
            ->setCategory("Department Excel Upload");

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'code')
            ->setCellValue('B1', 'name')
            ->setCellValue('C1', 'company_id')
            ->setCellValue('D1', 'branch_id');

        $companies = $company->id.'|'. implode(' ', explode(',', $company->title));
        $branch = '';
        foreach ($branches as $key => $value) {
            $branch .= $value->id . '|' . $value->name . ",";
        }


        for ($i = 2; $i <= 500; $i++) {
            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('C' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $objValidation->setFormula1('"' . $companies . '"');

            $objValidation = $objPHPExcel->setActiveSheetIndex(0)->getCell('D' . $i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list');
            $objValidation->setFormula1('"' . $branch . '"');
        }


        $fileName = 'department-excel-form.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$fileName");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = new Xlsx($objPHPExcel);
        return $writer->save('php://output');
    }
    public function uploadDepartment(Request $request) {
        $this->authorize('excel_import');
        if($request->hasFile('department_excel')){
            $data = Excel::toArray(new ExcelImport,request()->file('department_excel'));
            unset($data[0][0]);
            $departments = [];
            foreach($data[0] as $key => $value) {
                $department = [];
                $department['code'] = trim($value[0]);
                $department['name'] = trim($value[1]);
                $department['company_id'] = $value[2] ? trim(explode('|', $value[2])[0]) : null;
                $department['branch_id'] = $value[3] ? trim(explode('|', $value[3])[0]) : null;

                $departments[] = $department;
            }

            $count = 0;
            $refused = 0;
            foreach($departments as $key => $department) {
                $branch = Branch::where('id', $department['branch_id'])->where('company_id', $department['company_id'])->exists();
                if($branch) {
                    if(!Department::where('code', $department['code'])->exists()) {
                        $dep = new Department;
                        $dep->code = $department['code'];
                        $dep->name = $department['name'];
                        $dep->company_id = $department['company_id'];
                        $dep->branch_id = $department['branch_id'];

                        DB::beginTransaction();
                        try {
                            $dep->save();
                            DB::commit();
                            $count++;
                        } catch (\Exception $e) {
                            DB::rollback();
                            return back()->with([
                                'message' => 'Something wrong. Please try again.',
                                'alert-type' => 'error',
                            ]);
                        }
                    } else {
                        $refused ++;
                    }
                } else {
                    return back()->with(['message' => 'Data not valid. Please try again', 'alert-type' => 'error']);
                }
            }

            return back()->with(['message' => $count. ' Data successfully uploaded. ' .$refused. ' Data Refused or already exist!!!', 'alert-type' => 'success']);
        }
        return back()->with(['message' => 'No data to upload. Please try again', 'alert-type' => 'error']);
    }*/
}
