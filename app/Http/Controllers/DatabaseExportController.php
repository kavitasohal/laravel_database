<?php

namespace App\Http\Controllers;
use DB;
use App\DatabaseExport;
use App\user;
use App\password_reset;
use Backup;
use Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Database\Connection;
use IIlluminate\Support\Collection;


//use Cornford\Backup\Backup as Backup;

class DatabaseExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
    public function index($connection = null)
    {
		
		//
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $connection = null;
		$button = $request->input('submit');
		if($button == "Export database"){
			// GET ALL Databases name
			$databases= DatabaseExport::getdatabases(); 
			foreach($databases as $database){
				  $database_name = $database->Database;
							// CREATE AND OPEN CSV FILE FOR BACKUP backup\CSV
							
						 $backup_file =base_path('backup/CSV/').$database_name . date("Y-m-d-H-i-s") . '.csv';
							$handle = fopen($backup_file, 'w+');
							 fputcsv($handle,array($database_name));
							
						$database_tables = DatabaseExport::getdatabase_tables_names($database_name,$handle);
						fclose($handle);
			}
			return redirect()->back()->with('success', 'Database is Exported under Backup Folder');	
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DatabaseExport  $databaseExport
     * @return \Illuminate\Http\Response
     */
    public function show(DatabaseExport $databaseExport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DatabaseExport  $databaseExport
     * @return \Illuminate\Http\Response
     */
    public function edit(DatabaseExport $databaseExport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DatabaseExport  $databaseExport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DatabaseExport $databaseExport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DatabaseExport  $databaseExport
     * @return \Illuminate\Http\Response
     */
    public function destroy(DatabaseExport $databaseExport)
    {
        //
    }
}
