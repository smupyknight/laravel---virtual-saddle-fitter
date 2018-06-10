<?php

namespace App\Console\Commands;

use App\Breed;
use Illuminate\Console\Command;

class ImportBreeds extends Command
{

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:breeds';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$file = fopen(base_path() . '/storage/app/csvs/breeds.csv', 'r');

		while ($row = fgetcsv($file)) {
			$breed = new Breed;

			$breed->name = $row[0];

			$breed->save();

			$this->info('Imported: ' . $row[0]);
		}

		fclose($file);
	}

}
