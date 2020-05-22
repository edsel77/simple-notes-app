<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\NotesModel;
use App\Exports\NotesExport;
use Maatwebsite\Excel\Facades\Excel;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NotesModel::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            NotesModel::create([
                'note' => $request['note']
            ]);
    
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            DB::beginTransaction();

            NotesModel::where('id', $id)->update([
                'note' => $request['note']
            ]);
    
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();

            NotesModel::where('id', $id)->delete();
    
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function export() 
    {
        // return Excel::download(new NotesExport, 'notes.xlsx');
        // return Excel::download(new NotesExport, 'notes.csv');
        return Excel::download(new NotesExport, 'notes.csv', \Maatwebsite\Excel\Excel::CSV);
        // return 
    }
}
