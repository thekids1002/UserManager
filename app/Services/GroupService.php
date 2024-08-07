<?php

namespace App\Services;

use App\Libs\{CSVUtil, ConfigUtil};
use App\Repositories\{GroupRepository, UserRepository};
use Illuminate\Support\Facades\Validator;

class GroupService
{
    protected GroupRepository $groupRepository;

    protected UserRepository $userRepository;

    public function __construct(GroupRepository $groupRepository, UserRepository $userRepository) {
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }

    public function getAll() {
        return $this->groupRepository->getAll();
    }

    public function messages($row, $rowIndex) {
        $messages = [
            'id.numeric' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['ID']),
            'id.digits_between' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['ID']),
            'id.exists' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT094', ['ID']),

            'name.required' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT001', ['Group Name']),
            'name.string' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['Group Name']),
            'name.max' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT002', ['Group Name', 255, mb_strlen($row['name'])]),

            'note.string' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['Group Note']),

            'group_leader_id.required' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT001', ['Group Leader']),
            'group_leader_id.numeric' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['Group Leader']),
            'group_leader_id.digits_between' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['Group Leader']),
            'group_leader_id.exists' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT094', ['Group Leader']),

            'group_floor_number.required' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT001', ['Floor Number']),
            'group_floor_number.numeric' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['Floor Number']),
            'group_floor_number.digits_between' => "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['Floor Number']),
        ];

        return $messages;
    }

    public function validateRow($row, $rules, $rowIndex) {
        
        // OrderSpecChange #128461
        if($row['id'] != '' && $row['deleted_date'] == 'Y'){
            $rules = array_map(function ($item) {
                return array_values(array_filter($item, function ($value) {
                    return $value !== "required";
                }));
            }, $rules);
        }
        
        $validator = Validator::make($row, $rules);
        $validator->setCustomMessages($this->messages($row, $rowIndex));
        $validator->after(function ($validator) use ($row, $rowIndex) {
            if ($row['deleted_date'] != '' && $row['deleted_date'] != 'Y') {
                $validator->errors()->add('deleted_date', "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT010', ['Delete']));
            }

            $groupLeaderId = $row['group_leader_id'];
            $groupLeader = $this->userRepository->findById($groupLeaderId, true);

            if ($groupLeader && $groupLeader->deleted_date != null) {
                $validator->errors()->add('group_leader_id', "Dòng {$rowIndex}:" . ConfigUtil::getMessage('EBT094', ['Group Leader']));
            }
        });

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        return [];
    }

    public function importCsv($filePath) {
        $savedGroups = [];
        $editedGroups = [];
        $errorList = [];

        $savedIDEdit = [];

        $rowIndex = 1;

        $csvUtil = new CSVUtil();

        $file = fopen($filePath, 'r');
        $fileYAMLPath = '/app/Constant/Config/configImport.yml';
        $configName = 'group_import_csv_configs';

        $headersYaml = $csvUtil->getHeaderFromConfigsYAML($fileYAMLPath);
        $headersCSV = $csvUtil->getHeaderCSVFile($file);
        // Case header is empty
        if (empty($headersCSV)) {
            $errorList[] = 'Dòng 1:' . ConfigUtil::getMessage('EBT095');

            return [
                'message' => 'ERROR',
                'data' => $errorList,
            ];
        }
        // compare header of file with header in config
        $checkHeader = $csvUtil->checkHeader($headersYaml, $headersCSV);
        if (! $checkHeader) {
            $errorList[] = 'Dòng 1:' . ConfigUtil::getMessage('EBT095');

            return [
                'message' => 'ERROR',
                'data' => $errorList,
            ];
        }

        $keyYaml = $csvUtil->getKeyYaml($fileYAMLPath, $configName);

        $rules = $csvUtil->getValidation($fileYAMLPath, $configName);
        while ($row = fgetcsv($file)) {
            $rowIndex++;

            if (count($row) != count($headersCSV)) {
                $errorList[] = "Dòng {$rowIndex} :" . ConfigUtil::getMessage('EBT095');
                continue;
            }
            $row = array_combine($keyYaml, $row);
            $rules = array_combine($keyYaml, $rules);
            if (in_array($row['id'], $savedIDEdit)) {
                $errorList[] = "Row {$rowIndex} :" . ConfigUtil::getMessage('EBT057', ['ID']);
                continue;
            }
            // validate row
            $errors = $this->validateRow($row, $rules, $rowIndex);
            if (count($errors) > 0) {
                $errorList[] = $errors;
            } else {
                if ($row['id'] === '') {
                    unset($row['id']);
                    $savedGroups[] = $row;
                } else {
                    // OrderSpecChange #128461
                    // Only proceed with deletion processing (updating the deleted_date field), not updating items that send values
                    $editedGroups[] = $row;
                    
                    $savedIDEdit[] = $row['id'];
                }
            }
        }
        fclose($file);
        if (count($errorList) > 0) {
            return [
                'message' => 'ERROR',
                'data' => $errorList,
            ];
        }

        if (count($savedGroups) > 0) {
            $this->groupRepository->insertMany($savedGroups);
        }

        if (count($editedGroups) > 0) {
            $this->groupRepository->editMany($editedGroups);
        }

        return [
            'message' => 'SUCCESS',
            'data' => [],
        ];
    }
}
