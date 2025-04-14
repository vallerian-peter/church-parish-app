<?php

namespace App\Http\Controllers;

use App\Imports\MembersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class adminImportsManipulations extends Controller
{

    public function adminAddExcelManyMembers(Request $request)
    {
        // Validate file presence and type
        $validator = Validator::make($request->all(), [
            'membersExcel' => 'required|mimes:xlsx,csv,xls'
        ], [
            'membersExcel.required' => 'Tafadhali chagua faili la Excel.',
            'membersExcel.mimes'    => 'Faili linapaswa kuwa la aina ya: xlsx, csv, au xls.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Excel::import(new MembersImport, $request->file('membersExcel'));
            return redirect()->back()->with('success', 'Washirika wamesajiliwa kikamilifu.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errors = [];
            foreach ($failures as $failure) {
                $row = $failure->row(); // row number
                $attribute = $failure->attribute(); // attribute index
                $messages = implode(', ', $failure->errors()); // error messages

                $errors[] = "Mstari wa $row, kipengele ($attribute): $messages";
            }

            return redirect()->back()->with('error', 'Hitilafu zimetokea wakati wa usajili:')->with('import_errors', $errors);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Kuna tatizo kwenye faili au mfumo: ' . $e->getMessage());
        }
    }
}
