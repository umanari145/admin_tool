<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ScanTerminalService;
use App\Form\FormValid;
use Validator;

class ScanTerminalController extends ApiBasicController
{
    public function index(Request $request)
    {
        $formValid = new FormValid('scan_terminal/index.yaml');
        $requestData = $request->all();

        $validateResult =  Validator::make($requestData, $formValid->getValidRule());

        if ($validateResult->fails()) {
            return $this->retValidResponse($validateResult);
        }

        $scanTerminalService = new ScanTerminalService();
        $res = $scanTerminalService->getScanTerminalList($requestData);
        $this->convertPaginateData($res);
        return $this->retServiceResponse($res);
    }

    public function store(Request $request)
    {
        $formValid = new FormValid('scan_terminal/create.yaml');
        $requestData = $request->all();

        $validateResult =  Validator::make($requestData, $formValid->getValidRule());
        if ($validateResult->fails()) {
            return $this->retValidResponse($validateResult);
        }

        $scanTerminalService = new ScanTerminalService();
        $res = $scanTerminalService->registScanTerminal($requestData);

        return $this->retServiceResponse($res);
    }

    public function update(string $scan_terminal_id, Request $request)
    {
        $requestData = $request->all();

        $formValid = new FormValid('scan_terminal/update.yaml');
        $validRequestData = array_merge($requestData['updateData'], ['scan_terminal_id' => $scan_terminal_id]);
        $validateResult =  Validator::make($validRequestData, $formValid->getValidRule());

        if ($validateResult->fails()) {
            return $this->retValidResponse($validateResult);
        }

        $scanTerminalService = new ScanTerminalService();
        $res = $scanTerminalService->updateScanTerminal($scan_terminal_id, $requestData['updateData']);

        return $this->retServiceResponse($res);
    }

    public function delete(Request $request)
    {
        $requestData = $request->all();
        $formValid = new FormValid('scan_terminal/delete.yaml');
        $validateResult =  Validator::make($requestData, $formValid->getValidRule());

        if ($validateResult->fails()) {
            return $this->retValidResponse($validateResult);
        }

        $csvService = new ScanTerminalService();
        $res = $csvService->deleteScanTerminal($requestData['delete_ids']);

        return $this->retServiceResponse($res);
    }
}
