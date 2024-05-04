<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TruncateAllTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:truncate-all-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->confirm('This will delete all data from all tables in the database. Are you sure you want to proceed?')) {
            DB::beginTransaction();

            try {
                $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

                DB::statement('SET FOREIGN_KEY_CHECKS=0');

                foreach ($tables as $table) {
                    DB::table($table)->truncate();
                }

                DB::statement('SET FOREIGN_KEY_CHECKS=1');

                DB::commit();

                $this->info('All data from all tables has been deleted successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error('An error occurred while truncating tables: ' . $e->getMessage());
            }
        } else {
            $this->info('Operation canceled.');
        }
    }
}
