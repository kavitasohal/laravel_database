<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;


class DatabaseExport extends Model
{
    // SHOW ALL DATABASE AT HOST
	public function scopegetdatabases($query){
		return $tables_in_db = DB::select('SHOW DATABASES');
	}
	// CREATE NEW DATABASE CONNECTIONS
	// RECONNECT DATABASE CONNECTIONS
	// IMPORT DATABASE (SQL AND CSV FILE)
	public function scopegetdatabase_tables_names($query,$database_name,$handle){
		Config::set("database.connections.mysql_back", [
			"host" => env('DB_HOST'),
			"driver" => env('DB_CONNECTION'),
			"database" => $database_name,
			"username" => env('DB_USERNAME'),
			"password" => env('DB_PASSWORD')
		]);
		DB::reconnect('mysql_back');
		// FOR IMPRTING DATABASE TO SQL FILE
	   $tempLocation     = base_path('backup').'/' .$database_name . '_' . date("Y-m-d_Hi") . '.sql';
       $host = env('DB_HOST');
	   $username = env('DB_USERNAME');
	   $mysql_dump=env('MYSQL_DUMP');
		exec("{$mysql_dump} --opt -h {$host} -u {$username} {$database_name} > " .$tempLocation . " 2>&1", $output);
		// FOR IMPORTING TO CSV FILE
	    $first = DB::connection('mysql_back');
		$tables_in_db = $first->select('SHOW TABLES');
 		$db = "Tables_in_".$database_name;
		$tables=[];
        foreach($tables_in_db as $table){
        $tables[] = $table->{$db};
        }
		foreach($tables as $table => $table_x){
						fputcsv($handle,array( $table_x));
						$columns =$first->select('show columns from ' . $table_x);
						$colums_data=[];
						foreach ($columns as $value) {
							$colums_data[]= $value->Field ;
						}
						fputcsv($handle,	$colums_data);
						$tables_results = $first->table($table_x)->get();
							foreach ($tables_results as $rec=>$rec_data){
								$table_data=[];
								foreach($rec_data as $key=> $value){
									$table_data[]= $value;
								}
								fputcsv($handle, $table_data);
							}
		}
	
	}
	
}
