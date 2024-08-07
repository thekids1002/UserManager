<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportCsvRequest;
use App\Libs\{ConfigUtil};
use App\Services\GroupService;

class GroupController extends Controller
{
    protected GroupService $groupService;

    public function __construct(GroupService $groupService) {
        $this->groupService = $groupService;
    }

    public function groupList() {
        $pageTitle = 'Group List';

        $groups = $this->groupService->getAll();
        $groups = $this->pagination($groups);

        $messageNotFound = '';
        if(count($groups) == 0){
            $messageNotFound = 'No Group Found';
        }

        return view('screens.group.list', compact('groups', 'messageNotFound','pageTitle'));
    }

    public function import(ImportCsvRequest $request) {
        if ($request->hasFile('csvFile')) {
            $csvFile = $request->file('csvFile');

            $tempPath = $csvFile->getRealPath();
            $result = $this->groupService->importCsv($tempPath);
            switch ($result['message']) {
                // case 'WRONG_HEADER':
                //     return redirect()->back()->withErrors(ConfigUtil::getMessage('EBT095'))->withInput();
                case 'ERROR':
                    return redirect()->back()->withErrors($result['data'])->withInput();
                case 'SUCCESS':
                    return redirect()->back()->with(['success'=>ConfigUtil::getMessage('EBT092')]);
                default:
                    return redirect()->back();
            }
        }
    }
}
